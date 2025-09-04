<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateItemCommon extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'item_common_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'name' => [
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null,
            ],
            'description' => [
                'type'              => 'text',
                'null'              => true,
                'default'           => null,
            ],
            'image' => [
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => true,
                'default'           => null,
            ],
            'linked_file' => [
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => true,
                'default'           => null,
            ],
            'item_group_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
        ]);

        $this->forge->addKey('item_common_id', TRUE);

        $this->forge->addForeignKey('item_group_id', 'item_group', 'item_group_id', '', '', 'fk_item_common_item_group_id');

        $this->forge->createTable('item_common', TRUE);

    }

    public function down()
    {
        //
    }
}
