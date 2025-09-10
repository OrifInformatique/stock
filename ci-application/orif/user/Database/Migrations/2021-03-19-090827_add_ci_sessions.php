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
                'null'              => false
            ],
            'ip_address'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ],
            'timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'data'=>[
                'type'              => 'blob',
                'null'              => false
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addKey('timestamp');
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