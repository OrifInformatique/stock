<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use User\Models\User_model;
use User\Models\User_type_model;

class UpdateAccessLevels extends Migration
{
	public function up()
	{
		$user_model = new User_model();
		$user_type_model = new User_type_model();

		$types = $user_type_model->findColumn('id');
		// Only change user types if they haven't been changed yet
		if (in_array(4, $types) || in_array(5, $types)) {
			// Downgrade formation users to observation
			$user_model->where('fk_user_type', 3)->set(['fk_user_type' => 2])->update();

			// Downgrade admin and msp users to formation
			$user_model->whereIn('fk_user_type', [4, 5])->set(['fk_user_type' => 3])->update();
		}

		// Rename first three user types
		$this->db->query('UPDATE user_type SET name = "Utilisateur" WHERE id = 1');
		$this->db->query('UPDATE user_type SET name = "Gestionnaire" WHERE id = 2');
		$this->db->query('UPDATE user_type SET name = "Administrateur" WHERE id = 3');

		// Delete other types
		$user_type_model->whereIn('id', [4, 5])->delete();
	}

	public function down()
	{
		// There's no way to correctly undowngrade user types without the old data, so we just don't

		$user_type_model = new User_type_model();

		// Rename types
		$this->db->query('UPDATE user_type SET name = "Invité" WHERE id = 1');
		$this->db->query('UPDATE user_type SET name = "Observation" WHERE id = 2');
		$this->db->query('UPDATE user_type SET name = "Formation" WHERE id = 3');

		// Bring back deleted types
		$user_type_model->ignore(true)->insert([
			'id' => 4,
			'name' => 'MSP',
			'access_level' => 8,
		]);
		$user_type_model->ignore(true)->insert([
			'id' => 5,
			'name' => 'Administrateur',
			'access_level' => 16,
		]);
	}
}
