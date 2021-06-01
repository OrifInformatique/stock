<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserType extends Migration
{
	public function up()
	{
		$field = [
			'user_type_id' => [
				'name'				=> 'id',
				'type'				=> 'INT',
				'unsigned'          => true,
				'auto_increment'	=> true
			],
		];
	
		$this->forge->dropForeignKey('user', 'fk_user_type_id');

		$this->forge->modifyColumn('user_type', $field);
	}

	public function down()
	{
		$this->forge->dropTable('user_type');
	}
}
