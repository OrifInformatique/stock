<?php


namespace User\Database\Migrations;


use CodeIgniter\Database\Migration;
use User\Models\User_type_model;

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

        // In case user_types have been set before, do not add them again
        $userTypeModel = new User_type_model();
        if (count($userTypeModel->findAll()) == 0) {
            $seeder=\Config\Database::seeder();
            $seeder->call('\User\Database\Seeds\AddUserTypeDatas');
        }
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('user_type');
    }
}