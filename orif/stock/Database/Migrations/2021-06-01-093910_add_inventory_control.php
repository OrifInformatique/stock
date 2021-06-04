<?php


namespace stock\Database\Migrations;


class Add_InventoryControl extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'inventory_control_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'item_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'controller_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'date'=>[
                'type'              => 'date',
                'null'              => false,
            ],
            'remarks'=>[
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
                'default'           =>  null,
            ]

        ]);


        $this->forge->addKey('inventory_control_id', TRUE);
        $this->forge->addForeignKey('item_id', 'item', 'item_id');
        $this->forge->addForeignKey('controller_id', 'user', 'user_id');
        $this->forge->createTable('inventory_control', TRUE);


    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('inventory_control');
    }
}