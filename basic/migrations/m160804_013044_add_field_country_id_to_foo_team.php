<?php

use yii\db\Migration;

class m160804_013044_add_field_country_id_to_foo_team extends Migration
{
    public function up()
    {
        $this->addColumn('{{foo_team}}', 'country_id', 'INT(4) DEFAULT 236');

        $this->createIndex("ux_foo_team_country_id", 'foo_team', "country_id", false);
        $this->db->createCommand('ALTER TABLE {{foo_team}} ADD FOREIGN KEY (`country_id`) REFERENCES {{country}}(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;')->execute();

    }

    public function down()
    {
    }
}
