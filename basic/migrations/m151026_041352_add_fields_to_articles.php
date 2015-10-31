<?php

use yii\db\Schema;
use yii\db\Migration;

class m151026_041352_add_fields_to_articles extends Migration
{
    public function up()
    {
        $this->addColumn('{{qparticles}}', 'tags', 'varchar(255) NOT NULL');
        $this->addColumn('{{qparticles}}', 'source_id', 'INT(11) DEFAULT 1');

        $this->createIndex("ux_qparticles_qparticles_source_id", 'qparticles', "source_id", false);
        $this->db->createCommand('ALTER TABLE {{qparticles}} ADD FOREIGN KEY (`source_id`) REFERENCES {{sources}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();


    }

    public function down()
    {
        echo "m151026_041352_add_fields_to_articles cannot be reverted.\n";

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
