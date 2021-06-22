<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Adduserdetails extends Migration
{
	public function up()
	{
		// Query to clone user table as user_details with wanted rows
		$this->db->query('CREATE TABLE user_details SELECT user_id AS fk_user, lastname, firstname FROM user');

		// PRIMARY constraint won't be cloned, so we add it manually
		$this->forge->addColumn('user_details', 'CONSTRAINT user_detail PRIMARY KEY (fk_user)');
	}


	public function down()
	{
		$this->forge->dropTable('user_details', true);
	}
}
