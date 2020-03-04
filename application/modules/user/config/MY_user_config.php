<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Authentication system configuration
|--------------------------------------------------------------------------
|
| Define here the different access levels needed in your application and
| some values for validation rules of the login form.
|
*/

/* Access levels */
$config['access_lvl_guest'] = 1;
$config['access_lvl_registered'] = 2;
$config['access_lvl_admin'] = 4;

/* Validation rules */
$config['username_min_length'] = 3;
$config['username_max_length'] = 45;
$config['password_min_length'] = 6;
$config['password_max_length'] = 72;

/* Other rules */
$config['password_hash_algorithm'] = PASSWORD_BCRYPT;
