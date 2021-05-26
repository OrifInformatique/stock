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
                'type'              => 'VARCHAR',
                'constraint'        => '128',
                'unsigned'          => true,
            ],
            'ip_address'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false,
            ],
            'timestamp'=>[
                'type'              => 'TIMESTAMP',
                'null'              => false,
                'default'           => 'CURRENT_TIMESTAMP',
            ],
            'data'=>[
                'type'              => 'BLOB',
                'null'              =>  false,
            ]

        ]);
        $this->forge->createTable('ci_sessions',true);
        $this->forge->addKey('timestamp', "ci_sessions_timestamp");
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}