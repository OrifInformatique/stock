<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddItemCommonId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('item', [
            'item_common_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'after'             => 'item_id'
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
