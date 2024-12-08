<?php
/**
 * Copyright 2017, Centova Technologies Inc.
 */

namespace Centova\Cast\WHMCS;

class Parameters {

	private $params;

	/**
	 * Parameters constructor.
	 *
	 * @param array $params the parameters passed to the API function
	 */
	public function __construct($params) {
		$this->params = $params;
	}

	/**
	 * Retrieves a parameter value.
	 *
	 * @param string $key the name of the parameter
	 *
	 * @return mixed the value of the specified parameter
	 */
	public function get($key) {
		return $this->params[$key];
	}

	/**
	 * Sets a parameter value
	 *
	 * @param string $key the name of the parameter
	 * @param mixed $value the value for the parameter
	 */
	public function set($key, $value) {
		$this->params[$key] = $value;
	}

	/**
	 * Determines the master Centova Cast server in a cluster
	 *
	 * @return array|bool the master server details on success, false if not applicable
	 */
	private function getCastMasterServer() {
		static $parsed = false;

		if (!isset($this->params['configoptions'][CC_TXT_LOCATION])) {
			return false;
		}

		list($targetmasterserverkey,) = explode(':', $this->params['configoptions'][CC_TXT_LOCATION], 2);
		$targetmasterserverkey = strtolower(trim($targetmasterserverkey));

		if (!is_array($parsed)) {

			if (isset($this->params['configoptions'][CC_TXT_REGIONID])) {
				throw new \InvalidArgumentException(sprintf('Both a "%s" configurable option and a "%s" configurable option exist; only one may be specified', CC_TXT_REGIONID, CC_TXT_LOCATION));
			}
			if (isset($this->params['configoptions'][CC_TXT_RPCHOSTID])) {
				throw new \InvalidArgumentException(sprintf('Both a "%s" configurable option and a "%s" configurable option exist; only one may be specified', CC_TXT_RPCHOSTID, CC_TXT_LOCATION));
			}

			$parsed = array();

			$masterservers = explode("\n", trim($this->params['serveraccesshash']));
			foreach ($masterservers as $k => $line) {
				$line = trim($line);
				if (!strlen($line) || $line[0] == '#' || $line[0] == ';') {
					continue;
				}
				list($mskey, $msregionid, $msrpchostid, $msurl) = explode(',', $line, 4);

				if ($msregionid && $msrpchostid) {
					throw new \InvalidArgumentException(sprintf('Both a region ID and hosting server ID are specified for the "%s" server in the "Access hash" field; only one may be specified', $mskey));
				}
				if (!$msregionid && !$msrpchostid) {
					throw new \InvalidArgumentException(sprintf('Neither a region ID nor hosting server ID is specified for the "%s" server in the "Access hash" field; one or the other must be specified', $mskey));
				}

				$mskey = trim(strtolower($mskey));
				$parsed[$mskey] = array(
					'url' => trim($msurl),
					'rpchostid' => (int)trim($msrpchostid),
					'regionid' => (int)trim($msregionid)
				);
			}
		}

		if (isset($parsed[$targetmasterserverkey])) {
			return $parsed[$targetmasterserverkey];
		}

		throw new \InvalidArgumentException(sprintf('A "%s" configurable option is set but its value, "%s", does not exist in the server configuration', CC_TXT_LOCATION, $targetmasterserverkey));
	}

	/**
	 * Returns the complete URL to Centova Cast.
	 *
	 * @return string the URL to Centova Cast.
	 */
	public function getCastURL() {
		$master = $this->getCastMasterServer();

		if (is_array($master)) {
			return $master['url'];
		}

		$ccurl = $this->params['serverhostname'];
		if (preg_match('#^https?://#', $ccurl)) {
			return $this->params['serverhostname'];
		} else {
			return $this->params['serverhttpprefix'] . '://' . $this->params['serverhostname'] . ':' . $this->params['serverport'];
		}

	}

	/**
	 * Obtain the login credentials for the Centova Cast server.
	 *
	 * @param bool $serverapi true if generating credentials for the server API, false for the system API
	 *
	 * @return array an array containing the username and password
	 */
	public function getServerCredentials($serverapi = false) {
		$serverusername = $this->params["serverusername"];
		$serverpassword = $this->params["serverpassword"];

		if (($serverusername != 'admin') || $serverapi) {
			$serverpassword = $serverusername . '|' . $serverpassword;
		}

		return array($serverusername, $serverpassword);
	}

	/**
	 * Generates an array of arguments to pass to the Centova Cast API's account management methods.
	 *
	 * @return array an array of arguments
	 */
	public function getAPIArguments($base_arguments = null) {
		$arguments = is_null($base_arguments) ? [] : $base_arguments;

		$packageid = $this->params["packageid"];

		$templatename = $this->params['configoption1'];
		$maxlisteners = $this->params['configoption2'];
		$maxbitrate = $this->params['configoption3'];
		$xferquota = $this->params['configoption4'];
		$diskquota = $this->params['configoption5'];
		$autostart = $this->params['configoption6'];
		$mountlimit = $this->params['configoption7'];
		$webproxy = $this->params['configoption8'];
		$autodj = $this->params['configoption9'];
		$maxaccounts = $this->params['configoption10'];
		$maxbw = $this->params['configoption11'];

		if (strlen($templatename)) {
			$arguments['template'] = $templatename;
		}

		// optional; if not set, the template values will be used
		if (strlen($maxlisteners)) {
			$arguments['maxclients'] = $maxlisteners;
		}
		if (strlen($maxbitrate)) {
			$arguments['maxbitrate'] = $maxbitrate;
		}
		if (strlen($xferquota)) {
			$arguments['transferlimit'] = $xferquota;
		}
		if (strlen($diskquota)) {
			$arguments['diskquota'] = $diskquota;
		}
		if (strlen($autostart)) {
			$arguments['autostart'] = $autostart == 'yes' ? 1 : 0;
		}
		if (strlen($mountlimit)) {
			$arguments['mountlimit'] = max(1, (int)$mountlimit);
		}
		if (strlen($webproxy)) {
			$arguments['allowproxy'] = strtolower($webproxy[0]) == 'd' ? 0 : 1;
		}
		if (strlen($autodj)) {
			$arguments['usesource'] = is_numeric($autodj) ? $autodj : (strtolower($autodj[0]) == 'd' ? 1 : 2);
		}
		if (strlen($maxaccounts)) {
			$arguments['resellerusers'] = $maxaccounts;
		}
		if (strlen($maxbw)) {
			$arguments['resellerbandwidth'] = $maxbw;
		}

		$addonmap = array(
			CC_TXT_MAXCLIENTS => 'maxclients',
			CC_TXT_MAXBITRATE => 'maxbitrate',
			CC_TXT_XFERLIMIT => 'transferlimit',
			CC_TXT_DISKQUOTA => 'diskquota',
			CC_TXT_MAXBW => 'resellerbandwidth',
			CC_TXT_MAXACCT => 'resellerusers',
			CC_TXT_MOUNTLIMIT => 'mountlimit',
			CC_TXT_REGIONID => 'regionid',
			CC_TXT_RPCHOSTID => 'rpchostid',
			CC_TXT_AUTODJ => 'usesource'
		);

		if (is_array($this->params['configoptions'])) {
			foreach ($this->params['configoptions'] as $caption => $value) {
				if (strlen($value) && isset($addonmap[$caption])) {
					$optionname = $addonmap[$caption];
					if (preg_match('/^\s*([0-9]+?)[:\|]', $value, $matches)) {
						$value = $matches[1];
					} elseif (preg_match('/^\s*([a-z0-9_-]+?)[:\|]', $value, $matches)) {
						$value = $matches[1];
					} else {
						$value = preg_replace('/[^0-9]/', '', $value);
					}
					$arguments[$optionname] = $value;
				}
			}
		}

		$master = $this->getCastMasterServer();

		if (is_array($master)) {
			if ($master['rpchostid']) {
				$arguments['rpchostid'] = $master['rpchostid'];
			} elseif ($master['regionid']) {
				$arguments['regionid'] = $master['regionid'];
			}
		}

		if (empty($arguments['template']) && empty($arguments['regionid']) && empty($arguments['rpchostid'])) {
			throw new \InvalidArgumentException('Missing account template name in WHMCS package configuration for package ' . $packageid . '; check your WHMCS package configuration.');
		}

		return $arguments;
	}

}