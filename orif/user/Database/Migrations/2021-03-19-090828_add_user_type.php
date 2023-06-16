<?php


namespace User\Database\Migrations;


use CodeIgniter\Database\Migration;

class AddUserType extends Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false,
            ],
            'access_level'=>[
                'type'              => 'INT',
                'null'              => false,
            ]

        ]);
        $this->forge->addKey('id',true);
        $this->forge->createTable('user_type',true);
        $seeder=\Config\Database::seeder();
        $seeder->call('\User\Database\Seeds\AddUserTypeDatas');
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('user_type');
    }
}