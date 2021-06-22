<?php


namespace Stock\Database\Migrations;


class UpdateCiSessions extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->db->query('ALTER TABLE ci_sessions CHANGE `timestamp` `timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->modifyColumn('ci_sessions', [
            'timestamp' => [
                'type'              => 'INT',
                'constraint'        => '10',
                'unsigned'          => true,
                'default'           => '0'
            ]
        ]);
    }
}