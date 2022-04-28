<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class ItemGroupUpdate extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addColumn('item_group',[
            'fk_entity_id'=>[
                'type'=>'INT',
                'null'=>true,
                'unsigned'=>true,
            ],
        ]);
        $this->db->query(' ALTER TABLE item_group ADD CONSTRAINT fk_entity_itemg FOREIGN KEY(`fk_entity_id`) REFERENCES `entity`(entity_id)');
        $this->db->enableForeignKeyChecks();

    }

	public function down()
	{
	    $this->forge->dropColumn('item_group','fk_entity_id');
	}
}
