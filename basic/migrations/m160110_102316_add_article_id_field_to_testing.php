<?php

use yii\db\Migration;

class m160110_102316_add_article_id_field_to_testing extends Migration
{
    public function up()
    {
        $this->addColumn('{{testing}}', 'article_id', 'INT(8) DEFAULT 0');
        $this->createIndex("ux_testing_testing_article_id", 'testing', "article_id", false);
        $this->db->createCommand('ALTER TABLE {{testing}} ADD FOREIGN KEY (`article_id`) REFERENCES  {{qparticles}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();



    }

    public function down()
    {
        echo "m160110_102316_add_article_id_field_to_testing cannot be reverted.\n";

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
