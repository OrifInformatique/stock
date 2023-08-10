<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddItemCommonIdAndGroupId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('item', [
            'item_common_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
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
