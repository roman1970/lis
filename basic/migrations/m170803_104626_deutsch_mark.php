<?php

use yii\db\Migration;

class m170803_104626_deutsch_mark extends Migration
{
    public function safeUp()
    {
        $this->createTable('deutsch_mark', [
            'id' => $this->primaryKey(),
            'user_id' =>  'VARCHAR(255) NOT NULL',
            'mark' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_deutsch_mark_user_id", 'deutsch_mark', "user_id", false);
        
        $this->db->createCommand("ALTER TABLE {{deutsch_mark}} MODIFY COLUMN {{user_id}} INT(8) NOT NULL")->execute();
        $this->db->createCommand('ALTER TABLE {{deutsch_mark}} ADD FOREIGN KEY (`user_id`) REFERENCES {{mark_user}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function safeDown()
    {
        echo "m170803_104626_deutsch_mark cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170803_104626_deutsch_mark cannot be reverted.\n";

        return false;
    }
    */
}
