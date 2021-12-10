<?php


namespace  Stock\Database\Seeds;


class AddUserTypeDatas extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $data=[
            ['name'=>'Invité','access_level'=>1],
            ['name'=>'Observation','access_level'=>2],
            ['name'=>'Formation','access_level'=>4],
            ['name'=>'MSP','access_level'=>8],
            ['name'=>'Administrateur','access_level'=>16]
        ];
        foreach($data as $row)
            $this->db->table('user_type')->insert($row);

    }
}