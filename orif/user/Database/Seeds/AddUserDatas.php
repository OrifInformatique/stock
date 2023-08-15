<?php


namespace User\Database\Seeds;
use User\Models\User_type_model;


class AddUserDatas extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $userTypeModel = new User_type_model();
        $adminTypeId = $userTypeModel->where('access_level', config('\User\Config\UserConfig')->access_lvl_admin)->first()['id'] ?? 1;
        $registeredTypeId = $userTypeModel->where('access_level', config('\User\Config\UserConfig')->access_lvl_registered)->first()['id'] ?? 2;
        $data = [
            [
                'fk_user_type' => $adminTypeId,
                'username' => 'admin',
                'password' => '$2y$10$84r63xo.M4LVcIi8IvT8cO0qYxyglPshY1jJmKLedRMcaTcxhcVYO'
            ],
            [
                'fk_user_type' => $registeredTypeId,
                'username' => 'utilisateur',
                'password' => '$2y$10$11wIuR3FnfWwTpfyJ9WCz.E3KErvb.i.Q2Wef6XMUZHTXUlW0FhJm'
            ]
        ];
        foreach($data as $row)
        $this->db->table('user')->insert($row);
    }
}