<?php
/******************************************************************************
* Settings.php                                                                *
*******************************************************************************
* SMF: Simple Machines Forum                                                  *
* Open-Source Project Inspired by Zef Hemel (zef@zefhemel.com)                *
* =========================================================================== *
* Software Version:           SMF 1.0 RC1                                     *
* Software by:                Simple Machines (http://www.simplemachines.org) *
* Copyright 2001-2004 by:     Lewis Media (http://www.lewismedia.com)         *
* Support, News, Updates at:  http://www.simplemachines.org                   *
*******************************************************************************
* This program is free software; you may redistribute it and/or modify it     *
* under the terms of the provided license as published by Lewis Media.        *
*                                                                             *
* This program is distributed in the hope that it is and will be useful,      *
* but WITHOUT ANY WARRANTIES; without even any implied warranty of            *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                        *
*                                                                             *
* See the "license.txt" file for details of the Simple Machines license.      *
* The latest version can always be found at http://www.simplemachines.org.    *
******************************************************************************/

########## Maintenance ##########
# Note: If $maintenance is set to 2, the forum will be unusable!  Change it to 0 to fix it.
$mtitle = 'Fixing mode...';		# Title for the Maintenance Mode message.
$mmessage = 'Fixing mode...';		# Description of why the forum is in maintenance mode.

########## Forum Info ##########
$mbname = '[::SIAMSPEED::]';		# The name of your forum.
$language = 'english';		# The default language file set for the forum.
$boardurl = 'http://www.siamspeed.com';         # URL to your forum's folder. (without the trailing /!)
$webmaster_email = 'webmaster@siamspeed.com';		# Email address to send emails from. (like noreply@yourdomain.com.)
$cookiename = 'SMF6177';		# Name of the cookie to set for authentication.

########## Database Info ##########
$db_server = 'magenta.thaiweb.net';
//$db_server = 'green.thaiweb.net';
$db_name = 'siamspeed';
$db_user = 'supra';
$db_passwd = 'supra.club';
$db_prefix = 'smf_';
$db_persist = 0;
$db_error_send = 1;
#$db_show_debug = true;

########## Directories/Files ##########
# Note: These directories do not have to be changed unless you move things.
$boarddir = '/backup/www/default/siamspeed.com';               # The absolute path to the forum's folder. (not just '.'!)
$sourcedir = '/backup/www/default/siamspeed.com/Sources';              # Path to the Sources directory.

########## Error-Catching ##########
# Note: You shouldn't touch these settings.
$db_last_error = 1338826189;

# Make sure the paths are correct... at least try to fix them.
if (!file_exists($boarddir) && file_exists(dirname(__FILE__) . '/agreement.txt'))
$boarddir = '/backup/www/default/siamspeed.com';
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
$sourcedir = '/backup/www/default/siamspeed.com/Sources';

$cachedir = '/backup/www/default/siamspeed.com/cache';
$ssi_db_passwd = '';
$ssi_db_user = '';


$db_character_set = 'utf8';

?>