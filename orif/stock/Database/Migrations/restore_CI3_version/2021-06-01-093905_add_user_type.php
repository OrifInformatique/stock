<?php


namespace  Stock\Database\Migrations;


class Add_user_type extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'user_type_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ],
            'access_level'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ]
            
        ]);


        $this->forge->addKey('user_type_id', TRUE);
        $this->forge->createTable('user_type', TRUE);

        $seeder = \Config\Database::seeder();
        $seeder->call('Stock\Database\Seeds\AddUserTypeDatas');

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('user_type');
    }
}