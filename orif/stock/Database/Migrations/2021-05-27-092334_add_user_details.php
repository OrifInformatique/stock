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
				'unsigned' 			=> true,
				'auto_increment' 	=> true,
			],

			'lastname' 	=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45',
			],

			'firstname' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45',
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('user_details');
	}

	public function down()
	{
		$this->forge->dropTable('user_details');
	}
}
