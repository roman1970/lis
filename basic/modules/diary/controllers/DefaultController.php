<?php

namespace app\modules\diary\controllers;

use app\components\BackEndController;
use Yii;
use app\models\Categories;
use yii\data\Pagination;
use yii\helpers\Url;

use app\modules\diary\models\Prod;
use app\modules\diary\models\Maner;
use app\modules\diary\models\Money;
use app\modules\diary\models\Ormon;
use app\modules\diary\models\Pogoda;
use app\modules\diary\models\Sumtel;
use app\modules\diary\models\Telbase;
use app\modules\diary\models\Telephone;

class DefaultController extends BackEndController
{

    public function actionIndex2()
    {  
        
        $prod = new Prod();
        $prods = $prod::find()
            ->limit(10)
            ->all();

        return $this->render('index',[
                
                'prods' => $prods,

            ]);
    }
    
    public function actionBlock()
    {  
        
        return $this->render('block',[
               
            ]);
    }
    
    public function actionIndex()
    {  
        
        
        //Человек
        $mod_maner = new Maner();
        
        $year = \Yii::$app->request->get('year', 2015);
        $max_id_maner = $mod_maner::find()
            ->select('MAX(id)')
            ->where(['year' => $year])
            ->scalar();
        
        $last_maner = $mod_maner::find()
            ->where(['id' => $max_id_maner])
            ->one();

        echo Url::home();  exit;
        $this->pChart($mod_maner, $max_id_maner, 'day', 'weigth');
		
        $this->pChart($mod_maner, $max_id_maner, 'day', 'ocenka');
        
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_maner, "weigth", 2014 ),$this->avgMonthes($mod_maner, "weigth", $year ));
        
		
        
        $sum_bal_for_seven_days =  $mod_maner::find()
            ->select('SUM(ocenka)')
            ->andWhere("id > $max_id_maner - 7")
            ->limit(7)
            ->scalar();
        $aver_seven = $sum_bal_for_seven_days/7;
        
        $kt_average = $mod_maner::find()
            ->select('AVG(kt)')
            ->where(['year' => $year])
            ->scalar();
        if($kt_average != 0)$ktt = round(1 / $kt_average, 1);
        else {$ktt = "Нет данных";} 
        
        $se_average = $mod_maner::find()
            ->select('AVG(s)')
            ->where(['year' => $year])
            ->scalar();
        if($se_average != 0)$see = round(1 / $se_average, 1);
        else {$see = "Нет данных";} 
        
        $srskor = $mod_maner::find()
            ->select('AVG(srskor)')
            ->where(['year' => $year])
          //  ->andWhere("srskor > '0'")
            ->scalar();
			
			
        
        $sum_poezk = $mod_maner::find()
            ->select('SUM(poezdk)')
            ->where(['year' => $year])
            ->scalar();
        
        //гистограмма средней скорости транспорта по дням недели и месяцам
        $this->pChartBarGrafWeek($this->avgWeekDays($mod_maner, "srskor", 2014 ),$this->avgWeekDays($mod_maner, "srskor", $year ));
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_maner, "srskor", 2014 ),$this->avgMonthes($mod_maner, "srskor", $year ));
        
        //гистограмма оценок по дням недели
        $this->pChartBarGrafWeek($this->avgWeekDays($mod_maner, "ocenka", 2014 ),$this->avgWeekDays($mod_maner, "ocenka", $year ));
        
        //Погода
        $mod_pogoda = new Pogoda();
        
        $max_id_pogoda = $mod_pogoda::find()
            ->select('MAX(id)')
            ->scalar();
        
        $last_pogoda = $mod_pogoda::find()
            ->where(['id' => $max_id_pogoda])
            ->one();
        
        
        //Деньги
        $mod_money = new Money();
        
        $max_id_money = $mod_money::find()
            ->select('MAX(id)')
            ->scalar();
        
        $today_money = $mod_money::find()
            ->where(['id' => $max_id_money])
            ->one();
        $yes_money = $mod_money::find()
            ->where(['id' => ($max_id_money - 1)])
            ->one();
        $before_yes_money = $mod_money::find()
            ->where(['id' => ($max_id_money - 2)])
            ->one();
        $on_cards = $today_money->sv_kart + $today_money->r_kart;
        
        $this->pChart($mod_money, $max_id_money, 'day', 'dol', 'eur');
        $this->pChart($mod_money, $max_id_money, 'day', 'sber', 'brent');
        
        //Продукты
        $mod_prod = new Prod();
        
        $max_id_prod = $mod_prod::find()
            ->select('MAX(id)')
            ->scalar();
        
        $totminus =  $mod_prod::find()
            ->select('totminus')
            ->where(['year' => $year])
            ->andWhere(['id' => $max_id_prod])
            ->one();
        
        $prih_s =  $mod_prod::find()
            ->select('SUM(prih_s)')
            ->where(['year' => $year])
            ->scalar();
        
        $prih_r =  $mod_prod::find()
            ->select('SUM(prih_r)')
            ->where(['year' => $year])
            ->scalar();
        
        $totplus_sum =  $mod_prod::find()
            ->select('SUM(totplus)')
            ->where(['year' => $year])
            ->scalar();
        
        $totminus_sum =  $mod_prod::find()
            ->select('SUM(totminus)')
            ->where(['year' => $year])
            ->scalar();
			
        
        //гистограммы  калорий по дням недели и месяцам
        $this->pChartBarGrafWeek($this->avgWeekDays($mod_prod, "tottot", 2014 ),$this->avgWeekDays($mod_prod, "tottot", $year ));
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_prod, "tottot", 2014 ),$this->avgMonthes($mod_prod, "tottot", $year ));
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_prod, "totminus", 2014 ),$this->avgMonthes($mod_prod, "totminus", $year ));
		 $this->pChartBarGrafMonthes($this->avgMonthes($mod_prod, "totplus", 2014 ),$this->avgMonthes($mod_prod, "totplus", $year ));
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_prod, "fruct", 2014 ),$this->avgMonthes($mod_prod, "fruct", $year ));
        
        //$non_analis = $totplus - $totminus_sum;
        
        //Шагомер
        $mod_ormon = new Ormon();
        
        $max_id_ormon = $mod_maner::find()
            ->select('MAX(id)')
            ->scalar();
        
        $this->ormonGraf($mod_ormon, $max_id_ormon);
        $this->pChartBarGrafMonthes($this->avgMonthes($mod_ormon, "totalstep", 2014 ),$this->avgMonthes($mod_ormon, "totalstep", $year ));
        
        $datas = $mod_prod::find()
            ->where(['year' => $year])
            ->all();
        
        $best_shops = $this->bestShops($datas);
        $spends = $this->spends($datas);
    
        return $this->render('fourteen',[
               'last_maner' => $last_maner,
               'last_pogoda' => $last_pogoda,
               'yesterday' => $this->getYesterday(),
               'aver_seven' => $aver_seven,
               'today_money' => $today_money,
               'yes_money' => $yes_money,
               'before_yes_money' => $before_yes_money,
               'totminus' => $totminus->totminus,
			   'totplus' => $totplus_sum,
               'ktt' => $ktt,
               'see' => $see,
               'best_shops' => $best_shops,
               'prih_s' => $prih_s,
               'prih_r' => $prih_r,
               //'totplus' => $totplus,
                'totminus_sum' => $totminus_sum,
                //'non_analis' => $non_analis
                'on_cards' => $on_cards,
                'spends' => $spends,
                'sum_poezdk' => $sum_poezk
            
            ]);
    }
    
    public function actionTeams()
    {  
       
        $model = new \frontend\modules\football\models\Teams();
       // получаем GET параметр из request, если его там нет, умолчание равно 1
        $id = \Yii::$app->request->get('id', 1);
        $teams = $model::find()
            ->where(['country_id' => $id])
            ->all();
        
        $mod_cntr = new \frontend\modules\football\models\Countries();
        
        $country = $mod_cntr::find()
            ->where(['id_country' => $id])
            ->one();
        
        foreach ($teams as $key => $team) {
            $teams_items[] = $team->team;
            
        }
       
        return $this->render('teams',[
                'teams' => $teams_items,
                'country' => $country->name
            ]);
    }
    
     /**
     * Возвращает вчерашнюю метку
     * @return timestamp
     */
    public function getYesterday(){
      $yesterday =  mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
      return $yesterday;
    }
    
    /**
     * Рисуем графики с помощью библиотеки pChart
     * @param object $model
     * @param integer $max_id
     * @param integer $x
     * @param integer $y
     */
    public function pChart($model, $max_id, $x, $y, $y2=NULL){
        /* Include the pData class */ 
        require_once '/../../pChart/pChart/pData.class';
        require_once '/../pChart/pChart/pCache.class'; 
        require_once '/../pChart/pChart/pChart.class'; 
        

        //создаем объект данных 
        $myData = new \pData(); 
       
        if(!$y2){$datas = $model::find()
            ->select([$x, $y])
            ->andWhere("id > $max_id - 7")
            ->all();
        }
        
        else { $datas = $model::find()
            ->select([$x, $y, $y2])
            ->andWhere("id > $max_id - 7")
            ->all();
        }
        
       
        
        foreach ($datas as $key => $data) {
            
            $myData->AddPoint($data->$x,$x); 
            $myData->AddPoint($data->$y,$y); 
            if($y2 != NULL) $myData->AddPoint($data->$y2,$y2); 
        } 
		
        
        //устанавливаем точки с датами 
        //на ось абсцисс 
        $myData->SetAbsciseLabelSerie($x); 
        //помечаем данные как предназначеные для 
        //отображения 
        $myData->AddSerie($y); 
        $myData->AddSerie($y2); 
        //устанавливаем имена 
        $myData->SetSerieName($y); 
        $myData->SetSerieName($y2); 
	
        //создаем график шириной  и высотой  px 
        $graph = new \pChart(340,130); 
        //устанавливаем шрифт и размер шрифта 
        $graph->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf', true),8); 
        //координаты левой верхней вершины и правой нижней 
        //вершины графика 
        $graph->setGraphArea(35,20,330,110); 
        //добавляем бэкграунд
        $graph->drawBackground(255,0,0);
        $graph->drawGraphAreaGradient(132,153,172,50,TARGET_BACKGROUND); 
		
        //рисуем заполненный четырехугольник 
        $graph->drawFilledRoundedRectangle(7,7,993,493,5,240,240,240); 
        //теперь незаполненный для эффекта тени 
        $graph->drawRoundedRectangle(5,5,995,495,5, 0, 200, 0); 
		
        //прорисовываем фон графика 
        $graph->drawGraphArea(200,255,255,TRUE); 
        //устанавливаем данные для графиков 
		
        $graph->drawScale($myData->GetData(), 
        $myData->GetDataDescription(), 
        SCALE_NORMAL,10,10,10,true,0,2); 
		
        //рисуем сетку для графика 
        $graph->drawGrid(4,TRUE,200,230,230,50); 
        //прорисовываем линейные графики 
        $graph->drawLineGraph($myData->GetData(), 
        $myData->GetDataDescription()); 
        // рисуем точки на графике 
        $graph->drawPlotGraph($myData->GetData(), 
        $myData->GetDataDescription(),3,2,255,255,255); 
        // пишем в подвале некоторый текст 
        $graph->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf', true),8); 
       
        $graph->drawTextBox(805,470,990,480,"$x", 
            0,150,150,150,ALIGN_CENTER,TRUE,-1,-1,-1,30); 
        
        $graph->drawTextBox(10,470,140,480,"$y", 
            0,250,250,250,ALIGN_CENTER,TRUE,-1,-1,-1,30); 
        
            //ложим легенду 
        $graph->drawLegend(90,35,$myData->GetDataDescription(),255,255,255); 
            //Пишем заголовок 
        $graph->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf', true),8);  
        $graph->drawTitle(480,22, 
        "График", 
        50,50,50,-1,-1,true); 
        //выводим в браузер 
        $graph->Render(Url::to('@app/web/uploads/'.$y.'.png')); 

    }
    /**
     * Помещает данные шагомера в график
     * @param object $model
     * @param integer $max_id
     */
    public function ormonGraf($model, $max_id){
        $datas = $model::find()
            ->where("id > $max_id - 7")
            ->all();
        
        foreach ($datas as $key => $data) {
            
            $steph1 += $data->steph1;          
            $steph2 += $data->steph2;
            $steph3 += $data->steph3;
            $steph4 += $data->steph4;
            $steph5 += $data->steph5;          
            $steph6 += $data->steph6;
            $steph7 += $data->steph7;
            $steph8 += $data->steph8;
            $steph9 += $data->steph8;          
            $steph10 += $data->steph10;
            $steph11 += $data->steph11;
            $steph12 += $data->steph12;
            $steph13 += $data->steph13;          
            $steph14 += $data->steph14;
            $steph15 += $data->steph15;
            $steph16 += $data->steph16;
            $steph17 += $data->steph17;
            $steph18 += $data->steph18;
            $steph19 += $data->steph19;
            $steph20 += $data->steph20;          
            $steph21 += $data->steph21;
            $steph22 += $data->steph22;
            $steph23 += $data->steph23;
            
            $aerosteph1 += $data->aerosteph1;          
            $aerosteph2 += $data->aerosteph2;
            $aerosteph3 += $data->aerosteph3;
            $aerosteph4 += $data->aerosteph4;
            $aerosteph5 += $data->aerosteph5;          
            $aerosteph6 += $data->aerosteph6;
            $aerosteph7 += $data->aerosteph7;
            $aerosteph8 += $data->aerosteph8;
            $aerosteph9 += $data->aerosteph8;          
            $aerosteph10 += $data->aerosteph10;
            $aerosteph11 += $data->aerosteph11;
            $aerosteph12 += $data->aerosteph12;
            $aerosteph13 += $data->aerosteph13;          
            $aerosteph14 += $data->aerosteph14;
            $aerosteph15 += $data->aerosteph15;
            $aerosteph16 += $data->aerosteph16;
            $aerosteph17 += $data->aerosteph17;
            $aerosteph18 += $data->aerosteph18;
            $aerosteph19 += $data->aerosteph19;
            $aerosteph20 += $data->aerosteph20;          
            $aerosteph21 += $data->aerosteph21;
            $aerosteph22 += $data->aerosteph22;
            $aerosteph23 += $data->aerosteph23;
            
        }
            
        $arrSteps = [$steph1, $steph2, $steph3, $steph4, $steph5, $steph6, $steph7, $steph8, $steph9,
            $steph10, $steph11, $steph12, $steph13, $steph14, $steph15, $steph16, $steph17, 
            $steph18, $steph19, $steph20, $steph21, $steph22, $steph23];    
        
        $arrAeroteps = [$aerosteph1, $aerosteph2, $aerosteph3, $aerosteph4, $aerosteph5, $aerosteph6, $aerosteph7, $aerosteph8, $aerosteph9,
            $aerosteph10, $aerosteph11, $aerosteph12, $aerosteph13, $aerosteph14, $aerosteph15, $aerosteph16, $aerosteph17, 
            $aerosteph18, $aerosteph19, $aerosteph20, $aerosteph21, $aerosteph22, $aerosteph23];
            
        $this->gistiogram($arrSteps, 'steps'); 
        $this->gistiogram($arrAeroteps, 'aerosteps'); 
        
    }
    
    
    /**
     * Рисует гистограмму
     * @param array $parArr
     */
    public function gistiogram($parArr, $type){
            
            $x1 = 30;
            $y1 = (100 - $parArr[0] / 100);
            $x2 = 40;
            $y2 = 100;
            $x3 = 40;
            $y3 = (100 - $parArr[1] / 100);
            $x4 = 50;
            $y4 = 100;
            $x5 = 50;
            $y5 = (100 - $parArr[2] / 100);
            $x6 = 60;
            $y6 = 100;
            $x7 = 60;
            $y7 = (100 - $parArr[3] / 100);
            $x8 = 70;
            $y8 = 100;
            $x9 = 70;
            $y9 = (100 - $parArr[4] / 100);
            $x10 = 80;
            $y10 = 100;
            $x11 = 80;
            $y11 = (100 - $parArr[5] / 100);
            $x12 = 90;
            $y12 = 100;
            $x13 = 90;
            $y13 = (100 - $parArr[6] / 100);
            $x14 = 100;
            $y14 = 100;
            $x15 = 100;
            $y15 = (100 - $parArr[7] / 100);
            $x16 = 110;
            $y16 = 100;
            $x17 = 110;
            $y17 = (100 - $parArr[8] / 100);
            $x18 = 120;
            $y18 = 100;
            $x19 = 120;
            $y19 = (100 - $parArr[9] / 100);
            $x20 = 130;
            $y20 = 100;
            $x21 = 130;
            $y21 = (100 - $parArr[10] / 100);
            $x22 = 140;
            $y22 = 140;
            $x23 = 140;
            $y23 = (100 - $parArr[11] / 100);
            $x24 = 150;
            $y24 = 100;
            $x25 = 150;
            $y25 = (100 - $parArr[12] / 100);
            $x26 = 160;
            $y26 = 100;
            $x27 = 160;
            $y27 = (100 - $parArr[13] / 100);
            $x28 = 170;
            $y28 = 100;
            $x29 = 170;
            $y29 = (100 - $parArr[14] / 100);
            $x30 = 180;
            $y30 = 100;
            $x31 = 180;
            $y31 = (100 - $parArr[15] / 100);
            $x32 = 190;
            $y32 = 100;
            $x33 = 190;
            $y33 = (100 - $parArr[16] / 100);
            $x34 = 200;
            $y34 = 100;
            $x35 = 200;
            $y35 = (100 - $parArr[17] / 100);
            $x36 = 210;
            $y36 = 100;
            $x37 = 210;
            $y37 = (100 - $parArr[18] / 100);
            $x38 = 220;
            $y38 = 100;
            $x39 = 220;
            $y39 = (100 - $parArr[19] / 100);
            $x40 = 230;
            $y40 = 100;
            $x41 = 230;
            $y41 = (100 - $parArr[20] / 100);
            $x42 = 240;
            $y42 = 100;
            $x43 = 240;
            $y43 = (100 - $parArr[21] / 100);
            $x44 = 250;
            $y44 = 100;
            $x45 = 250;
            $y45 = (100 - $parArr[22] / 100);
            $x46 = 260;
            $y46 = 100;
            $x47 = 260;
            $y47 = (100 - $parArr[23] / 100);
            $x48 = 270;
            $y48 = 100;
            
            $im = imagecreatefrompng(Url::to('@app/web/uploads/setka_ormon.png')) or die("Cannot Initialize new GD image stream");
            $background_color = imagecolorallocate($im, 255, 255, 255);

            $text_color = imagecolorallocate($im, 0, 0, 0);
            $line_color1 = imagecolorallocate($im, 255, 0, 0);


            imagefilledrectangle($im, $x1, $y1, $x2, $y2, $line_color1);
            imagefilledrectangle($im, $x3, $y3, $x4, $y4, $line_color1);
            imagefilledrectangle($im, $x5, $y5, $x6, $y6, $line_color1);
            imagefilledrectangle($im, $x7, $y7, $x8, $y8, $line_color1);
            imagefilledrectangle($im, $x9, $y9, $x10, $y10, $line_color1);
            imagefilledrectangle($im, $x11, $y11, $x12, $y12, $line_color1);
            imagefilledrectangle($im, $x13, $y13, $x14, $y14, $line_color1);
            imagefilledrectangle($im, $x15, $y15, $x16, $y16, $line_color1);
            imagefilledrectangle($im, $x17, $y17, $x18, $y18, $line_color1);
            imagefilledrectangle($im, $x19, $y19, $x20, $y20, $line_color1);
            imagefilledrectangle($im, $x21, $y21, $x22, $y22, $line_color1);
            imagefilledrectangle($im, $x23, $y23, $x24, $y24, $line_color1);
            imagefilledrectangle($im, $x25, $y25, $x26, $y26, $line_color1);
            imagefilledrectangle($im, $x27, $y27, $x28, $y28, $line_color1);
            imagefilledrectangle($im, $x29, $y29, $x30, $y30, $line_color1);
            imagefilledrectangle($im, $x31, $y31, $x32, $y32, $line_color1);
            imagefilledrectangle($im, $x33, $y33, $x34, $y34, $line_color1);
            imagefilledrectangle($im, $x35, $y35, $x36, $y36, $line_color1);
            imagefilledrectangle($im, $x37, $y37, $x38, $y38, $line_color1);
            imagefilledrectangle($im, $x39, $y39, $x40, $y40, $line_color1);
            imagefilledrectangle($im, $x41, $y41, $x42, $y42, $line_color1);
            imagefilledrectangle($im, $x43, $y43, $x44, $y44, $line_color1);
            imagefilledrectangle($im, $x45, $y45, $x46, $y46, $line_color1);
            imagefilledrectangle($im, $x47, $y47, $x48, $y48, $line_color1);

            imagerectangle($im, $x1, $y1, $x2, $y2, $line_color);
            imagerectangle($im, $x3, $y3, $x4, $y4, $line_color);
            imagerectangle($im, $x5, $y5, $x6, $y6, $line_color);
            imagerectangle($im, $x7, $y7, $x8, $y8, $line_color);
            imagerectangle($im, $x9, $y9, $x10, $y10, $line_color);
            imagerectangle($im, $x11, $y11, $x12, $y12, $line_color);
            imagerectangle($im, $x13, $y13, $x14, $y14, $line_color);
            imagerectangle($im, $x15, $y15, $x16, $y16, $line_color);
            imagerectangle($im, $x17, $y17, $x18, $y18, $line_color);
            imagerectangle($im, $x19, $y19, $x20, $y20, $line_color);
            imagerectangle($im, $x21, $y21, $x22, $y22, $line_color);
            imagerectangle($im, $x23, $y23, $x24, $y24, $line_color);
            imagerectangle($im, $x25, $y25, $x26, $y26, $line_color);
            imagerectangle($im, $x27, $y27, $x28, $y28, $line_color);
            imagerectangle($im, $x29, $y29, $x30, $y30, $line_color);
            imagerectangle($im, $x31, $y31, $x32, $y32, $line_color);
            imagerectangle($im, $x33, $y33, $x34, $y34, $line_color);
            imagerectangle($im, $x35, $y35, $x36, $y36, $line_color);
            imagerectangle($im, $x37, $y37, $x38, $y38, $line_color);
            imagerectangle($im, $x39, $y39, $x40, $y40, $line_color);
            imagerectangle($im, $x41, $y41, $x42, $y42, $line_color);
            imagerectangle($im, $x43, $y43, $x44, $y44, $line_color);
            imagerectangle($im, $x45, $y45, $x46, $y46, $line_color);
            imagerectangle($im, $x47, $y47, $x48, $y48, $line_color);

            imagestring($im, 1, 10, 10, "     steps for 7 last days - aerosteps for 7 last days", $text_color);

            imagepng($im, Url::to('@app/web/uploads/gistogramma_ormon'.$type.'.png'));


            
    }
    /**
     * Гистограмма по дням недели
     * @param array $par1
     * @param array $par2
     * @param array $par3
     */
    public function pChartBarGrafWeek($par1, $par2=NULL, $par3=NULL){

        require_once '/../pChart/pChart/pData.class'; 
        require_once '/../pChart/pChart/pChart.class'; 
        
        $DataSet = new \pData;
       
        
        $DataSet->AddPoint([$par1["mon"],$par1["tue"],$par1["wed"],$par1["thu"],$par1["fri"],$par1["sat"],$par1["sun"]],"Serie1");  
        if($par2)$DataSet->AddPoint([$par2["mon"],$par2["tue"],$par2["wed"],$par2["thu"],$par2["fri"],$par2["sat"],$par2["sun"]],"Serie2");  
        if($par3)$DataSet->AddPoint([$par3[0],$par3[1],$par3[2],$par3[3],$par3[4],$par3[5],$par3[6]],"Serie3");  
        $DataSet->AddAllSeries();  
        $DataSet->SetAbsciseLabelSerie();  
        $DataSet->SetSerieName("2014","Serie1");  
        if($par2)$DataSet->SetSerieName("2015","Serie2");  
        if($par3)$DataSet->SetSerieName("March","Serie3");  
        
       
         // Initialise the graph  
        $Test = new \pChart(340,160);  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),8);  
        $Test->setGraphArea(35,20,320,140);  
        $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
        $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
        $Test->drawGraphArea(255,255,255,TRUE);  
        $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
        $Test->drawGrid(4,TRUE,230,230,230,50);  
 
        // Draw the 0 line  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),6);  
        $Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
  
        // Draw the bar graph  
        $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
        
        // Finish the graph  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),8);  
        $Test->drawLegend(50,20,$DataSet->GetDataDescription(),255,255,255);  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),10);  
        $Test->drawTitle(0,22,$par1["name"]." по дням недели",50,50,50,310);  
        $Test->Render(Url::to('@app/web/uploads/'.$par1["name"].'weeks.png'));  


    }
    /**
     * Гистограмма по месяцам
     * @param array $par1
     * @param array $par2
     * @param array $par3
     */
    public function pChartBarGrafMonthes($par1, $par2=NULL, $par3=NULL){

        require_once '/../pChart/pChart/pData.class'; 
        require_once '/../pChart/pChart/pChart.class'; 
        
        $DataSet = new \pData;
       
        
        $DataSet->AddPoint([$par1["jan"],$par1["feb"],$par1["mar"],$par1["apr"],$par1["may"],$par1["jun"],$par1["jul"], 
            $par1["aug"],$par1["sep"],$par1["oct"],$par1["nov"],$par1["dec"]],"Serie1");  
        if($par2)$DataSet->AddPoint([$par2["jan"],$par2["feb"],$par2["mar"],$par2["apr"],$par2["may"],$par2["jun"],$par2["jul"], 
            $par2["aug"],$par2["sep"],$par2["oct"],$par2["nov"],$par2["dec"]],"Serie2");  
        if($par3)$DataSet->AddPoint([$par3["jan"],$par3["feb"],$par3["mar"],$par3["apr"],$par3["may"],$par3["jun"],$par3["jul"], 
            $par3["aug"],$par3["sep"],$par3["oct"],$par3["nov"],$par3["dec"]],"Serie3");  
        $DataSet->AddAllSeries();  
        $DataSet->SetAbsciseLabelSerie();  
        $DataSet->SetSerieName("2014","Serie1");  
        if($par2)$DataSet->SetSerieName("2015","Serie2");  
        if($par3)$DataSet->SetSerieName("March","Serie3");  
        
       
         // Initialise the graph  
        $Test = new \pChart(340,160);  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),8);  
        $Test->setGraphArea(35,20,320,140);  
        $Test->drawFilledRoundedRectangle(7,7,693,223,5,240,240,240);  
        $Test->drawRoundedRectangle(5,5,695,225,5,230,230,230);  
        $Test->drawGraphArea(255,255,255,TRUE);  
        $Test->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,150,150,150,TRUE,0,2,TRUE);     
        $Test->drawGrid(4,TRUE,230,230,230,50);  
 
        // Draw the 0 line  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),6);  
        $Test->drawTreshold(0,143,55,72,TRUE,TRUE);  
  
        // Draw the bar graph  
        $Test->drawBarGraph($DataSet->GetData(),$DataSet->GetDataDescription(),TRUE);  
        
        // Finish the graph  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),8);  
        $Test->drawLegend(50,20,$DataSet->GetDataDescription(),255,255,255);  
        $Test->setFontProperties(Url::to('@app/pChart/Fonts/tahoma.ttf'),10);  
        $Test->drawTitle(0,22,$par1["name"]." по месяцам",50,50,50,310);  
        $Test->Render(Url::to('@app/web/uploads/'.$par1["name"].'monthes.png'));  


    }

    
    public function bestShops($datas){
       
        
        foreach ($datas as $key => $data) {
            $rybdaySum += $data->rybday;
            $ramSum += $data->ramos;
            $marSum += $data->mariara;
            $ashanSum += $data->ashan;
            $ikeaSum += $data->ikea;
            $holSum += $data->holiday;
            $gottiSum += $data->gotti;
            $leroySum += $data->leroy;
            $chistmirSum += $data->chistmir;
            $miasoSum += $data->miaso;
            $familySum += $data->family;
            $gloriadjinsSum += $data->gloria_djins;
            $detmirSum += $data->det_mir;
            $sibgigSum += $data->sib_gig;
            $ostinSum += $data->ostin;
            $m_videoSum += $data->m_video;
			$romikaSum += $data->romika;
			$avaloneSum += $data->avalone;
			$lumenSum += $data->lumen;
			$mothercareSum += $data->mothercare;
			$dochki_synochkiSum += $data->dochki_synochki;
			$bystronomSum += $data->bystronom;
			$e96Sum += $data->e96;
			$dudnikSum += $data->dudnik;
			$letualSum += $data->letual;
			$mus_arsSum += $data->mus_ars;
			$master_bestSum += $data->master_best;
			$music_landSum += $data->music_land;
			$mangoSum += $data->mango;
			$sinarSum += $data->sinar;
			$limpopoSum += $data->limpopo;
			$sportmasterSum += $data->sportmaster;
			$salamanderSum += $data->salamander;
			$zollaSum += $data->zolla;
			$florangeSum += $data->florange;
			$marks_spenserSum += $data->marks_spenser;
			$malonfashnSum += $data->malonfashn;
			$nattiSum += $data->natti;
			$dnsSum += $data->dns;
			$piaterochkaSum += $data->piaterochka;
			$radiotehnikaSum += $data->radiotehnika;
			
        }
        
        $array_mag = [ 
            'Рамос' => $ramSum, 
            'Мария Ра' => $marSum, 
            'Holiday/Holdy' => $holSum, 
            'Рыбный день' => $rybdaySum, 
            'Ashan' => $ashanSum, 
            'Leroy Merlen' => $leroySum, 
            'Готти' => $gottiSum, 
            'Чистый мир' => $chistmirSum, 
            'Мясо' => $miasoSum, 
            'Ikea' => $ikeaSum,
            'Фэмили' => $familySum,
            'Gloria Jins' => $gloriadjinsSum,
            'Детский мир' => $detmirSum,
            'Сиб Гигант' => $sibgigSum,
            'O\'stin' => $ostinSum,
            'М-Видео' => $m_videoSum,
			'Ромика' => $romikaSum,
			'Avalone' => $avaloneSum,
			'Lumen' => $lumenSum,
			'Mothercare' => $mothercareSum,
			'Дочки-Сыночки' => $dochki_synochkiSum,
			'Быстроном' => $bystronomSum,
			'E96.ru' => $e96Sum,
			'Дудник' => $dudnikSum,
			'Л\'Этуаль' => $letualSum,
			'Муз Арсенал' => $mus_arsSum,
			'Мастер бестер' => $master_bestSum,
			'Music Land' => $music_landSum,
			'mango' => $mangoSum,
			'Sinar' => $sinarSum,
			'Лимпопо' => $limpopoSum,
			'Спортмастер' => $sportmasterSum,
			'Salamander' => $salamanderSum,
			'Zolla' => $zollaSum,
			'Florange' => $florangeSum,
			'Marks&Spenser' => $marks_spenserSum,
			'Malonfashn' => $malonfashnSum,
			'Natti' => $nattiSum,
			'DNS' => $dnsSum,
			'Пятерочка' => $piaterochkaSum,
			'Радиотехника' => $radiotehnikaSum
            ];
        
       
        arsort($array_mag);        

        return $array_mag;
    }
    
    /**
     * Суммарные траты для данных 
     * @param object $datas
     * @return array
     */
    public function spends($datas){
         
        foreach ($datas as $key => $data) {
            $alkSum += $data->alk;
            $batSum += $data->bat;
            $bilSum += $data->bil;
            $bolSum += $data->bol;
            $dorSum += $data->dor;
            $doshirabSum += $data->doshirab;
            $zhvachSum += $data->zhvach;
         
            $cancSum += $data->canc;
            $kvarSum += $data->kvar;
            $kolbasSum += $data->kolbas;
            $koncerSum += $data->koncer;
            $kofeSum += $data->kofe;
            $krupSum += $data->krup;
            
            $makarSum += $data->makar;
            $maslorastSum += $data->maslorast;
            $mebelSum += $data->mebel;
            $melochSum += $data->meloch;
            $mishaSum += $data->misha;
            $molocoSum += $data->moloco;
            $musSum += $data->mus;
            $mjasSum += $data->mjas;
            $obuvSum += $data->obuv;
            $ovosSum += $data->ovos;
            $odezhdSum += $data->odezhd;
            $paricSum += $data->paric;
            $pelmenSum += $data->pelmen;
            $pticSum += $data->ptic;
            
            $pureshSum += $data->puresh;
            $remSum += $data->rem;
            $rybSum += $data->ryb;
            $sladSum += $data->slad;
            $sokSum += $data->sok;
            $sotSum += $data->sot_r;
            $sotSum += $data->sot_s;
            $suhfrSum += $data->suhfr;
            $techSum += $data->tech;
            $uchSum += $data->uch;
            $fructSum += $data->fruct;
            $hlebSum += $data->hleb;
            $hozSum += $data->hoz;
            $hostingSum += $data->hosting + $data->internet;
            $muchSum += $data->much;
        }
        
        $array_spends = [ 
            'Алкоголь' => $alkSum, 
            'Батарейки' => $batSum, 
            'Билеты' => $bilSum, 
            'Больницы' => $bolSum, 
            'Дорога' => $dorSum, 
            'Работа/столов' => $doshirabSum, 
            'Жвачка' => $zhvachSum, 
            'Гигиена/Канц' => $cancSum, 
            'Квартира' => $kvarSum,
            'Колбаса' => $kolbasSum,
            'Консервы' => $koncerSum,
            'Кофе/чай' => $kofeSum,
            'Крупы' => $krupSum,
            
            'Макароны' => $makarSum, 
            'Растит масло' => $maslorastSum, 
            'Мебель' => $mebelSum, 
            'Подарк/посуд' => $melochSum, 
            'Миша' => $mishaSum, 
            'Молоко' => $molocoSum, 
            'Музыка' => $musSum, 
            'Мясо' => $mjasSum, 
            'Обувь' => $obuvSum, 
            'Овощи' => $ovosSum,
            'Одежда' => $odezhdSum,
            'Парикмахер' => $paricSum,
            'Пельмени' => $pelmenSum,
            'Птица' => $pticSum,
            
            'Детсад' => $pureshSum, 
            'Ремонт' => $remSum, 
            'Рыба' => $rybSum, 
            'Сладкое' => $sladSum, 
            'Соки/воды' => $sokSum, 
            'Сотовые' => $sotSum, 
            'Сухофрукты' => $suhfrSum, 
            'Техника' => $techSum, 
            'Учёба/спорт' => $uchSum, 
            'Фрукты' => $fructSum,
            'Хлеб' => $hlebSum,
            'Хозтовары' => $hozSum,
            'IT-услуги' => $hostingSum,
            'Мучное' => $muchSum,
            ];
        
       
        arsort($array_spends);        

        return $array_spends;
    }

    /**
     * Среднее по $par в модели $model году $year
     * @param object $model
     * @param string $par
     * @param integer $year
     * @return array
     */
    public function avgWeekDays($model, $par, $year){
         
        $avg_mon  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Mon"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_tue  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Tue"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_wed  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Wed"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_thu  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Thu"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_fri  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Fri"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_sat  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Sat"])
            ->andWhere("$par > 0")
            ->scalar();
        $avg_sun  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['dd' => "Sun"])
            ->andWhere("$par > 0")
            ->scalar();
        return $aravgWeeks = [
            "mon" =>$avg_mon,"tue" => $avg_tue, "wed" => $avg_wed, "thu" => $avg_thu,
            "fri" => $avg_fri, "sat" => $avg_sat, "sun" => $avg_sun, "name" => $par 
        ];
    }
    /**
     * Среднее по месяцам
     * @param object $model
     * @param array $par
     * @param integer $year
     * @return array
     */
    public function avgMonthes($model, $par, $year){
         
        $avg_jan  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "01"])
            ->scalar();
        $avg_feb  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "02"])
            ->scalar();
        $avg_mar  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "03"])
            ->scalar();
        $avg_apr  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "04"])
            ->scalar();
        $avg_may  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "05"])
            ->scalar();
        $avg_jun  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "06"])
            ->scalar();
        $avg_jul  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "07"])
            ->scalar();
        $avg_aug  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "08"])
            ->scalar();
        $avg_sep  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "09"])
            ->scalar();
        $avg_oct  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "10"])
            ->scalar();
        $avg_nov  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "11"])
            ->scalar();
        $avg_dec  = $model::find()
            ->select("AVG($par)")
            ->where(['year' => $year])
            ->andWhere(['month' => "12"])
            ->scalar();
        return $aravgMonthes = [
            "jan" =>$avg_jan,"feb" => $avg_feb, "mar" => $avg_mar, "apr" => $avg_apr, "may" => $avg_may, "jun" => $avg_jun,
            "jul" => $avg_jul, "aug" => $avg_aug, "sep" => $avg_sep,  "oct" => $avg_oct, "nov" => $avg_nov, "dec" => $avg_dec, "name" => $par 
        ];
    }
    
   
}

