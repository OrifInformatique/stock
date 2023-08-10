<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertDataToItemCommon extends Migration
{
    public function up()
    {
        $this->db->query('INSERT INTO item_common (name, description, image, linked_file, item_group_id)
            SELECT name, MAX(description), MAX(image), MIN(linked_file), item_group_id
            FROM item
            GROUP BY name, item_group_id'
        );

        $this->db->query('UPDATE item i
            JOIN item_common ic ON i.name = ic.name AND i.item_group_id = ic.item_group_id
            SET i.item_common_id = ic.item_common_id'
        );

        $this->forge->dropForeignKey('item', 'fk_item_group_id');

        $this->forge->dropColumn('item', [
            'name',
            'description',
            'image',
            'linked_file',
            'item_group_id'
        ]);
    }

    public function down()
    {
        //
    }
}
