<?php


namespace Stock\Database\Migrations;


class AddArchive extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addColumn('item_tag', 'archive TIMESTAMP NULL DEFAULT NULL');
        $this->forge->addColumn('stocking_place', 'archive TIMESTAMP NULL DEFAULT NULL');
        $this->forge->addColumn('supplier', 'archive TIMESTAMP NULL DEFAULT NULL');
        $this->forge->addColumn('item_group', 'archive TIMESTAMP NULL DEFAULT NULL');
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