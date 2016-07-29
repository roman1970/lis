<?php
namespace app\components;

use app\models\RadioComment;
use yii\base\Widget;
use yii\helpers\Html;
use app\models\Comments;
use yii\helpers\Url;

class RadioCommentsWidget extends Widget
{
    
    private $comments;
    public $module_path;

    public function init()
    {
        parent::init();
        
            $this->comments = RadioComment::find()
                ->limit(10)
                ->orderBy([
                    'id' => SORT_DESC,
                ])->all();
       
    }

    public function run()
    {
        //return var_dump($this->comments);
        return $this->render('comments', ['comments' => $this->comments]);
    }

    public function getViewPath()
    {
        return Url::to('@app' . $this->module_path . DIRECTORY_SEPARATOR . 'views');
    }

}
