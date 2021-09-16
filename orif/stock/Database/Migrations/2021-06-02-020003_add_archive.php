<?php


namespace Stock\Database\Migrations;


class AddArchive extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->db->query('ALTER TABLE item_tag ADD archive TIMESTAMP NULL DEFAULT NULL');

        $this->db->query('ALTER TABLE stocking_place ADD archive TIMESTAMP NULL DEFAULT NULL');

        $this->db->query('ALTER TABLE supplier ADD archive TIMESTAMP NULL DEFAULT NULL');

        $this->db->query('ALTER TABLE item_group ADD archive TIMESTAMP NULL DEFAULT NULL');
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropColumn('item_tag', 'archive');
        $this->forge->dropColumn('stocking_place', 'archive');
        $this->forge->dropColumn('supplier', 'archive');
        $this->forge->dropColumn('item_group', 'archive');
    }
}