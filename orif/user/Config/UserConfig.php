<?php
/**
 * Config for user module
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Config;

use CodeIgniter\Config\BaseConfig;

class UserConfig extends BaseConfig
{
    /* Access levels */
    public $access_lvl_guest            =   1;
    public $access_lvl_registered       =   2;
    public $access_lvl_admin            =   4;
    
    /* Validation rules */
    public $username_min_length         =   3;
    public $username_max_length         =   45;
    public $password_min_length         =   6;
    public $password_max_length         =   72;
    public $email_max_length            =   100;
    
    /* Other rules */
    public $password_hash_algorithm     =   PASSWORD_BCRYPT;
}