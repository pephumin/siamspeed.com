<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines http://www.simplemachines.org
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0.10
 */

// We're going to want a few globals... these are all set later.
global $time_start, $maintenance, $msubject, $mmessage, $mbname, $language;
global $boardurl, $boarddir, $sourcedir, $webmaster_email, $cookiename;
global $db_server, $db_name, $db_user, $db_passwd, $db_prefix, $db_persist, $db_error_send, $db_last_error;
global $db_connection, $modSettings, $context, $sc, $user_info, $topic, $board, $txt;
global $smcFunc, $ssi_db_user, $scripturl, $ssi_db_passwd, $db_passwd, $cachedir;

require_once(dirname(__FILE__) . '/Settings.php');

if (empty($url)) { $url = "http://www.facebook.com/Sumisumiplus"; }

$ip = $_SERVER['REMOTE_ADDR'];

if(!empty($_GET["b"])) {

	$banner = "banner".$_GET["b"];

	date_default_timezone_set("Asia/Bangkok");
	$time = date('Y-m-d H:i:s');

	mysql_connect($db_server, $db_user, $db_passwd) or die(mysql_error());

	mysql_select_db($db_name) or die(mysql_error());

	//mysql_query("INSERT INTO smf_advertisement (`url`, `banner`, `ip`, `date`) VALUES ('$url', '$banner', '$ip', now())") or die(mysql_error());
	mysql_query("INSERT INTO smf_advertisement (`url`, `banner`, `ip`, `date`) VALUES ('$url', '$banner', '$ip', '$time')") or die(mysql_error());

	header("Location: $url");

}


?>