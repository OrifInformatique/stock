<?php


namespace Stock\Database\Migrations;


class UpdateCiSessions extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->modifyColumn('ci_sessions', [
            'timestamp' => [
                'type'          => 'TIMESTAMP',
            ],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}