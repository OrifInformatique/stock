<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLoanEmail extends Migration
{
	public function up()
	{
		$this->forge->addColumn('loan', 'borrower_email VARCHAR(100) NULL DEFAULT NULL');
	}

	public function down()
	{
		$this->forge->dropColumn('loan', 'borrower_email');
	}
}
