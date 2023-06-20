<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

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

        $this->forge->addColumn('item_tag_link', [
            'CONSTRAINT fk_item_tag_link_item_common_id FOREIGN KEY (item_common_id) REFERENCES item_common (item_common_id)'
        ]);
    }

    public function down()
    {
        //
    }
}
