<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUser extends Migration
{
	public function up()
	{
		$this->forge->dropForeignKey('item', 'fk_checked_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_created_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_modified_by_user_id');

		$this->forge->dropForeignKey('loan', 'fk_loan_by_user_id');
		$this->forge->dropForeignKey('loan', 'fk_loan_to_user_id');

		$this->forge->dropForeignKey('inventory_control', 'fk_inventory_control_controller_id');
		
		$this->forge->modifyColumn('user', [
			'user_id' 		=> [
				'name'				=> 'id',
				'type'				=> 'INT',
				'auto_increment'	=> true
			],
			'user_type_id' 	=> [
				'name'				=> 'fk_user_type',
				'type'				=> 'INT',
				'after'				=> 'id'
			],
		]);

		$this->forge->addColumn('user', [
			'fk_user_details' => [
				'type' 			   	=> 'INT',
				'after'				=> 'fk_user_type'
			],
			'CONSTRAINT fk_user_details FOREIGN KEY (fk_user_details) REFERENCES user_details (id)'
		]);

		$this->forge->dropColumn('user', ['lastname', 'firstname']);

		$this->db->query('ALTER TABLE user CHANGE created_date date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		$this->db->query('ALTER TABLE user CHANGE is_active archive TIMESTAMP NULL');

		$this->db->query('ALTER TABLE user ADD CONSTRAINT fk_user_type FOREIGN KEY (fk_user_type) REFERENCES user_type (id)');
	}

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
