<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;
use Stock\Models\Item_tag_link_model;
use Stock\Models\Item_model;

class MoveItemTagLink extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('item_tag_link', 'fk_item_id');

        $this->forge->modifyColumn('item_tag_link', [
            'item_id' => [
				'name'				=> 'item_common_id',
				'type'				=> 'INT',
                'constraint'        => '11',
                'null'              => false
            ]
        ]);

        $itemTagLinkModel = new Item_tag_link_model();
        $itemModel = new Item_model();

        $itemTagLinks = $itemTagLinkModel->findAll();

        if (count($itemTagLinks) > 0) {
            foreach ($itemTagLinks as $itemTagLink) {
                $item = $itemModel->where('item_id', $itemTagLink['item_common_id'])->first();

                if (!is_null($item)) {
                    $itemTagLinkRow = $itemTagLinkModel->where('item_tag_id', $itemTagLink['item_tag_id'])->where('item_common_id', $item['item_common_id'])->first();

                    // To prevent duplicate entries we check if the row already exists
                    // Otherwise we delete the others
                    if (is_null($itemTagLinkRow)) {
                        $itemTagLinkModel->update($itemTagLink['item_tag_link_id'], [
                            'item_common_id' => $item['item_common_id']
                        ]);
                    } else {
                        $itemTagLinkModel->delete($itemTagLink['item_tag_link_id']);
                    }
                }
            }
        }

        $this->forge->addColumn('item_tag_link', [
            'CONSTRAINT fk_item_tag_link_item_common_id FOREIGN KEY (item_common_id) REFERENCES item_common (item_common_id)'
        ]);
    }

    public function down()
    {
        //
    }
}
