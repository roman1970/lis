<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;


use app\models\Author;
use app\models\Played;
use app\models\Source;
use yii\console\Controller;
use Yii;
use yii\helpers\ArrayHelper;


class RandController extends Controller
{

    public function actionIndex()
    {
        $methods = get_class_methods($this);
        echo 'Actions:' . "\r\n";
        foreach ($methods as $method)
            if (preg_match('/^action(.+)$/', $method, $match))
                echo ' - ' . $match[1] . "\r\n";
    }

    public function actionRandDataAnaPageForDiary(){

        echo date("Y-m-d", mt_rand(mktime(0,0,0,0,0,2009), time()))."\r\n";
    }

    public function actionRandDataAnaPageForDiaryPage($max){

        echo mt_rand(0,$max)."\r\n";
    }

    /**
     * Выбрать альбом для прослушивания
     */
    public function actionRandAlbom($unusual = 0){


        if($unusual) {
            $played = implode(',',ArrayHelper::map(Played::find()
                ->all(), 'id', 'source_id'));

            $alboms = Source::find()
                ->where("id NOT IN (".$played.")")
                ->andWhere(['status' => 3])
                ->all();

            if($alboms) {
                $rand = rand(0,count($alboms));

                $new_played = new Played();
                $new_played->source_id = $alboms[$rand]->id;
                $new_played->save(false);

                echo "Ставь ".$alboms[$rand]->title." -- ". $alboms[$rand]->author->name.PHP_EOL;
            }
            else echo "Ничего нет".PHP_EOL;


        }

        else {
            $played = implode(',',ArrayHelper::map(Played::find()
                ->all(), 'id', 'source_id'));

            $alboms = Source::find()
                ->where("id NOT IN (".$played.")")
                ->andWhere(['status' => 1])
                ->all();

            if($alboms) {

                $rand = rand(0,count($alboms));

                $new_played = new Played();
                $new_played->source_id = $alboms[$rand]->id;
                $new_played->save(false);

                echo "Ставь ".$alboms[$rand]->title." -- ". $alboms[$rand]->author->name.PHP_EOL;
            }
            else echo "Ничего нет".PHP_EOL;
        }


    }

}