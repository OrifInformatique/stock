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

		$this->forge->dropColumn('user', ['lastname', 'firstname']);

		// Makes sure every archive that are on 1 are set on null at the end of migrations
		$this->db->query('UPDATE user SET is_active = NULL WHERE is_active = 1');

		$this->db->query('ALTER TABLE user CHANGE created_date date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
		$this->db->query('ALTER TABLE user CHANGE is_active archive TIMESTAMP NULL DEFAULT NULL AFTER email');

		// Puts foreign keys back to their original links
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

		$this->forge->addColumn('user_details', 'CONSTRAINT fk_user_id FOREIGN KEY (fk_user) REFERENCES user (id)');

		$this->forge->addColumn('user', 'CONSTRAINT fk_user_type_id FOREIGN KEY (fk_user_type) REFERENCES user_type (id)');
	}

	
	public function down()
	{
		$this->forge->dropForeignKey('item', 'fk_checked_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_created_by_user_id');
		$this->forge->dropForeignKey('item', 'fk_modified_by_user_id');

		$this->forge->dropForeignKey('loan', 'fk_loan_by_user_id');
		$this->forge->dropForeignKey('loan', 'fk_loan_to_user_id');

		$this->forge->dropForeignKey('inventory_control', 'fk_inventory_control_controller_id');

		$this->forge->dropForeignKey('user', 'fk_user_type_id');

		$this->forge->dropForeignKey('user_details', 'fk_user_id');

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

		// Makes sure every is_active that are NULL are set on 1 at the end of a rollback
		$this->db->query('UPDATE user SET is_active = 1 WHERE is_active IS NULL');

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

		// Move all lastnames and firstnames from user_details to the user table equivalent rows
		$this->db->query('UPDATE user JOIN user_details ON user.user_id = user_details.fk_user 
						  SET user.lastname = user_details.lastname, user.firstname = user_details.firstname 
						  WHERE user_id IN (SELECT fk_user FROM user_details)');
	}
}
