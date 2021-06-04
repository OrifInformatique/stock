<?php

namespace App\Database\Migrations;


class Add_CiSession extends \CodeIgniter\Database\Migration {


    public function up(){

        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 128
            ],
            'ip_address'=> [
                'type' => 'VARCHAR',
                'constraint' => 45
            ],
            'timestamp' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0
            ],
            'data'       => [
                'type' => 'BLOB'
            ]
        ]);
        
        $this->forge->addKey('id', TRUE);
        
        $this->forge->createTable('ci_sessions', TRUE);

    }

    public function down(){
        $this->forge->dropTable('ci_sessions');

    }

}

?>