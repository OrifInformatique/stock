<?php


namespace User\Database\Seeds;


class AddUserTypeDatas extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data=[
            ['name'=>'Administrateur','access_level'=>4],
            ['name'=>'Enregistré','access_level'=>2],
            ['name'=>'Invité','access_level'=>1]
        ];
        foreach($data as $row)
            $this->db->table('user_type')->insert($row);

    }
}