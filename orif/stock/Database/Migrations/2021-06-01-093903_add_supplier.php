<?php


namespace stock\Database\Migrations;


class Add_supplier extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'supplier_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => false
            ],
            'address_line1'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null
            ],
            'address_line2'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null
            ],
            'zip'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null
            ],
            'city'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null
            ],
            'country'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null
            ],
            'tel'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null
            ],
            'email'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null
            ]

        ]);

        $this->forge->addKey('supplier_id', TRUE);
        
        
        $this->forge->createTable('supplier', TRUE);

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('supplier');
    }
}