<?php

/**
 * Model Item_common_model this represents the item_common table
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace  Stock\Models;

use Stock\Models\MyModel;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class Item_common_model extends MyModel
{
    protected $table = 'item_common';
    protected $primaryKey = 'item_common_id';
    protected $allowedFields = ['name', 'description', 'image', 'linked_file', 'item_group_id'];

    protected Item_group_model $item_group_model;
    protected Item_tag_link_model $item_tag_link_model;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        $this->validationRules = [
            'name' => [
                'label' => strtolower(lang('stock_lang.field_name')),
                'rules' => 'trim|required|alpha_numeric_accent_space|'
                    . 'min_length['.config("\Stock\Config\StockConfig")->name_min_length.']|'
                    . 'max_length['.config("\Stock\Config\StockConfig")->name_max_length.']'
            ],
            'description' => [
                'label' => strtolower(lang('stock_lang.field_description')),
                'rules' => 'permit_empty'
            ],
            'image' => [
                'label' => strtolower(lang('MY_application.field_image')),
                'rules' => 'permit_empty'
            ],
            'linked_file' => [
                'label' => strtolower(lang('stock_lang.field_linked_file')),
                'rules' => 'permit_empty'
            ],
            'item_group_id' => [
                'label' => strtolower(lang('MY_application.field_group')),
                'rules' => 'required|numeric'
            ]
        ];

        $this->validationMessages = [];

        parent::__construct($db, $validation);
    }

    public function initialize()
    {
        $this->item_group_model = new Item_group_model();
        $this->item_tag_link_model = new Item_tag_link_model();
    }

    public function getItemGroup($item_common)
    {
        $itemGroup = $this->item_group_model->asArray()->where(["item_group_id" => $item_common['item_group_id']])->first();
        return $itemGroup;
    }

    public function getTags($item_common)
    {
        $tags = $this->item_tag_link_model->getTags($item_common);

        return $tags;
    }

    public function getImage($item)
    {
        $item_common = $this->where('item_common_id', $item['item_common_id'])->first();

        if (is_null($item_common) && !isset($item_common['image'])) {
            $item_common['image'] = config('\Stock\Config\StockConfig')->item_no_image;
        }

        return $item_common['image'];
    }

    public function getImagePath($item_common)
    {
        if (!is_null($item_common) && ($item_common['image'] == config('\Stock\Config\StockConfig')->item_no_image || is_null($item_common['image']))) {
            return config('\Stock\Config\StockConfig')->item_no_image_path . config('\Stock\Config\StockConfig')->item_no_image;
        } else {
            return config('\Stock\Config\StockConfig')->images_upload_path . $item_common['image'];
        }
    }
    
    public function getName($item)
    {
        $item_common = $this->where('item_common_id', $item['item_common_id'])->first();

        if (!is_null($item_common)) 
            return $item_common['name'];
    }
}
