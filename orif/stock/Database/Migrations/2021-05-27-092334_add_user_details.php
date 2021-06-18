<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Adduserdetails extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' 		=> [
				'type' 				=> 'INT',
				'constraint'		=> '11',
				'auto_increment' 	=> true
			],

			'lastname' 	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45'
			],

			'firstname' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45'
			]
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('user_details', true);
	}

	public function down()
	{
		$this->forge->dropForeignKey('user', 'fk_user_details');
	
		$this->forge->dropColumn('user', 'fk_user_details');
		
		$this->forge->dropTable('user_details');

	}
}
