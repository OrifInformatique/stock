<?php


namespace User\Database\Migrations;


class AddCiSessions extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'              => 'INT',
                'constraint'        => '128',
                'unsigned'          => true,
            ],
            'ip_address'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false,
            ],
            'timestamp'=>[
                'type'              => 'INT',
                'null'              => false,
                'default'           => 0,
            ],
            'data'=>[
                'type'              => 'BLOB',
                'null'              =>  false,
            ]

        ]);
        $this->forge->createTable('ci_sessions',true);
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}