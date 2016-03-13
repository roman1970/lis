<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;
use app\models\Comments;
use yii\helpers\Url;

class CommentsWidget extends Widget
{
    public $article_id;
    private $comments;
    public $module_path;

    public function init()
    {
        parent::init();
        if ($this->article_id != null) {
            $this->comments = Comments::find()
                ->where('article_content_id ='.$this->article_id)
                ->orderBy([
                'id' => SORT_DESC,
                ])->all();
        }
    }

    public function run()
    {
        //return var_dump($this->comments);
        return $this->render('comments', ['comments' => $this->comments]);
    }

    public function getViewPath()
    {
        return Url::to('@app'. $this->module_path. DIRECTORY_SEPARATOR . 'views');
    }


}