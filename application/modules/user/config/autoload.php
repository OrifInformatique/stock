<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (ENVIRONMENT !== 'testing') {
    $autoload['language'] = array('MY_user');
    $autoload['config'] = array('MY_user_config');
} else {
    // CI-PHPUnit checks from application/folder instead of module/folder
    $autoload['language'] = ['../../modules/user/language/french/MY_user'];
    $autoload['config'] = ['../modules/user/config/MY_user_config'];
}
