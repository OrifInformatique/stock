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
        $this->forge->dropTable('ci_sessions');
    }
}