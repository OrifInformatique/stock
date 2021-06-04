<?php


namespace stock\Database\Migrations;


class Add_item_tag_link extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'item_tag_link_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'item_tag_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'item_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ]
        ]);

        $this->forge->addKey('item_tag_link_id', TRUE);
        $this->forge->addForeignKey('item_tag_id', 'item_tag', 'item_tag_id');
        $this->forge->addForeignKey('item_id', 'item', 'item_id');
        
        $this->forge->createTable('item_tag_link', TRUE);

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item_tag_link');
    }
}