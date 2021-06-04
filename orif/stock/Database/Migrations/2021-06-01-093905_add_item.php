<?php


namespace stock\Database\Migrations;


class Add_Item extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'item_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'inventory_prefix'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null,
            ],
            'description'=>[
                'type'              => 'text',
                'null'              => true,
                'default'           => null,
            ],
            'image'=>[
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => true,
                'default'           => null,
            ],
            'serial_number'=>[
                'type'              => 'varchar',
                'constraint'        => 45,
                'null'              => true,
                'default'           => null,
            ],
            'buying_price'=>[
                'type'              => 'float',
                'null'              => true,
                'default'           => null,
            ],
            'buying_date'=>[
                'type'              => 'date',
                'null'              => true,
                'default'           => null,
            ],
            'warranty_duration'=>[
                'type'              => 'int',
                'constraint'        => 11,
                'null'              => true,
                'default'           => null,
            ],
            'remarks'=>[
                'type'              => 'text',
                'null'              => true,
                'default'           => null,
            ],
            'linked_file'=>[
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => true,
                'default'           => null,
            ],
            'supplier_id'=>[
                'type'              => 'int',
                'constraint'        => 11,
                'null'              => true,
                'default'           => null,
            ],
            'supplier_ref'=>[
                'type'              => 'varchar',
                'constraint'        => 45,
                'null'              => true,
                'default'           => null,
            ],
            'created_by_user_id'=>[
                'type'              => 'int',
                'constraint'        => 11,
                'null'              => true,
                'default'           => null,
            ],

            'created_date timestamp DEFAULT CURRENT_TIMESTAMP()',

            'modified_by_user_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
            'modified_date'=>[
                'type'              => 'datetime',
                'null'              => true,
                'default'           => null,
            ],
            'checked_by_user_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
            'checked_date'=>[
                'type'              => 'datetime',
                'null'              => true,
                'default'           => null,
            ],
            'stocking_place_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
            'item_condition_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
            'item_group_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],



        ]);


        $this->forge->addKey('item_id', TRUE);
        $this->forge->addForeignKey('supplier_id', 'supplier', 'supplier_id');
        $this->forge->addForeignKey('created_by_user_id', 'user', 'user_id');
        $this->forge->addForeignKey('modified_by_user_id', 'user', 'user_id');
        $this->forge->addForeignKey('checked_by_user_id', 'user', 'user_id');
        $this->forge->addForeignKey('stocking_place_id', 'stocking_place', 'stocking_place_id');
        $this->forge->addForeignKey('item_condition_id', 'item_condition', 'item_condition_id');
        $this->forge->addForeignKey('item_group_id', 'item_group', 'item_group_id');
        
        
        $this->forge->createTable('item', TRUE);

        
       /* $seeder=\Config\Database::seeder();
        $seeder->call('\stock\Database\Seeds\AddUserDatas');
*/
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item');
    }
}