<?php


namespace Stock\Database\Migrations;


class UpdateCiSessions extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $fields = [
            'id' => [
                'name' => 'id',
                'type' => 'VARCHAR',
                'constraint' => 128,
                'unsigned'   => true,
            ],

            'timestamp' => [
                'name'      => 'timestamp',
                'type'      => 'TIMESTAMP',
                'default'   => 'CURRENT_TIMESTAMP',
            ]
        ];
        
        $this->forge->modifyColumn('ci_sessions', $fields);
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}