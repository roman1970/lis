<?php

use yii\db\Migration;

class m170125_035712_create_questions_answers_tests extends Migration
{
    public function up()
    {
        $this->createTable('test_questions', [
            'id' => $this->primaryKey(),
            'body' =>  'VARCHAR(255) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createTable('test_answers', [
            'id' => $this->primaryKey(),
            'body' =>  'VARCHAR(255) NOT NULL',
            'question_id' => 'INT(8) NOT NULL',
            'true' => 'INT(1) NOT NULL',
        ], 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );
        

        $this->createIndex("ux_test_answers_question_id", 'test_answers', "question_id", false);
        $this->db->createCommand('ALTER TABLE {{test_answers}} ADD FOREIGN KEY (`question_id`) REFERENCES {{test_questions}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m170125_035712_create_questions_answers_tests cannot be reverted.\n";

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
