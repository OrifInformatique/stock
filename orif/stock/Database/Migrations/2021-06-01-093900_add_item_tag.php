<?php


namespace stock\Database\Migrations;


class Add_item_tag extends \CodeIgniter\Database\Migration
{

    /**
     * @inheritDoc
     */
    public function up()
    {
        $this->forge->addField([
            'item_tag_id'=>[
                'type'              => 'INT',
                'constraint'        => '11',
                'null'              => false,
            ],
            'name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false
            ],
            'short_name'=>[
                'type'              => 'VARCHAR',
                'constraint'        => '3',
                'null'              => true,
                'default'           => null
            ]
        ]);

        $this->forge->addKey('item_tag_id', TRUE);
        
        
        $this->forge->createTable('item_tag', TRUE);
 
       /* $seeder=\Config\Database::seeder();
        $seeder->call('\stock\Database\Seeds\AddUserDatas');
*/
    }

    /**
     * @inheritDoc
     */
    public function down()
    {
        $this->forge->dropTable('item_tag');
    }
}