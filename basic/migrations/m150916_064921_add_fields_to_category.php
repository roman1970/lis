<?php

use yii\db\Schema;
use yii\db\Migration;

class m150916_064921_add_fields_to_category extends Migration
{
    public function up()
    {
        $this->dropColumn('{{qpcategory}}', 'parent_cat');
        $this->addColumn('{{qpcategory}}', 'lft', 'INT(11) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'rgt', 'INT(11) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'level', 'INT(4) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'name', 'VARCHAR(150) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'meta_k', 'VARCHAR(225) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'meta_d', 'VARCHAR(225) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'img', 'TEXT NOT NULL');
        $this->addColumn('{{qpcategory}}', 'order', 'TINYINT(4) NOT NULL DEFAULT 0');
        $this->addColumn('{{qpcategory}}', 'show', 'TINYINT(1) NOT NULL DEFAULT 0');
        $this->addColumn('{{qpcategory}}', 'txt', 'TEXT');
        $this->addColumn('{{qpcategory}}', 'cssclass', 'VARCHAR(100) NOT NULL');
        $this->addColumn('{{qpcategory}}', 'htmlveiw', 'VARCHAR(100) NOT NULL');

    }

    public function down()
    {
        echo "m150916_064921_add_fields_to_category cannot be reverted.\n";

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
