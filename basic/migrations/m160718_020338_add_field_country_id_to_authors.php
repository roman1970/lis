<?php

use yii\db\Migration;

class m160718_020338_add_field_country_id_to_authors extends Migration
{
    public function up()
    { /*

        $this->addColumn('{{authors}}', 'country_id', 'INT(4)  DEFAULT 236');

        $this->createIndex("ux_authors_country_id", '{{authors}}', "country_id", false);
        $this->db->createCommand('ALTER TABLE {{authors}} ADD FOREIGN KEY (`country_id`) REFERENCES  {{country}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
    */
    }

    public function down()
    {
    }
}
