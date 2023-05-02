<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class StockingPlaceUpdate extends Migration
{
	public function up()
	{
	    $this->db->disableForeignKeyChecks();
		$this->forge->addColumn('stocking_place',[
		    'fk_entity_id'=>[
		        'type'=>'INT',
                'null'=>true,
                'unsigned'=>true,

            ]
        ]);
        $this->db->query(' ALTER TABLE stocking_place ADD CONSTRAINT fk_entitystok FOREIGN KEY(`fk_entity_id`) REFERENCES `entity`(entity_id)');

        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropColumn('stocking_place','fk_entity_id');
	}
}
