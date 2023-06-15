<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class Userentity extends Migration
{
	public function up()
	{
        $this->db->disableForeignKeyChecks();
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'fk_entity_id'=>[
                'type'=>'INT',
                'unsigned'=>true
            ],
            'fk_user_id'=>[
                'type'=>'INT',
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('fk_entity_id','entity','entity_id');
        $this->forge->addForeignKey('fk_user_id','user','id');
        $this->forge->createTable('user_entity',false);

        $this->db->enableForeignKeyChecks();
	}

	public function down()
	{
	    $this->forge->dropTable('user_entity');
	}
}
