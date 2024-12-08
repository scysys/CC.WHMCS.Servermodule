<?php
/**
 * Copyright 2017, Centova Technologies Inc.
 */

namespace Centova\Cast\WHMCS;

use WHMCS\Database\Capsule;

class WHMCSDB {

	/**
	 * Generates and saves a new username for the account specified by the Parameters provided.
	 *
	 * @param Parameters $p the parameters for the API call
	 *
	 * @return void
	 */
	public function createUsername(Parameters $p) {
		// generate a unique new username
		$username = $this->generateUniqueUsername($p->get('clientsdetails'));

		$p->set('username',$username);

		$updates = [
			'username' => $username,
		];

		$password = $p->get("password");
		if (!strlen($password)) {
			$password = $this->generatePassword();
			$p->set('password',$password);

			$updates['password'] = encrypt($password);
		}

		Capsule::table('tblhosting')
			->where('id', $p->get('accountid'))
			->update($updates);
	}


	/**
	 * Determines whether a particular username already exists in the WHMCS 'tblhosting'
	 * table.
	 *
	 * @param string $username The username to test.
	 *
	 * @return bool|int	The ID field from the tblhosting table if the username already exists, otherwise false.
	 *
	 */
	private function checkUserExists($username) {
		$id = (int) Capsule::table('tblhosting')->where('username',$username)->value('id');
		return $id ? $id : false;
	}

	/**
	 * Saves the custom fields for an account.
	 *
	 * @param string $username the username for the account
	 * @param array $account the field values for the account
	 */
	public function saveCustomFields($username,$account) {
		$res = Capsule::table('tblhosting')
			->select('id','packageid')
			->where('username', $username)
			->first();
		if (!$res) {
			return;
		}
		$tblhostingid = (int) $res->id;
		$packageid = (int) $res->packageid;

		if ($packageid) {
			$customfields = Capsule::table('tblcustomfields')
				->select('id', 'fieldname')
				->where('relid', $packageid)
				->get();

			foreach ($customfields as $customfield) {
				$fieldname = $customfield->fieldname;
				$fieldid = (int)$customfield->id;

				if (isset($account[$fieldname])) {
					$value = $account[$fieldname];

					Capsule::table('tblcustomfieldsvalues')
						->where([['fieldid', $fieldid], ['relid', $tblhostingid]])
						->delete();

					Capsule::table('tblcustomfieldsvalues')
						->insert([
							'fieldid' => $fieldid,
							'relid' => $tblhostingid,
							'value' => $value
						]);
				}
			}
		}
	}

	/**
	 * Updates the usage for the specified accounts.
	 *
	 * @param array[] $accounts an array of account data
	 * @param int $serverid the ID of the server upon which the accounts are hosted
	 *
	 * @return void
	 */
	public function updateUsage($accounts,$serverid) {
		foreach ($accounts AS $k=>$values) {
			Capsule::table('tblhosting')
				->where([
					[ 'server', $serverid ],
					[ 'username', $values['username'] ]
				])
				->update([
					"diskusage"=>$values['diskusage'],
					"disklimit"=>max(0,$values['diskquota']),
					"bwusage"=>$values['transferusage'],
					"bwlimit"=>max(0,$values['transferlimit']),
					"lastupdate"=>Capsule::raw('now()'),
				]);
	    }
	}

	/**
	 * Generates a pseudorandom password which is occasionally somewhat pronounceable
	 * (never more than 2 consecutive consonants without a vowel) with a randomly-
	 * inserted digit.
	 *
	 * @param int $maxlength the maximum password length
	 *
	 * @return string The generated password.
	 *
	 */
	private function generatePassword($maxlength=8) {
		$vowels = 'aeuy'; // never use i/o which look like 1/l/I/0
		$consonants = 'bcdfghjkmnpqrtvwxz'; // never use l/s which looks like 1/I/5

		$concount = 0;
		$digitpos = rand(0,$maxlength-1);

		$password = '';
		for ($i=0; $i<$maxlength; $i++) {
			$type = rand(0,1);
			if ($type==1) {
				if(  ( ($i==1) || ($i==$maxlength-1) ) && ($concount>0) ) $type = 0;
				if ($concount>1) $type=0;
			} elseif ($concount==0) {
				$type = 1;
			}
			$password .= $type==0 ? $vowels[rand(0,strlen($vowels)-1)] : $consonants[rand(0,strlen($consonants)-1)];
			$concount = ($type==0) ? 0 : $concount+1;
			if ($digitpos==$i) $password .= rand(0,1)==0?rand(3,4):rand(6,9); // never use 1/2/5 which look like I/Z/S
		}

		return $password;
	}

	/**
	 * Generate a username which is unique within WHMCS.
	 *
	 * @internal
	 *
	 * @param array $client The client account details provided by WHMCS.
	 * @param int $minlength The minimum username length.
	 * @param int $maxlength The maximum username length.
	 *
	 * @return string The generated username.
	 */
	private function generateUniqueUsername($client,$minlength=4,$maxlength=8) {
		// the username "stub" (generated from the company name, first/last names, or email)
		// must be at least this long or it will be discarded and a new stub generated
		$min_stub_length = floor($minlength * 0.75);

		if (strlen($client['companyname'])) {
			$companyname = preg_replace('/[^a-z]+/i','',strtolower($client['companyname']));
			$username = substr($companyname,0,$maxlength);
			if (strlen($username)>=$min_stub_length) {
				while (strlen($username)<$minlength) $username .= '0';
				if (!$this->checkUserExists($username)) return $username;
			}
		}

		$firstname = preg_replace('/[^a-z]+/i','',strtolower($client['firstname']));
		$lastname = preg_replace('/[^a-z]+/i','',strtolower($client['lastname']));

		// first try first initial + last name (while honoring min/max length constraints)
		$username = substr( substr($firstname,0,max(1,$maxlength-strlen($lastname))) . $lastname,0,$maxlength);
		if (strlen($username)<$min_stub_length) {
			$email = preg_replace('/[^a-z]+/i','',strtolower($client['email']));
			$username = substr($email,0,$maxlength);
		}
		if (!$this->checkUserExists($username)) return $username;

		// if unavailable, try first initial + last name + (00-99)
		$baseusername = substr($username,0,$maxlength-2);
		for ($i=0; $i<100; $i++) {
			$username = $baseusername . sprintf('%02d',$i);
			if (!$this->checkUserExists($username)) return $username;
		}

		// in the unlikely event that 00-99 are unavailable, go totally random
		do {
			$username = $this->generatePassword();
		} while($this->checkUserExists($username));

		return $username;
	}


}