<?php


namespace  Stock\Database\Migrations;


class Add_user extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'user_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'lastname'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null,
            ],
            'firstname'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => true,
                'default'           => null,
            ],
            'username'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false,
            ],
            'password'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => false,
            ],
            'email'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '100',
                'null'              => true,
                'default'           => null,
            ],
            
            'created_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP()',
            
            'user_type_id'=>[
                'type'              => 'int',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],
            
            'is_active'=>[
                'type'              => 'tinyint',
                'constraint'        => '1',
                'default'           => 1,
            ],
        ]);


        $this->forge->addKey('user_id', TRUE);
        $this->forge->createTable('user', TRUE);

        $this->forge->addColumn('user', [
			'CONSTRAINT fk_user_type_id FOREIGN KEY (user_type_id) REFERENCES user_type (user_type_id)'
		]);


    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('user');
    }
}