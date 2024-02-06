<?php
/**
 * Config for stock module
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace Config;

use CodeIgniter\Config\BaseConfig;

class StockConfig extends BaseConfig
{
    /* Authentication system constants */
    public $username_min_length         =   3;
    public $username_max_length         =   45;
    public $password_min_length         =   6;
    public $password_max_length         =   72;
    
    public $access_lvl_manager          =   2;
    public $access_lvl_admin            =   4;

    /* Validation rules */
    public $group_short_max_length      =   2;
    public $tag_short_max_length        =   3;
    public $stocking_short_max_length   =   10;

    /* Password hash */
    public $password_hash_algorithm     =   PASSWORD_BCRYPT;

    /* Constants */
    public $inventory_prefix            =   'ORP';
    public $inventory_number_chars      =   4;

    public $functional_item_condition   =   10;
    public $soft_deleted_item_condition =   40;
    public $items_default_group         =   2;
    public $item_no_image               =   'no_image.png';
    public $item_no_image_path          =   'images/';
    public $item_no_data                =   '-';
    public $image_extension             =   '.png';
    public $image_picture_suffix        =   '_picture';
    public $image_tmp_suffix            =   '_tmp';
    public $image_upload_width          =   360;
    public $image_upload_height         =   360;
    public $name_min_length             =   3;
    public $name_max_length             =   100;
    public $images_upload_path          =   'uploads/images/';
    public $files_upload_path           =   'uploads/files/';
    public $items_per_page              =   48;
    public $default_order_by_field      =   'item_common.name';
    public $database_date_format        =   'Y-m-d';
    public $database_datetime_format    =   'Y-m-d H:i:s';

    public $group_by_item_common        =   0;
    public $group_by_item               =   1;
    public $supplier_to_ignore          =   'Inconnu';
}
