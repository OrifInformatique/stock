<?php


namespace stock\Database\Migrations;


class Add_stocking_place extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'stocking_place_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ],
            'short'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '10',
                'null'              => false
            ]
        ]);


        $this->forge->addKey('stocking_place_id', TRUE);
        
        
        $this->forge->createTable('stocking_place', TRUE);


    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('stocking_place');
    }
}