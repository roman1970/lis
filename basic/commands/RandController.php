<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;


use app\models\Author;
use app\models\Items;
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

    /**
     * Случайная дата Словарных
     */
    public function actionRandDataAnaPageForDiary(){

        echo date("Y-m-d", mt_rand(mktime(0,0,0,0,0,1999), time()))."\r\n";
        echo date("Y-m-d", mt_rand(mktime(0,0,0,0,0,2013), time()))."\r\n";
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
                $data = readline("Устроит ".$alboms[$rand]->title." -- ". $alboms[$rand]->author->name." ? Y или N ? ");
                if($data == 'N') {
                    $this->actionRandAlbom();
                }

                else {
                    $new_played = new Played();
                    $new_played->source_id = $alboms[$rand]->id;
                    $new_played->save(false);

                    echo "Ставь ".$alboms[$rand]->title." -- ". $alboms[$rand]->author->name.PHP_EOL;
                }

            }
            else echo "Ничего нет".PHP_EOL;
        }


    }
    
    function actionRamdItem(){
        $items = Items::find()->all();
        echo $items[rand(0, count($items)-1)]->text.PHP_EOL.
               $items[rand(0, count($items)-1)]->text.PHP_EOL.
               $items[rand(0, count($items)-1)]->text.PHP_EOL.
            $items[rand(0, count($items)-1)]->text.PHP_EOL.
             $items[rand(0, count($items)-1)]->text.PHP_EOL;
    }


    /**
     * Генератор айтемов для заучивания
     */
    function actionGenStudy(){

        if(Items::find()->where(['learned' => 2])->one()) exit('Недоученное!');
        $rand_thoughts = [];

        $dibilizmy = Items::find()
            ->where("source_id = 17 or source_id = 27 or source_id = 19")
            ->andWhere(['learned' => 0])
            ->all();
        shuffle($dibilizmy);

        $frazy = Items::find()
            ->where("source_id = 181 or source_id = 37 or source_id = 30 or source_id = 29 or source_id = 25 or source_id = 20")
            ->andWhere(['learned' => 0])
            ->all();
        shuffle($frazy);

        $study = Items::find()
            ->where("cat_id = 53 or cat_id = 136 or cat_id = 187")
            ->andWhere(['learned' => 0])
            ->all();
        shuffle($study);

        $from_out = Items::find()
            ->where("cat_id = 94 or cat_id = 104")
            ->andWhere(['learned' => 0])
            ->all();
        shuffle($from_out);

        $english = Items::find()
            ->where("cat_id = 155")
            ->andWhere(['learned' => 0])
            ->all();
        shuffle($english);

       // var_dump($frazy); exit;

        if(!empty($dibilizmy)) {
            $rand_dib = $dibilizmy[rand(0, count($dibilizmy)-1)];
            if($rand_dib) {
                $rand_dib->learned = 2;
                $rand_dib->update(false);
                $rand_thoughts[$rand_dib->source->title.' - '.$rand_dib->source->author->name] = $rand_dib->text;
            } 
        }

        if(!empty($frazy)) {
            //var_dump($frazy);
            $rand_phrase = $frazy[rand(0, count($frazy) - 1)];
            if($rand_phrase) {
                $rand_phrase->learned = 2;
                $rand_phrase->update(false);
                $rand_thoughts[$rand_phrase->source->title.' - '.$rand_phrase->source->author->name] = $rand_phrase->text;
            } 
        }
       
        if(!empty($study)) {
            $rand_study = $study[rand(0, count($study)-1)];
            if($rand_study) {
                $rand_study->learned = 2;
                $rand_study->update(false);
                $rand_thoughts[$rand_study->source->title.' - '.$rand_study->source->author->name] = $rand_study->text;
            }
        }

        if(!empty($from_out)) {
            $rand_from = $from_out[rand(0, count($from_out)-1)];
            if($rand_from) {
                $rand_from->learned = 2;
                $rand_from->update(false);
                $rand_thoughts[$rand_from->source->title.' - '.$rand_from->source->author->name] = $rand_from->text;
            }
        }

        if(!empty($english)){
            $rand_english = $english[rand(0, count($english)-1)];
            if($rand_english) {
                $rand_english->learned = 2;
                $rand_english->update(false);
                $rand_thoughts[$rand_english->source->title.' - '.$rand_english->source->author->name] = $rand_english->text;
            }

        }


        $html = '<style>p,h4{text-align: center; color: white}hr{margin: 0}</style>
                 <h4>Учить</h4>
                                                      <div>';

        foreach ($rand_thoughts as $author => $item){
            $html .= '<p>'.nl2br($item).'<br>'.'('.$author.')</p><br><hr>';
        }

        $html .= '</div><button type="button" class="btn btn-success btn-lg btn-block" onclick="learned()">Выучил!</button>
                 <p id="request_learned"></p> ';

        $rem = fopen("/home/romanych/public_html/plis/basic/data/remember.html", "w");
        $res = fwrite($rem, $html);
        fclose($rem);

    }

}