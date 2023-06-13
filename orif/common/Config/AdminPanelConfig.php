<?php
/**
 * Config for common module
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Config;


use User\Controllers\Admin;

class AdminPanelConfig extends \CodeIgniter\Config\BaseConfig
{
    /** Update this array to customize admin pannel tabs for your needs 
     *  Syntax : ['label'=>'tab label','pageLink'=>'tab link']
    */
    public $tabs=[
        ['label'=>'user_lang.title_user_list', 'pageLink'=>'stock/admin/list_user'],
        ['label'=>'stock_lang.title_tags', 'pageLink'=>'stock/admin/view_tags'],
        ['label'=>'stock_lang.title_stocking_places', 'pageLink'=>'stock/admin/view_stocking_places'],
        ['label'=>'stock_lang.title_suppliers', 'pageLink'=>'stock/admin/view_suppliers'],
        ['label'=>'stock_lang.title_item_groups', 'pageLink'=>'stock/admin/view_item_groups'],
        ['label'=>'stock_lang.title_entity_list','pageLink'=>'stock/admin/view_entity_list']
    ];
}