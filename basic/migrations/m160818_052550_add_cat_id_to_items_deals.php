<?php

use yii\db\Migration;

class m160818_052550_add_cat_id_to_items_deals extends Migration
{
    public function up()
    {
        $this->addColumn('{{deals}}', 'cat_id', 'INT(4)  DEFAULT 57');
        $this->addColumn('{{items}}', 'cat_id', 'INT(4)  DEFAULT 57');

        $this->createIndex("ux_items_cat_id", 'items', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{items}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();
        $this->createIndex("ux_deals_cat_id", 'deals', "cat_id", false);
        $this->db->createCommand('ALTER TABLE {{deals}} ADD FOREIGN KEY (`cat_id`) REFERENCES {{qpcategory}} (`id`) ON DELETE CASCADE ON UPDATE NO ACTION ;')->execute();

    }

    public function down()
    {
    }
}
