<?php

namespace Stock\Database\Migrations;

use CodeIgniter\Database\Migration;

class InsertDataToItemCommon extends Migration
{
    public function up()
    {
        $this->db->query('INSERT INTO item_common (name, description, image, linked_file, item_group_id)
            SELECT name, MAX(description), MAX(image), MIN(linked_file), item_group_id
            FROM item
            GROUP BY name, item_group_id'
        );

        $this->db->query('UPDATE item i
            JOIN item_common ic ON i.name = ic.name AND i.item_group_id = ic.item_group_id
            SET i.item_common_id = ic.item_common_id'
        );

        $query = $this->db->query('SELECT i.image FROM item_common ic
            RIGHT JOIN item i ON i.image = ic.image
            WHERE ic.image IS NULL'
        );

        $result = $query->getResultArray();

        if (count($result) > 0) {
            foreach ($result as $item) {
                $pathToFile = 'uploads' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . "{$item['image']}";
                if (file_exists($pathToFile) && !is_null($item['image'])) {
                    unlink($pathToFile);
                }
            }

            clearstatcache();
        }

        $this->forge->dropForeignKey('item', 'fk_item_group_id');

        $this->forge->dropColumn('item', [
            'name',
            'description',
            'image',
            'linked_file',
            'item_group_id'
        ]);

        // Remove the fk to make it NULLABLE after items have been linked to item_commons
        // Then recreate the foreign key on item_common_id
        $this->forge->modifyColumn('item', [
            'item_common_id' => [
				'type'				=> 'INT',
                'constraint'        => '11',
                'null'              => false
            ]
        ]);
        $this->forge->addForeignKey('item_common_id', 'item', '', '', 'fk_item_item_common_id');
    }

    public function down()
    {
        //
    }
}
