<?php

namespace app\modules\repertuar\controllers;

use app\components\BackEndController;
use app\models\Repertuare;

class DefaultController extends BackEndController
{

    public function actionIndex()
    {
        $vys_songs = Repertuare::find()->where('cat = 2')->all();
        return $this->render('index', ['songs' => $vys_songs, 'group' => 'Владимир Высоцкий']);
    }

    public function actionReviakin()
    {
        $rev_songs = Repertuare::find()->where('cat = 3')->all();
        return $this->render('index', ['songs' => $rev_songs, 'group' => 'Дмитрий Ревякин']);
    }
}
