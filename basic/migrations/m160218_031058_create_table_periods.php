<?php

use yii\db\Migration;

class m160218_031058_create_table_periods extends Migration
{
    public function up()
    {
        $this->createTable(
            '{{chl_periods}}', array(
            'id' => 'pk',
            'match' => 'INT(2) DEFAULT 0',
            'first' => 'INT(2) DEFAULT 0',
            'second' => 'INT(2) DEFAULT 0',
            'third' => 'INT(2) DEFAULT 0',
            'overtime' => 'INT(2) DEFAULT 0'
        ), 'DEFAULT CHARSET=utf8 ENGINE = INNODB'
        );

        $this->createIndex("ux_chl_matches_shot_in_goals_host", '{{chl_matches}}', "shot_in_goals_host", false);
        $this->createIndex("ux_chl_matches_shot_in_goals_guest", '{{chl_matches}}', "shot_in_goals_guest", false);
        $this->createIndex("ux_chl_matches_shot_reflected_host", '{{chl_matches}}', "shot_reflected_host", false);
        $this->createIndex("ux_chl_matches_shot_reflected_guest", '{{chl_matches}}', "shot_reflected_guest", false);
        $this->createIndex("ux_chl_matches_removal_host", '{{chl_matches}}', "removal_host", false);
        $this->createIndex("ux_chl_matches_removal_guest", '{{chl_matches}}', "removal_guest", false);
        $this->createIndex("ux_chl_matches_penalty_time_host", '{{chl_matches}}', "penalty_time_host", false);
        $this->createIndex("ux_chl_matches_penalty_time_guest", '{{chl_matches}}', "penalty_time_guest", false);
        $this->createIndex("ux_chl_matches_goals_in_more_host", '{{chl_matches}}', "goals_in_more_host", false);
        $this->createIndex("ux_chl_matches_goals_in_more_guest", '{{chl_matches}}', "goals_in_more_guest", false);
        $this->createIndex("ux_chl_matches_goals_in_less_host", '{{chl_matches}}', "goals_in_less_host", false);
        $this->createIndex("ux_chl_matches_goals_in_less_guest", '{{chl_matches}}', "goals_in_less_guest", false);
        $this->createIndex("ux_chl_matches_force_dodge_host", '{{chl_matches}}', "force_dodge_host", false);
        $this->createIndex("ux_chl_matches_force_dodge_guest", '{{chl_matches}}', "force_dodge_guest", false);
        $this->createIndex("ux_chl_matches_facedown_vic_host", '{{chl_matches}}', "facedown_vic_host", false);
        $this->createIndex("ux_chl_matches_facedown_vic_guest", '{{chl_matches}}', "facedown_vic_guest", false);


        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`shot_in_goals_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`shot_in_goals_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`shot_reflected_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`shot_reflected_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`removal_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`removal_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`penalty_time_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`penalty_time_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`goals_in_more_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`goals_in_more_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`goals_in_less_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`goals_in_less_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`force_dodge_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`force_dodge_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`facedown_vic_host`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->db->createCommand('ALTER TABLE {{chl_matches}} ADD FOREIGN KEY (`facedown_vic_guest`) REFERENCES  {{chl_periods}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();


    }

    public function down()
    {
        echo "m160218_031058_create_table_periods cannot be reverted.\n";

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
