<?php


namespace stock\Database\Migrations;


class Add_Item_condition extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'item_condition_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ]
        ]);


        $this->forge->addKey('item_condition_id', TRUE);
        
        
        $this->forge->createTable('item_condition', TRUE);

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item_condition');
    }
}