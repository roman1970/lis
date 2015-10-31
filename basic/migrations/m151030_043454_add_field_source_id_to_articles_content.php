<?php

use yii\db\Migration;

class m151030_043454_add_field_source_id_to_articles_content extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles_content}}', 'source_id', 'INT(1) DEFAULT 1');

        $this->createIndex("ux_qparticles_content_qparticles_content_source_id", 'qparticles_content', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles_content}} ADD FOREIGN KEY (`source_id`) REFERENCES {{sources}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

    }

    public function down()
    {
        echo "m151030_043454_add_field_source_id_to_articles_content cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
