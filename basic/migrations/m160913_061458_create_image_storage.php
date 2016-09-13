<?php

use yii\db\Migration;

class m160913_061458_create_image_storage extends Migration
{
    public function up()
    {
        $this->createTable('image_storage', [
            'id' => $this->primaryKey(),
            'img' => 'VARCHAR(255) NOT NULL',
            'orig_tag' => 'VARCHAR(255) NOT NULL',
            'cont_art_id' => 'INT(8) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
        
        $this->createIndex("ux_image_storage_cont_art_id", 'image_storage', "cont_art_id", false);
        $this->db->createCommand('ALTER TABLE {{image_storage}} ADD FOREIGN KEY (`cont_art_id`) REFERENCES {{qparticles_content}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
        $this->dropTable('image_storage');
    }
}
