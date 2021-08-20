<?php


namespace  Stock\Database\Migrations;


class Add_ci_sessions extends \CodeIgniter\Database\Migration
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
        $this->forge->createTable('ci_sessions', TRUE);
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}