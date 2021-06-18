<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUserType extends Migration
{
	public function up()
	{
		$this->forge->dropForeignKey('user', 'fk_user_type_id');

		$this->forge->modifyColumn('user_type', [
			'user_type_id' => [
				'name'				=> 'id',
				'type'				=> 'INT',
				'auto_increment'	=> true
			],
		]);
	}

	public function down()
	{
		$this->forge->modifyColumn('user_type', [
			'id'		=> [
				'name'				=> 'user_type_id',
				'type'				=> 'INT'
			]
		]);

		$this->forge->addColumn('user', [
			'CONSTRAINT fk_user_type_id FOREIGN KEY (user_type_id) REFERENCES user_type (user_type_id)'
		]);
		
		$this->forge->addColumn('item', [
			'CONSTRAINT fk_checked_by_user_id FOREIGN KEY (checked_by_user_id) REFERENCES user (user_id)',
			'CONSTRAINT fk_created_by_user_id FOREIGN KEY (created_by_user_id) REFERENCES user (user_id)',
			'CONSTRAINT fk_modified_by_user_id FOREIGN KEY (modified_by_user_id) REFERENCES user (user_id)',
		]);

		$this->forge->addColumn('loan', [
			'CONSTRAINT fk_loan_by_user_id FOREIGN KEY (loan_by_user_id) REFERENCES user (user_id)',
			'CONSTRAINT fk_loan_to_user_id FOREIGN KEY (loan_to_user_id) REFERENCES user (user_id)',
		]);

		$this->forge->addColumn('inventory_control', 'CONSTRAINT fk_inventory_control_controller_id FOREIGN KEY (controller_id) REFERENCES user (user_id)');
	}
}
