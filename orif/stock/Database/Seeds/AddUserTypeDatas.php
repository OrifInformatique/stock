<?php


namespace  Stock\Database\Seeds;


class AddUserTypeDatas extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data=[
            ['name'=>'Utilisateur','access_level'=>1],
            ['name'=>'Gestionnaire','access_level'=>2],
            ['name'=>'Administrateur','access_level'=>4],
        ];
        foreach($data as $row)
            $this->db->table('user_type')->insert($row);

    }
}