<?php

namespace User\Database\Migrations;

class AddAzureMail extends \CodeIgniter\Database\Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        $fields = [
            'azure_mail' =>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null,
                
                // Where to place the field
                'after'             => 'email',
            ],
        ];
        $forge->addColumn('user', $fields);
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        // $this->forge->dropTable('user');
        $this->forge->dropColumn('user', 'azure_mail'); // to drop one single column
    }
}