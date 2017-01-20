<?php

use yii\db\Migration;

class m160825_062402_add_cat_id_to_sources extends Migration
{
    public function up()
    {
       /* $this->addColumn('{{sources}}', 'cat_id', 'INT(4)  DEFAULT 1');

        $this->createIndex("ux_sources_cat_id", 'sources', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{sources}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
       */
    }

    public function down()
    {
    }
}
