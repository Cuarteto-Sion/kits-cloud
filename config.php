<?php

/*
#################################################################################################################
This is an OPTIONAL configuration file.
The role of this file is to make updating of "tinyfilemanager.php" easier.
So you can:
-Feel free to remove completely this file and configure "tinyfilemanager.php" as a single file application.
or
-Put inside this file all the static configuration you want and forgot to configure "tinyfilemanager.php".
#################################################################################################################
*/

// Auth with login/password
// set true/false to enable/disable it
// Is independent from IP white- and blacklisting
$use_auth = true;

// Login user name and password
// Users: array('Username' => 'Password', 'Username2' => 'Password2', ...)
// Generate secure password hash - https://tinyfilemanager.github.io/docs/pwd.html
$auth_users = array(
    'admin' => password_hash('A51cfB10dc', PASSWORD_DEFAULT),
    'oliver.montalvan' => password_hash('A51cfB10dc', PASSWORD_DEFAULT),
    'maynor.montalvan' => password_hash('011192', PASSWORD_DEFAULT),
    'luis.hernandez' => password_hash('12345678', PASSWORD_DEFAULT),
    'mario.maltez' => password_hash('12345678', PASSWORD_DEFAULT),
    'gunther.rojas' => password_hash('12345678', PASSWORD_DEFAULT),
    'Gunther.rojas' => password_hash('12345678', PASSWORD_DEFAULT),
    'allan.vargas' => password_hash('12345678', PASSWORD_DEFAULT),
    'rodolfo.mayorga' => password_hash('12345678', PASSWORD_DEFAULT),
    'carlos.lennon' => password_hash('12345678', PASSWORD_DEFAULT),
    'pablo.torrez' => password_hash('12345678', PASSWORD_DEFAULT),
    'obed.orozco' => password_hash('12345678', PASSWORD_DEFAULT),
    'samuel.peralta' => password_hash('12345678', PASSWORD_DEFAULT),
    'elias.zelaya' => password_hash('12345678', PASSWORD_DEFAULT)
);

//set application theme
//options - 'light' and 'dark'
$theme = 'light';

// Readonly users
// e.g. array('users', 'guest', ...)
$readonly_users = array(
    'luis.hernandez',
    'mario.maltez',
    'gunther.rojas',
    'Gunther.rojas',
    'allan.vargas',
    'rodolfo.mayorga',
    'carlos.lennon',
    'pablo.torrez',
    'obed.orozco',
    'samuel.peralta',
    'elias.zelaya'
);

// Enable highlight.js (https://highlightjs.org/) on view's page
$use_highlightjs = true;

// highlight.js style
// for dark theme use 'ir-black'
$highlightjs_style = 'vs';

// Enable ace.js (https://ace.c9.io/) on view's page
$edit_files = true;

// Default timezone for date() and time()
// Doc - http://php.net/manual/en/timezones.php
$default_timezone = 'America/Managua'; // UTC

// Root path for file manager
// use absolute path of directory i.e: '/var/www/folder' or $_SERVER['DOCUMENT_ROOT'].'/folder'
$root_path = $_SERVER['DOCUMENT_ROOT'] . '/XNh6SioWW9ZoKyNXDdmghtY9sRPnJWWC6/Cuarteto Sion/Kits/4.Publicados';
//$root_path = '/home1/cuartet2/public_html/XNh6SioWW9ZoKyNXDdmghtY9sRPnJWWC6';

// Root url for links in file manager.Relative to $http_host. Variants: '', 'path/to/subfolder'
// Will not working if $root_path will be outside of server document root
$root_url = '';

$rsf = 'XNh6SioWW9ZoKyNXDdmghtY9sRPnJWWC6';
$sionKits = '/Cuarteto Sion/Kits';

// Server hostname. Can set manually if wrong
$http_host = $_SERVER['HTTP_HOST'];

// user specific directories
// array('Username' => 'Directory path', 'Username2' => 'Directory path', ...)
$directories_users = array(
	'admin' => $rsf,
	'oliver.montalvan' => $rsf,
	'maynor.montalvan' => $rsf . $sionKits . '/4.Publicados',
	'gunther.rojas' => $rsf . $sionKits . '/4.Publicados',
        'Gunther.rojas' => $rsf . $sionKits . '/4.Publicados',
	'luis.hernandez' => $rsf . $sionKits . '/4.Publicados',
	'mario.maltez' => $rsf . $sionKits . '/4.Publicados',
	'pablo.torrez' => $rsf . $sionKits . '/5.Temporales',
	'obed.orozco' => $rsf . $sionKits . '/5.Temporales',
	'samuel.peralta' => $rsf . $sionKits . '/5.Temporales',
	'elias.zelaya' => $rsf . $sionKits . '/5.Temporales'
);

// input encoding for iconv
$iconv_input_encoding = 'UTF-8';

// date() format for file modification date
// Doc - https://www.php.net/manual/en/function.date.php
$datetime_format = 'd/m/Y h:i:s a';

// Allowed file extensions for create and rename files
// e.g. 'txt,html,css,js'
$allowed_file_extensions = 'txt,html,md,docx';

// Allowed file extensions for upload files
// e.g. 'gif,png,jpg,html,txt'
$allowed_upload_extensions = 'pdf,mp3,txt,musx,html,mp4';

// Favicon path. This can be either a full url to an .PNG image, or a path based on the document root.
// full path, e.g http://example.com/favicon.png
// local path, e.g images/icons/favicon.png
$favicon_path = '?img=favicon';

// Files and folders to excluded from listing
// e.g. array('myfile.html', 'personal-folder', '*.php', ...)
$exclude_items = array(
	"*.php",
    ".ftpquota",
    ".htaccess",
);

// Online office Docs Viewer
// Availabe rules are 'google', 'microsoft' or false
// google => View documents using Google Docs Viewer
// microsoft => View documents using Microsoft Web Apps Viewer
// false => disable online doc viewer
$online_viewer = 'google';

// Sticky Nav bar
// true => enable sticky header
// false => disable sticky header
$sticky_navbar = true;


// max upload file size
$max_upload_size_bytes = 0;

// Possible rules are 'OFF', 'AND' or 'OR'
// OFF => Don't check connection IP, defaults to OFF
// AND => Connection must be on the whitelist, and not on the blacklist
// OR => Connection must be on the whitelist, or not on the blacklist
$ip_ruleset = 'OFF';

// Should users be notified of their block?
$ip_silent = true;

// IP-addresses, both ipv4 and ipv6
$ip_whitelist = array(
    '127.0.0.1',    // local ipv4
    '::1'           // local ipv6
);

// IP-addresses, both ipv4 and ipv6
$ip_blacklist = array(
    '0.0.0.0',      // non-routable meta ipv4
    '::'            // non-routable meta ipv6
);

?>
