<?php

use yii\db\Migration;
use app\components\Helper;

class m160418_070836_fill_currency_tbls extends Migration
{
    public function up()
    {
        for($i=0; $i<45; $i++) {

            $data = Helper::getDateIntervalYesterdayInDashOrSlashFormat(new \DateTime(), $i, 'slash');

            $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req='.$data;


            $xml_contents = file_get_contents($url);
            if ($xml_contents === false)
                throw new \ErrorException('Error loading ' . $url);

            $xml = new \SimpleXMLElement($xml_contents);


            $date = $xml->attributes()->Date;

            foreach ($xml as $node) {
                $current_curr = new \app\models\CurrHistory();
                if(\app\models\Currencies::findOne(['valute_id' => $node->attributes()->ID]))
                    $current_curr->currency_id = \app\models\Currencies::findOne(['valute_id' => $node->attributes()->ID]);
                else {
                    $new_currency = new \app\models\Currencies();
                    $new_currency->name = $node->Name;
                    $new_currency->valute_id = $node->attributes()->ID;
                    $new_currency->char_code = $node->CharCode;
                    $new_currency->num_code = $node->NumCode;
                    $new_currency->save();
                    $current_curr->currency_id = $new_currency->id;
                }

                $current_curr->date = $date;
                $current_curr->nominal = $node->Nominal;
                $current_curr->value = $node->Value;

                $current_curr->save();

            }

        }

    }

    public function down()
    {
        echo "m160418_070836_fill_currency_tbls cannot be reverted.\n";

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
