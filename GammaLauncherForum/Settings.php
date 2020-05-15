<?php

/**
 * Simple Machines Forum (SMF)
 *
 * @package SMF
 * @author Simple Machines http://www.simplemachines.org
 * @copyright 2011 Simple Machines
 * @license http://www.simplemachines.org/about/smf/license.php BSD
 *
 * @version 2.0
 */

########## Maintenance ##########
# Note: If $maintenance is set to 2, the forum will be unusable!  Change it to 0 to fix it.
$mtitle = 'Maintenance Mode';		# Title for the Maintenance Mode message.
$mmessage = 'Okay faithful users...we\'re attempting to restore an older backup of the database...news will be posted once we\'re back!';		# Description of why the forum is in maintenance mode.

########## Forum Info ##########
$mbname = 'Gamma Launcher Forum';		# The name of your forum.
$language = 'english';		# The default language file set for the forum.
$boardurl = 'http://gammalauncher.x10.mx';		# URL to your forum's folder. (without the trailing /!)
$webmaster_email = 'support@gammalauncher.x10.mx';		# Email address to send emails from. (like noreply@yourdomain.com.)
$cookiename = 'SMFCookie972';		# Name of the cookie to set for authentication.

########## Database Info ##########
$db_type = 'mysql';
$db_server = 'localhost';
$db_name = 'gammalau_smf953';
$db_user = 'gammalau_smf953';
$db_passwd = '-9s-DS60Op';
$ssi_db_user = '';
$ssi_db_passwd = '';
$db_prefix = 'smfcp_';
$db_persist = 0;
$db_error_send = 1;

########## Directories/Files ##########
# Note: These directories do not have to be changed unless you move things.
$boarddir = '/home/gammalau/public_html';		# The absolute path to the forum's folder. (not just '.'!)
$sourcedir = '/home/gammalau/public_html/Sources';		# Path to the Sources directory.
$cachedir = '/home/gammalau/public_html/cache';		# Path to the cache directory.

########## Error-Catching ##########
# Note: You shouldn't touch these settings.
$db_last_error = 0;


# Make sure the paths are correct... at least try to fix them.
if (!file_exists($boarddir) && file_exists(dirname(__FILE__) . '/agreement.txt'))
	$boarddir = dirname(__FILE__);
if (!file_exists($sourcedir) && file_exists($boarddir . '/Sources'))
	$sourcedir = $boarddir . '/Sources';
if (!file_exists($cachedir) && file_exists($boarddir . '/cache'))
	$cachedir = $boarddir . '/cache';

$image_proxy_secret = 'a47b460df4de7fd48239';
$image_proxy_maxsize = '5190';
$image_proxy_enabled = '0';
$auth_secret = '8546a183b9cf59a8f58fa3bbc8c2d7258c7e721dba021eec2bb115ca514ab833';
?>