<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveItemFields extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('item', 'fk_item_group_id');

        $this->forge->dropColumn('item', [
            'name',
            'description',
            'image',
            'linked_file',
            'item_group_id'
        ]);

        $this->forge->addColumn('item', [
            'item_common_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'after'             => 'item_id'
            ],
            'CONSTRAINT fk_item_item_common_id FOREIGN KEY (item_common_id) REFERENCES item_common (item_common_id)'
        ]);
    }

    public function down()
    {
        //
    }
}
