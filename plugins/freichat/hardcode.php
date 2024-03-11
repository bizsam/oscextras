<?php
/* Data base details */
$dsn='mysql:host=localhost;dbname=j3'; //DSN
$db_user='root'; //DB username
$db_pass=''; //DB password    
$driver='JCB'; //Integration driver
$db_prefix='fwybk_'; //prefix used for tables in database
$uid='526f69310179b'; //Any random unique number

$PATH = 'freichat/'; // Use this only if you have placed the freichat folder somewhere else
$installed=false; //make it false if you want to reinstall freichat
$admin_pswd='testing'; //backend password 

$debug = false;
$custom_error_handling='NO'; // used during custom installation

$use_cookie=false;

/* email plugin */
$smtp_username = 'evnix.com@gmail.com';
$smtp_password = 'silva9892959303';

$force_load_jquery = 'NO';

/* Custom driver */
$usertable='login'; //specifies the name of the table in which your user information is stored.
$row_username='root'; //specifies the name of the field in which the user's name/display name is stored.
$row_userid='loginid'; //specifies the name of the field in which the user's id is stored (usually id or userid)
$avatar_field_name = 'avatar';
