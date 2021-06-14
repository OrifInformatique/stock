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
			'CONSTRAINT fk_user_details FOREIGN KEY (fk_user_details) REFERENCES user_details (id)',
			'CONSTRAINT fk_user_type_id_idx FOREIGN KEY (fk_user_type) REFERENCES user_type (id)'
		]);

		$this->forge->dropColumn('user', ['lastname', 'firstname']);

		$this->db->query('ALTER TABLE user CHANGE created_date date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		$this->db->query('ALTER TABLE user CHANGE is_active archive TIMESTAMP NULL DEFAULT NULL AFTER email');

		$this->forge->addColumn('item', [
			'CONSTRAINT fk_checked_by_user_id FOREIGN KEY (checked_by_user_id) REFERENCES user (id)',
			'CONSTRAINT fk_created_by_user_id FOREIGN KEY (created_by_user_id) REFERENCES user (id)',
			'CONSTRAINT fk_modified_by_user_id FOREIGN KEY (modified_by_user_id) REFERENCES user (id)',
		]);

		$this->forge->addColumn('loan', [
			'CONSTRAINT fk_loan_by_user_id FOREIGN KEY (loan_by_user_id) REFERENCES user (id)',
			'CONSTRAINT fk_loan_to_user_id FOREIGN KEY (loan_to_user_id) REFERENCES user (id)',
		]);

		$this->forge->addColumn('inventory_control', 'CONSTRAINT fk_inventory_control_controller_id FOREIGN KEY (controller_id) REFERENCES user (id)');
	}

	public function down()
	{
		$this->forge->dropForeignKey('item', 'fk_checked_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_created_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_modified_by_user_id');

		$this->forge->dropForeignKey('loan', 'fk_loan_by_user_id');
		$this->forge->dropForeignKey('loan', 'fk_loan_to_user_id');

		$this->forge->dropForeignKey('inventory_control', 'fk_inventory_control_controller_id');

		$this->forge->dropForeignKey('user', 'fk_user_type_id_idx');

		$this->db->query('ALTER TABLE user CHANGE date_creation created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');

		$this->forge->modifyColumn('user', [
			'id' 			=> [
				'name'				=> 'user_id',
				'type'				=> 'INT',
				'auto_increment'	=> true
			],
			'fk_user_type' 	=> [
				'name'				=> 'user_type_id',
				'type'				=> 'INT',
				'after'				=> 'created_date'
			],
			'archive' 	    => [
				'name'				=> 'is_active',
				'type'				=> 'TINYINT',
				'constraint'		=> '1',
				'default'			=> '1',
				'after'				=> 'user_type_id'
			]
		]);

		$this->forge->addColumn('user', [
			'lastname'		=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45',
				'null'				=> true,
				'default'			=> null,
				'after'				=> 'user_id'
			],
			'firstname'		=> [
				'type'				=> 'VARCHAR',
				'constraint'		=> '45',
				'null'				=> true,
				'default'			=> null,
				'after'				=> 'lastname'
			]
		]);
	}
}
