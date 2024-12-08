<?php
/*
 * Centova Cast - http://www.centova.com
 * Portions copyright 2006-2017, Centova Technologies Inc.
 * Portions copyright 2006-2007, WHMCompleteSolution
 *
 * Module version 1.4.0
 * for Centova Cast v3.x
 *
 *****************************************************************************
 *
 * Centova Cast server module for WHMCS v7.
 *
 * This module is a derivative of the the example server module provided in the
 * WHMCS server module SDK, with calls to Centova Cast API client code dropped
 * into the relevant functions.
 *
 *****************************************************************************
 */

require_once(__DIR__ . '/lib/class_APIClient.php');
require_once(__DIR__ . '/lib/CastWHMCS/Parameters.php');
require_once(__DIR__ . '/lib/CastWHMCS/WHMCSDB.php');

// this allows internationalization if the client overrides these prior to the
// module being loaded
define('CC_TXT_MAXCLIENTS', 'Max listeners');
define('CC_TXT_MAXBITRATE', 'Max bit rate');
define('CC_TXT_XFERLIMIT', 'Data transfer limit');
define('CC_TXT_DISKQUOTA', 'Disk quota');
define('CC_TXT_MAXBW', 'Max bandwidth');
define('CC_TXT_MAXACCT', 'Max accounts');
define('CC_TXT_MOUNTLIMIT', 'Mount point limit');
define('CC_TXT_REGIONID', 'Server region');
define('CC_TXT_RPCHOSTID', 'Server');
define('CC_TXT_LOCATION', 'Location');
define('CC_TXT_AUTODJ', 'AutoDJ support');


/**
 * Define module related meta data.
 *
 * @api
 * @return array
 */
function centovacast_MetaData()
{
    return [
    'DisplayName' => 'Centova Cast',
    'APIVersion' => '1.1', // Use API Version 1.1
    'RequiresServer' => true, // Set true if module requires a server to work
    'DefaultNonSSLPort' => '2199', // Default Non-SSL Connection Port
    'DefaultSSLPort' => '2199' // Default SSL Connection Port
  ];
}
/**
 * WHMCS configuration options array generation.
 *
 * @api
 * @return array an array of configuration options.
 */
function centovacast_ConfigOptions()
{
    $configarray = [ // i18n?
    'Account template name' => [ 'Type' => 'text', 'Size' => '20', 'Description' => '<br />(create this in Centova Cast)' ],
    'Max listeners' => [ 'Type' => 'text', 'Size' => '5', 'Description' => '(simultaneous)<br />(blank to use template setting)' ],
    'Max bit rate' => [ 'Type' => 'dropdown', 'Options' => ',8,16,20,24,32,40,48,56,64,80,96,112,128,160,192,224,256,320', 'Description' => 'kbps<br />(blank to use template setting)' ],
    'Data transfer limit' => [ 'Type' => 'text', 'Size' => '5', 'Description' => 'MB/month<br />(blank to use template setting)' ],
    'Disk quota' => [ 'Type' => 'text', 'Size' => '5', 'Description' => 'MB<br />(blank to use template setting)' ],
    'Start server' => [ 'Type' => 'dropdown', 'Options' => 'no,yes', 'Description' => '<br>(only used if source is disabled)' ],
    'Mount point limit' => [ 'Type' => 'text', 'Size' => '5', 'Description' => '<br />(blank to use template setting)' ],
    'Port 80 proxy' => [ 'Type' => 'dropdown', 'Options' => ',Enabled,Disabled', 'Description' => '<br />(blank to use template setting)' ],
    'AutoDJ support' => [ 'Type' => 'dropdown', 'Options' => ',Enabled,Disabled', 'Description' => '<br />(blank to use template setting)' ],
    'Max accounts' => [ 'Type' => 'text', 'Size' => '5', 'Description' => '(resellers only)<br />(blank to use template setting)' ],
    'Max bandwidth' => [ 'Type' => 'text', 'Size' => '5', 'Description' => 'kbps (resellers only)<br />(blank to use template setting)' ],
  ];
    return $configarray;
}


/**
 * WHMCS account creation.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_CreateAccount($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $db = new\ Centova\ Cast\ WHMCS\ WHMCSDB();
        list(, $serverpassword) = $p->getServerCredentials();
        $ccurl = $p->getCastURL();

        $username = $p->get('username');

        // no username passed? must be a domain-less package.
        // username is numeric? no idea why that'd be, but users were bitching
        // about it, so we fix that too.
        if (!strlen($username) || is_numeric($username)) {
            $db->createUsername($p);
            $username = $p->get('username');
        }

        $password = $p->get('password');
        $clientsdetails = $p->get('clientsdetails');

        $arguments = $p->getAPIArguments([
      'hostname' => 'auto',
      'ipaddress' => 'auto',
      'port' => 'auto',
      'username' => $username,
      'adminpassword' => $password,
      'sourcepassword' => $password . 'dj',
      'email' => $clientsdetails[ 'email' ],

      'title' => sprintf('%s Stream', strlen($clientsdetails[ 'companyname' ]) ? $clientsdetails[ 'companyname' ] : $clientsdetails[ 'lastname' ]),
      'organization' => $clientsdetails[ 'companyname' ],
      'introfile' => '',
      'fallbackfile' => '',
      'autorebuildlist' => 1
    ]);

        $system = new CCSystemAPIClient($ccurl);
        if ($_REQUEST[ 'ccmoduledebug' ]) {
            $system->debug = true;
        }

        $system->call('provision', $serverpassword, $arguments);

        logModuleCall('centovacast', 'create', $system->raw_request, $system->raw_response, null, null);

        if (!$system->success) {
            throw new\ Exception($system->error . ' (provision)');
        }

        $account = $system->data[ 'account' ];
        $account[ 'sourcepassword' ] = $arguments[ 'sourcepassword' ];

        $db->saveCustomFields($username, $account);

        return 'success';
    } catch (\Exception $e) {
        return 'Provisioning failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS package change.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_ChangePackage($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials(true);

        $username = $p->get('username');

        // we need to obtain the current account settings as a starting point
        $server = new CCServerAPIClient($ccurl);

        // retrieve the current account settings
        $server->call('getaccount', $username, $serverpassword, []);
        if (!$server->success) {
            throw new\ Exception($server->error . ' (getaccount)');
        }

        // account settings will be the first result row
        if (!is_array($server->data) || !count($server->data)) {
            throw new\ Exception('Error fetching account information from Centova Cast'); // i18n?
        }

        $account = $server->data[ 'account' ];
        if (!is_array($account) || !isset($account[ 'username' ])) {
            throw new\ Exception('Account does not exist in Centova Cast'); // i18n, anyone?
        }

        $account = $p->getAPIArguments();
        unset($account[ 'template' ]);

        // if a transfer limit/disk quota is specified, unset the unlimited-transfer/no-disk-quota flags
        if (!empty($p->get('configoption4'))) {
            unset($account[ 'noxferlimit' ]);
        }
        if (!empty($p->get('configoption5'))) {
            unset($account[ 'nodiskquota' ]);
        }

        // update the password and submit a reconfiguration request
        $server->call('reconfigure', $username, $serverpassword, $account);

        logModuleCall('centovacast', 'changepackage', $server->raw_request, $server->raw_response, null, null);

        if (!$server->success) {
            throw new\ Exception($server->error . ' (reconfigure)');
        }

        return 'success';
    } catch (\Exception $e) {
        return 'Package update failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS account termination.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_TerminateAccount($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials();

        $username = $p->get('username');

        $system = new CCSystemAPIClient($ccurl);
        $system->call('terminate', $serverpassword, [ 'username' => $username ]);

        logModuleCall('centovacast', 'terminate', $system->raw_request, $system->raw_response, null, null);

        if (!$system->success) {
            throw new\ Exception($system->error . ' (terminate)');
        }


        return 'success';
    } catch (\Exception $e) {
        return 'Account termination failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS account suspension.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_SuspendAccount($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials();

        $username = $p->get('username');

        $system = new CCSystemAPIClient($ccurl);
        $system->call(
            'setstatus',
            $serverpassword,
            [
        'username' => $username,
        'status' => 'disabled'
      ]
        );
        logModuleCall('centovacast', 'suspend', $system->raw_request, $system->raw_response, null, null);

        if (!$system->success) {
            throw new\ Exception($system->error . ' (setstatus)');
        }

        return 'success';
    } catch (\Exception $e) {
        return 'Account suspension failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS account unsuspension.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_UnsuspendAccount($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials();

        $username = $p->get('username');

        $system = new CCSystemAPIClient($ccurl);
        $system->call(
            'setstatus',
            $serverpassword,
            [
        'username' => $username,
        'status' => 'enabled'
      ]
        );

        logModuleCall('centovacast', 'unsuspend', $system->raw_request, $system->raw_response, null, null);

        if (!$system->success) {
            throw new\ Exception($system->error . ' (setstatus)');
        }

        return 'success';
    } catch (\Exception $e) {
        return 'Unsuspension failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS password change.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_ChangePassword($params)
{
    // NB: Centova Cast has no explicit "change password" feature -- we have
    // to submit a full configuration update for the account
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials(true);

        $username = $p->get('username');
        $password = $p->get('password');

        // we need to obtain the current account settings as a starting point
        $server = new CCServerAPIClient($ccurl);

        // retrieve the current account settings
        $server->call('getaccount', $username, $serverpassword, []);

        // punt on error
        if (!$server->success) {
            throw new\ Exception($server->error . ' (getaccount)');
        }

        // account settings will be the first result row
        if (!is_array($server->data) || !count($server->data)) {
            throw new\ Exception('Error fetching account information from Centova Cast'); // i18n?
        }
        $account = $server->data[ 'account' ];
        if (!is_array($account) || !isset($account[ 'username' ])) {
            throw new\ Exception('Account does not exist in Centova Cast'); // i18n, anyone?
        }

        // update the password and submit a reconfiguration request
        $account[ 'adminpassword' ] = $password;
        $server->call('reconfigure', $username, $serverpassword, $account);
        if (!$server->success) {
            throw new\ Exception($server->error . ' (reconfigure)');
        }

        logModuleCall('centovacast', 'changepassword', $server->raw_request, $server->raw_response, null, null);

        return 'success';
    } catch (\Exception $e) {
        return 'Password change failed: ' . $e->getMessage();
    }
}

/**
 * WHMCS administration area button array.
 *
 * @api
 *
 * @return array an array of buttons
 */
function centovacast_AdminCustomButtonArray()
{
    return [
    'Start Stream' => 'StartStream',
    'Stop Stream' => 'StopStream',
    'Restart Stream' => 'RestartStream',
  ];
}

/**
 * WHMCS client area HTML generation.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string the HTML for the client area
 */
function centovacast_ClientArea($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();

        $username = $p->get('username');
        $password = $p->get('password');

        if (substr($ccurl, -1) != '/') {
            $ccurl .= '/';
        }
        $loginurl = $ccurl . 'login/index.php';

        $time = time();
        $authtoken = sha1($username . $password . $time);

        $form = sprintf(
            '<form method="post" action="%s" target="_blank">' .
      '<input type="hidden" name="username" value="%s" />' .
      '<input type="hidden" name="password" value="%s" />' .
      '<input type="submit" name="login" value="%s" />' .
      '</form>',
            $loginurl,
            $username,
            $password,
            'Log in to Centova Cast' // i18n here?
        );

        $fn = dirname(__FILE__) . '/client_area.html';
        if (file_exists($fn)) {
            if ($_SERVER[ 'HTTPS' ] == 'on') {
                $ccurl = preg_replace('/^http:/', 'https:', $ccurl);
            }
            $details = preg_replace('/<!--[\s\S]*?-->/', '', str_replace(
                [ '[CCURL]', '[USERNAME]', '[TIME]', '[AUTH]' ],
                [ $ccurl, preg_replace('/[^a-z0-9_]+/i', '', $username), $time, $authtoken ],
                file_get_contents($fn)
            ));
        } else {
            $details = '';
        }


        // SP CUSTOM
        if ($_GET[ 'sppage' ] == 'spccapi') {
            return array(
              'tabOverviewReplacementTemplate' => 'templates/sp_ccapi',
              'vars' => array(
                'SPCentovaCast_Authtoken' => '' . $authtoken . '',
                'SPCentovaCast_Time' => '' . $time . '',
                'SPCentovaCast_Username' => '' . $username . '',
                'SPCentovaCast_Password' => '' . $password . '',
              ),
            );
        } elseif ($_GET[ 'sppage' ] == 'sphistory') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/sp_history'
        );
        } elseif ($_GET[ 'sppage' ] == 'sphistoryfull') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/sp_history_full'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'january') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/january'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'february') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/february'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'march') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/march'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'april') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/april'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'may') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/may'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'june') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/june'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'july') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/july'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'august') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/august'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'september') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/september'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'october') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/october'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'november') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/november'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'actual' and $_GET[ 'spmonth' ] == 'december') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/december'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'january') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/january_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'february') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/february_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'march') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/march_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'april') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/april_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'may') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/may_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'june') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/june_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'july') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/july_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'august') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/august_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'september') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/september_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'october') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/october_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'november') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/november_lastyear'
        );
        } elseif ($_GET[ 'sppage' ] == 'splr' and $_GET[ 'spyear' ] == 'last' and $_GET[ 'spmonth' ] == 'december') {
            return array(
          'tabOverviewReplacementTemplate' => 'templates/licensing/december_lastyear'
        );
        // Player 01
        } elseif ($_GET[ 'sppage' ] == 'player1_options') {
        
        // Get UserID
            $userid = $_SESSION[ 'uid' ];
        
            // Get Settings
            $spplayer01=select_query('mod_streampanel_player01', '*', array('userid'=>$userid));
            if (mysql_num_rows($spplayer01) > 0) {
                $fetchdetails=mysql_fetch_assoc($spplayer01);
                #echo'<pre>';print_r($fetchdetails);
                $setradioname=$fetchdetails['radioname'];
                $setplayerurl=$fetchdetails['player_url'];
                $setdefaultcover=$fetchdetails['default_cover'];
                $setlyrics=$fetchdetails['lyrics'];
                $sethistory=$fetchdetails['history'];
                $settype=$fetchdetails['type'];
                $setbackgroundurl=$fetchdetails['background_url'];
                $setmpnumber=$fetchdetails['mpnumber'];
            #echo'</pre>';
            } else {
                $table = "mod_streampanel_player01";
                $values = array("userid"=>$userid);
                $newid = insert_query($table, $values);
                
                // Reload Window
                $serverhost = $_SERVER['HTTP_HOST'];
                $serverurl = $_SERVER['REQUEST_URI'];
                $saveurl = str_replace('&amp;', '&', $serverhost . $serverurl);

                header("Location: https://".$saveurl."");
                exit(); //not really needed
            }
            
            // MySQL Update query
            if ($_POST['submitplayer01options']) {
                $table = "mod_streampanel_player01";
                $update = array(
                'radioname'=>$_POST["radioname"],
                'player_url'=>$_POST["playerurl"],
                'default_cover'=>$_POST["defaultcover"],
                #'lyrics'=>$_POST["lyrics"],
                'history'=>$_POST["history"],
                'type'=>$_POST["type"],
                'mpnumber'=>$_POST["mpnumber"],
                'background_url'=>$_POST["backgroundurl"]);
                $where = array("userid"=>$userid);
                update_query($table, $update, $where);
            }
        
            // Set Template
            return array(
          'tabOverviewReplacementTemplate' => 'templates/player/01_options',
          'vars' => array(
          'userid' => $userid,
          'setradioname' => $setradioname,
          'setplayerurl' => $setplayerurl,
          'setdefaultcover' => $setdefaultcover,
          'setlyrics' => $setlyrics,
          'sethistory' => $sethistory,
          'settype' => $settype,
          'setmpnumber' => $setmpnumber,
          'setbackgroundurl' => $setbackgroundurl,
        ),
      );
        // Player 02
        } elseif ($_GET[ 'sppage' ] == 'player2_options') {
        
      // Get UserID
            $userid = $_SESSION[ 'uid' ];
      
            // Get Settings
            $spplayer02=select_query('mod_streampanel_player02', '*', array('userid'=>$userid));
            if (mysql_num_rows($spplayer02) > 0) {
                $fetchdetails=mysql_fetch_assoc($spplayer02);
                #echo'<pre>';print_r($fetchdetails);
                $setradioname=$fetchdetails['radioname'];
                $setplayerurl=$fetchdetails['player_url'];
                $setdefaultcover=$fetchdetails['default_cover'];
                $setlyrics=$fetchdetails['lyrics'];
                $sethistory=$fetchdetails['history'];
                $settype=$fetchdetails['type'];
                $setbackgroundurl=$fetchdetails['background_url'];
                $setmpnumber=$fetchdetails['mpnumber'];
            #echo'</pre>';
            } else {
                $table = "mod_streampanel_player02";
                $values = array("userid"=>$userid);
                $newid = insert_query($table, $values);
              
                // Reload Window
                $serverhost = $_SERVER['HTTP_HOST'];
                $serverurl = $_SERVER['REQUEST_URI'];
                $saveurl = str_replace('&amp;', '&', $serverhost . $serverurl);

                header("Location: https://".$saveurl."");
                exit(); //not really needed
            }
          
            // MySQL Update query
            if ($_POST['submitplayer02options']) {
                $table = "mod_streampanel_player02";
                $update = array(
              'radioname'=>$_POST["radioname"],
              'player_url'=>$_POST["playerurl"],
              'default_cover'=>$_POST["defaultcover"],
              #'lyrics'=>$_POST["lyrics"],
              #'history'=>$_POST["history"],
              'type'=>$_POST["type"],
              'mpnumber'=>$_POST["mpnumber"],
              'background_url'=>$_POST["backgroundurl"]);
                $where = array("userid"=>$userid);
                update_query($table, $update, $where);
            }
      
            // Set Template
            return array(
        'tabOverviewReplacementTemplate' => 'templates/player/02_options',
        'vars' => array(
        'userid' => $userid,
        'setradioname' => $setradioname,
        'setplayerurl' => $setplayerurl,
        'setdefaultcover' => $setdefaultcover,
        'setlyrics' => $setlyrics,
        'sethistory' => $sethistory,
        'settype' => $settype,
        'setmpnumber' => $setmpnumber,
        'setbackgroundurl' => $setbackgroundurl,
      ),
    );
        // Player 03
        } elseif ($_GET[ 'sppage' ] == 'player3_options') {
        
    // Get UserID
            $userid = $_SESSION[ 'uid' ];
    
            // Get Settings
            $spplayer03=select_query('mod_streampanel_player03', '*', array('userid'=>$userid));
            if (mysql_num_rows($spplayer03) > 0) {
                $fetchdetails=mysql_fetch_assoc($spplayer03);
                #echo'<pre>';print_r($fetchdetails);
                $setradioname=$fetchdetails['radioname'];
                $setplayerurl=$fetchdetails['player_url'];
                $setdefaultcover=$fetchdetails['default_cover'];
                $setlyrics=$fetchdetails['lyrics'];
                $sethistory=$fetchdetails['history'];
                $settype=$fetchdetails['type'];
                $setbackgroundurl=$fetchdetails['background_url'];
                $setmpnumber=$fetchdetails['mpnumber'];
            #echo'</pre>';
            } else {
                $table = "mod_streampanel_player03";
                $values = array("userid"=>$userid);
                $newid = insert_query($table, $values);
            
                // Reload Window
                $serverhost = $_SERVER['HTTP_HOST'];
                $serverurl = $_SERVER['REQUEST_URI'];
                $saveurl = str_replace('&amp;', '&', $serverhost . $serverurl);

                header("Location: https://".$saveurl."");
                exit(); //not really needed
            }
        
            // MySQL Update query
            if ($_POST['submitplayer03options']) {
                $table = "mod_streampanel_player03";
                $update = array(
            'radioname'=>$_POST["radioname"],
            'player_url'=>$_POST["playerurl"],
            'default_cover'=>$_POST["defaultcover"],
            #'lyrics'=>$_POST["lyrics"],
            'history'=>$_POST["history"],
            'type'=>$_POST["type"],
            'mpnumber'=>$_POST["mpnumber"],
            'background_url'=>$_POST["backgroundurl"]);
                $where = array("userid"=>$userid);
                update_query($table, $update, $where);
            }
    
            // Set Template
            return array(
      'tabOverviewReplacementTemplate' => 'templates/player/03_options',
      'vars' => array(
      'userid' => $userid,
      'setradioname' => $setradioname,
      'setplayerurl' => $setplayerurl,
      'setdefaultcover' => $setdefaultcover,
      'setlyrics' => $setlyrics,
      'sethistory' => $sethistory,
      'settype' => $settype,
      'setmpnumber' => $setmpnumber,
      'setbackgroundurl' => $setbackgroundurl,
    ),
  );
        } elseif ($_GET[ 'sppage' ] == 'sphistory_options') {
        
        // Get UserID
            $userid = $_SESSION[ 'uid' ];
        
            // Get Settings
            $spautomaticwishbox=select_query('mod_streampanel_automaticwishbox', '*', array('userid'=>$userid));
            if (mysql_num_rows($spautomaticwishbox) > 0) {
                $fetchdetails=mysql_fetch_assoc($spautomaticwishbox);
                #echo'<pre>';print_r($fetchdetails);
                $setradioname=$fetchdetails['radioname'];
                $setcustom_css=$fetchdetails['custom_css'];
                $sethide_row1=$fetchdetails['hide_row1'];
                $sethide_row2=$fetchdetails['hide_row2'];
                $sethide_row3=$fetchdetails['hide_row3'];
                $sethide_row4=$fetchdetails['hide_row4'];
                $setwishbox_url=$fetchdetails['wishbox_url'];
            #echo'</pre>';
            } else {
                $table = "mod_streampanel_automaticwishbox";
                $values = array("userid"=>$userid);
                $newid = insert_query($table, $values);
            }
            
            // MySQL Update query
            if ($_POST['submitwishboxoptions']) {
                $table = "mod_streampanel_automaticwishbox";
                $update = array(
                'radioname'=>$_POST["radioname"],
                'custom_css'=>$_POST["custom_css"],
                'hide_row1'=>$_POST["hide_row1"],
                'hide_row2'=>$_POST["hide_row2"],
                'hide_row3'=>$_POST["hide_row3"],
                'hide_row4'=>$_POST["hide_row4"],
                'wishbox_url'=>$_POST["wishbox_url"]);
                $where = array("userid"=>$userid);
                update_query($table, $update, $where);
            }
        
            // Set Template
            return array(
          'tabOverviewReplacementTemplate' => 'templates/sp_history_options',
          'vars' => array(
          'userid' => $userid,
          'setradioname' => $setradioname,
          'setcustom_css' => $setcustom_css,
          'sethide_row1' => $sethide_row1,
          'sethide_row2' => $sethide_row2,
          'sethide_row3' => $sethide_row3,
          'sethide_row4' => $sethide_row4,
          'setwishbox_url' => $setwishbox_url,
        ),
      );
        } else {
            return array(
          'templatefile' => 'clientarea',
          'vars' => array(
            'SPCentovaCast_Authtoken' => '' . $authtoken . '',
            'SPCentovaCast_Time' => '' . $time . '',
            'SPCentovaCast_Username' => '' . $username . '',
            'SPCentovaCast_Password' => '' . $password . '',
          ),
        );
        }
        // SP CUSTOM


    #return $form . $details;
    } catch (\Exception $e) {
        return '';
    }
}

/**
 * WHMCS administration area HTML generation.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string the HTML for the administration area
 */
function centovacast_AdminLink($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();

        $serverusername = $p->get('serverusername');
        $serverpassword = $p->get('serverpassword');

        if (substr($ccurl, -1) != '/') {
            $ccurl .= '/';
        }
        $ccurl .= 'login/index.php';

        return sprintf(
            '<form method="post" action="%s" target="_blank">' .
      '<input type="hidden" name="username" value="%s" />' .
      '<input type="hidden" name="password" value="%s" />' .
      '<input type="submit" name="login" value="%s" />' .
      '</form>',
            $ccurl,
            $serverusername,
            $serverpassword,
            'Log in to Centova Cast' // i18n?
        );
    } catch (\Exception $e) {
        return '';
    }
}

/**
 * Changes the state of a Cast streaming server account.
 *
 * @internal
 *
 * @param array $params The $params array passed by WHMCS
 * @param string $newstate One of:
 *							'start' - start the stream
 *							'stop' - stop the stream
 *							'restart' - restart the stream
 *
 * @return string	The literal string 'success' on success, or an error message on failure.
 */
function centovacast_SetState($params, $newstate)
{
    if (!in_array($newstate, [ 'start', 'stop', 'restart' ])) {
        return 'Invalid state';
    } //i18n?

    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials(true);

        $username = $p->get('username');

        $server = new CCServerAPIClient($ccurl);
        $server->call($newstate, $username, $serverpassword, []);

        logModuleCall('centovacast', 'setstate', $server->raw_request, $server->raw_response, null, null);
        if (!$server->success) {
            throw new\ Exception($server->error . ' (' . $newstate . ')');
        }

        return 'success';
    } catch (\Exception $e) {
        return 'Failed to change state: ' . $e->getMessage();
    }
}


// Additional API functionality for starting, stopping, and restarting
// a stream (depends on centovacast_SetState above).
/**
 * Start the stream.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_StartStream($params)
{
    return centovacast_SetState($params, 'start');
}

/**
 * Stop the stream.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_StopStream($params)
{
    return centovacast_SetState($params, 'stop');
}

/**
 * Restart the stream.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_RestartStream($params)
{
    return centovacast_SetState($params, 'restart');
}

/**
 * WHMCS account usage update.
 *
 * @api
 *
 * @param array $params The $params array passed by WHMCS.
 *
 * @return string
 */
function centovacast_UsageUpdate($params)
{
    try {
        $p = new\ Centova\ Cast\ WHMCS\ Parameters($params);
        $db = new\ Centova\ Cast\ WHMCS\ WHMCSDB();
        $ccurl = $p->getCastURL();
        list(, $serverpassword) = $p->getServerCredentials();

        $system = new CCSystemAPIClient($ccurl);
        if ($_REQUEST[ 'ccmoduledebug' ]) {
            $system->debug = true;
        }

        // retrieve resource utilization information for this server
        $system->call('usage', $serverpassword, []);

        logModuleCall('centovacast', 'usageupdate', $system->raw_request, $system->raw_response, null, null);

        // punt on error
        if (!$system->success) {
            throw new\ Exception($system->error . ' (usage)');
        }

        // account settings will be the first result row
        if (!is_array($system->data) || !count($system->data)) {
            throw new\ Exception('Error fetching account information from Centova Cast'); // i18n?
        }

        $accounts = $system->data[ 'row' ];
        if (!is_array($accounts) || !count($accounts)) {
            throw new\ Exception('No accounts in Centova Cast');
        }
        if (isset($accounts[ 'username' ])) {
            $accounts = [ $accounts ];
        } // handle single result row

        $serverid = $p->get('serverid');

        $db->updateUsage($accounts, $serverid);

        return 'success';
    } catch (\Exception $e) {
        return 'Failed to update usage: ' . $e->getMessage();
    }
}
