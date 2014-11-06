<?php

#Database Settings
define('Database_Host', 'localhost');
define('Database_User', 'root');
define('Database_Password', '');
define('Database_Name', '10is');


#Site Settings
define('Website_Name', 'Thermodas');
define('Website_Title', Website_Name);
define('Business_Name', '');
define('TitleConnector', ' | ');
define('Keywords', '');
define('Description', '');

define('AdminURL', '/myadmin/');

define('URL', 'http://localhost/10is/');
$dir_path = str_replace($_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__))) . DIRECTORY_SEPARATOR;
$dir_path = 'C:/xampp/htdocs/10is';
define('AbsPath', $dir_path);

define("From_Name", "Administrator");
define("From_Email", "pgoto@usenergyengineers.com");
define("AdminEmail", "pgoto@usenergyengineers.com");
#date_default_timezone_set('EST');
date_default_timezone_set("UTC");

define('SOM', date('Y-m-01'));
define('EOM', date('Y-m-d'));
?>