<?php


namespace  Stock\Database\Migrations;


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


        $this->forge->createTable('item_tag_link', TRUE);

        $this->forge->addColumn('item_tag_link', [
            'CONSTRAINT fk_item_id FOREIGN KEY (item_id) REFERENCES item (item_id)',
            'CONSTRAINT fk_item_tag_id FOREIGN KEY (item_tag_id) REFERENCES item_tag (item_tag_id)'
        ]);
        

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item_tag_link');
    }
}