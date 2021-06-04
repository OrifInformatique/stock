<?php


namespace stock\Database\Migrations;


class Add_Item_group extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'item_group_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ],
            'short_name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => 2,
                'null'              => true,
                'default'           => null,
            ],

        ]);


        $this->forge->addKey('item_group_id', TRUE);
        
        
        $this->forge->createTable('item_group', TRUE);

        

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item_group');
    }
}