<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUser extends Migration
{
	public function up()
	{
		$field = [
			'user_id' => [
				'name'				=> 'id',
				'type'				=> 'INT',
				'auto_increment'	=> true
			],
		];

		$this->forge->dropForeignKey('item', 'fk_checked_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_created_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_modified_by_user_id');

		$this->forge->dropForeignKey('loan', 'fk_loan_by_user_id');
		$this->forge->dropForeignKey('loan', 'fk_loan_to_user_id');

		$this->forge->dropForeignKey('inventory_control', 'fk_inventory_control_controller_id');
		
		$this->forge->modifyColumn('user', $field);

		$this->forge->dropColumn('user', ['lastname', 'firstname']);

		$this->db->query('ALTER TABLE user CHANGE created_date date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		$this->db->query('ALTER TABLE user CHANGE is_active archive TIMESTAMP NULL');

	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
