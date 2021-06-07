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
                'auto_increment'    => true,
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

        
        $this->forge->createTable('item', TRUE);

        
        $this->forge->addColumn('item', [
			'CONSTRAINT fk_checked_by_user_id FOREIGN KEY (checked_by_user_id) REFERENCES user (user_id)',
			'CONSTRAINT fk_created_by_user_id FOREIGN KEY (created_by_user_id) REFERENCES user (user_id)',
			'CONSTRAINT fk_modified_by_user_id FOREIGN KEY (modified_by_user_id) REFERENCES user (user_id)',
            'CONSTRAINT fk_item_condition_id FOREIGN KEY (item_condition_id) REFERENCES item_condition (item_condition_id)',
            'CONSTRAINT fk_item_group_id FOREIGN KEY (item_group_id) REFERENCES item_group (item_group_id)',
            'CONSTRAINT fk_supplier_id FOREIGN KEY (supplier_id) REFERENCES supplier (supplier_id)',
            'CONSTRAINT fk_stocking_place_id FOREIGN KEY (stocking_place_id) REFERENCES stocking_place (stocking_place_id)'
		]);

    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item');
    }
}