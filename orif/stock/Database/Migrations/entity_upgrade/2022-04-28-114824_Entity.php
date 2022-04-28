<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class Entity extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'entity_id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'name'=>[
                'type'=>'VARCHAR',
                'constraint'=>'50',
            ],
            'address'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
            ],
            'zip'=>[
                'type'=>'VARCHAR',
                'constraint'=>'10',
            ],
            'locality'=>[
                'type'=>'VARCHAR',
                'constraint'=>'100',
            ],
            'shortname'=>[
                'type'=>'VARCHAR',
                'constraint'=>'3',
            ]
        ]);
        $this->forge->addPrimaryKey('entity_id');
        $this->forge->createTable('entity',false);
        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
		$this->forge->dropTable('entity');
	}
}
