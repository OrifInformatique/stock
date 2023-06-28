<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserEntityDefault extends Migration
{
	public function up()
	{
		$this->forge->addColumn('user_entity', [
            'default' => [
                'type'				=> 'BOOLEAN',
				'null'				=> false,
                'default'           => false,
				'after'				=> 'fk_user_id'
            ]
        ]);
	}

	public function down()
	{
		$this->forge->dropColumn('user_entity', 'default');
	}
}
