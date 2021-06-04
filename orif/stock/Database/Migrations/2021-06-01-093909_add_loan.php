<?php


namespace stock\Database\Migrations;


class Add_Loan extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'loan_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
                'auto_increment'    => true,
            ],
            'date'=>[
                'type'              => 'date',
                'null'              => false,
            ],
            'item_localisation'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '255',
                'null'              => true,
                'default'           => null,
            ],
            'remarks'=>[
                'type'              => 'text',
                'null'              => true,
                'default'           =>  null,
            ],
            'planned_return_date'=>[
                'type'              => 'date',
                'null'              => true,
                'default'           => null,
            ],
            'real_return_date'=>[
                'type'              => 'date',
                'null'              => true,
                'default'           => null,
            ],
            'item_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'loan_by_user_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'loan_to_user_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => true,
                'default'           => null,
            ],


        ]);


        $this->forge->addKey('loan_id', TRUE);
        $this->forge->addForeignKey('item_id', 'item', 'item_id');
        $this->forge->addForeignKey('loan_by_user_id', 'user', 'user_id');
        $this->forge->addForeignKey('loan_to_user_id', 'user', 'user_id');
        $this->forge->createTable('loan', TRUE);


    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('loan');
    }
}