<?php
namespace app\controllers;

use app\components\BackEndController;
use app\components\TranslateHelper;
use app\models\Articles;
use app\models\ArticlesContent;
use app\models\DiaryActs;
use app\models\ImageStorage;
use app\models\Source;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\helpers\Url;
use Yii;
use yii\data\ActiveDataProvider;
use yii\sphinx\Query; // обязательно используем sphinx вместо стандартной yii\db\Query

class ArticlesController extends BackEndController
{
    public $layout = 'admin';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/uploads/imperaviim/',// Directory URL address, where files are stored.
                'path' => '@webroot/uploads/imperaviim/' // Or absolute path to directory where files are stored.
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '/images/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/images/blog/', // Or absolute path to directory where files are stored.
                'type' => '0',
            ],
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => '/files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/', // Or absolute path to directory where files are stored.
                'type' => '1',//GetAction::TYPE_FILES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/' // Or absolute path to directory where files are stored.
            ],
        ];
    }

    public function actionIndex()
    {
        $articles = Articles::find()->orderBy('id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $articles,
        ]);

        return $this->render('index', ['articles' => $dataProvider]);
    }

    /**
     * Создание контента
     * @return string
     */
    public function actionCreate()
    {

        $model = new Articles();

        $uploadFile = new UploadForm();
        $uploadImg = new UploadForm();


        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if ($uploadFile->file && $uploadFile->validate()) {
                $uploadFile->file->saveAs('uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension);

            }
            elseif($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadFile->getErrors()); }
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Articles')['text'];
            $model->title = Yii::$app->request->post('Articles')['title'];
            $model->alias = TranslateHelper::translit(Yii::$app->request->post('Articles')['title']);
            $model->site_id = Yii::$app->request->post('Articles')['site_id'];
            $model->cat_id = Yii::$app->request->post('Articles')['cat_id'];
            $model->tags = Yii::$app->request->post('Articles')['tags'];
            if(Yii::$app->request->post('Articles')['redactor']) $model->redactor = 1;
            else $model->redactor = 0;
            if(isset(Yii::$app->request->post('Articles')['source_id']))$model->source_id = Yii::$app->request->post('Articles')['source_id'];
             else $model->source_id = 2;
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            if($model->site_id == 13) {
                $act = new DiaryActs();
                $act->model_id = 6;
                $act->user_id = 8;
                $act->save(false);
                $model->act_id = $act->id;
            }

            $model->save(false);

                
            return $this->redirect(Url::toRoute('articles/index'));

        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadFile' => $uploadFile,
                'uploadImg' => $uploadImg,

            ]);
        }

    }

    public function actionUpdate($id){

        $model = $this->loadModel($id);
        $uploadFile = new UploadForm();
        $uploadImg = new UploadForm();

        if (Yii::$app->request->isPost) {
            $uploadFile->file = UploadedFile::getInstance($uploadFile, 'file');
            $uploadImg->img = UploadedFile::getInstance($uploadImg, 'img');

            if ($uploadFile->file && $uploadFile->validate()) {
                $uploadFile->file->saveAs('uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension);

            }
            elseif($uploadImg->img && $uploadImg->validate()) {
                $uploadImg->img->saveAs('uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension);

            }
            else { print_r($uploadFile->getErrors()); }
        }

        //var_dump($uploadImg); exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->text = Yii::$app->request->post('Articles')['text'];
            $model->title = Yii::$app->request->post('Articles')['title'];
            $model->alias = TranslateHelper::translit(Yii::$app->request->post('Articles')['title']);
            $model->site_id = Yii::$app->request->post('Articles')['site_id'];
            $model->cat_id = Yii::$app->request->post('Articles')['cat_id'];
            if(Yii::$app->request->post('Articles')['redactor']) $model->redactor = 1;
            else $model->redactor = 0;
            if(isset(Yii::$app->request->post('Articles')['source_id']))$model->source_id = Yii::$app->request->post('Articles')['source_id'];
                else $model->source_id = 2;
            if(isset($uploadFile->file))
                $model->audio = Url::base().'uploads/' . Yii::$app->translater->translit($uploadFile->file->baseName) . '.' .$uploadFile->file->extension;

            if(isset($uploadImg->img))
                $model->img = Url::base().'uploads/' . Yii::$app->translater->translit($uploadImg->img->baseName) . '.' .$uploadImg->img->extension;
            $model->save(false);

            return $this->redirect(Url::toRoute('articles/index'));
        } else {

            return $this->render('_form', [
                'model' => $model,
                'uploadFile' => $uploadFile,
                'uploadImg' => $uploadImg,
            ]);
        }

    }

    /**
     * Удаляет контент
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\HttpException
     */
    public function actionDelete($id)
    {

        if ($model = $this->loadModel($id)->delete()) {
            $articles = Articles::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $articles,
            ]);

            return $this->render('index', ['articles' => $dataProvider]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };

    }


    /**
     * Добавляем страницу контента
     *
     */
    //@TODO добавление страницы из списка страниц контента
    //@TODO при добавлении страницы выводить название контента
    public function actionAddpage($id){

        $artContent = new ArticlesContent;

        $redactor = $this->loadModel($id)->redactor;

        $upload = new UploadForm();

        if (Yii::$app->request->isPost) {
            $upload->file = UploadedFile::getInstance($upload, 'file');

            if ($upload->file && $upload->validate()) {
                $upload->file->saveAs('uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension);

            }
            else { print_r($upload->getErrors()); }
        }

        if ($artContent->load(Yii::$app->request->post())) {
            $artContent->body = Yii::$app->request->post('ArticlesContent')['body'];
            $artContent->minititle = Yii::$app->request->post('ArticlesContent')['minititle'];

            //var_dump(Yii::$app->request->post('ArticlesContent')['source_title']); exit;

             if(Source::find()->where(['title' => Yii::$app->request->post('ArticlesContent')['source_title']])->one()){

                 $artContent->source_id = Source::find()->where(['title' => Yii::$app->request->post('ArticlesContent')['source_title']])->one()->id;
             }
            else return 'mistake';

            $artContent->articles_id = $id;
            if(isset($upload->file))$artContent->audio = Url::base().'uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension;
            else $artContent->audio = '';

            if($this->loadModel($id)->site_id == 13) {
                $act = new DiaryActs();
                $act->model_id = 6;
                $act->mark = 1;
                $act->user_id = 8;
                $act->save(false);
            }

            $artContent->save();


            $content = ArticlesContent::find()
                ->where(['articles_id' => $id]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,
                'model' => $artContent,

            ]);

        } else {

            return $this->render('page_form', [
                'model' => $artContent,
                'upload' => $upload,
                'redactor' => $redactor

            ]);
        }

    }

    /**
     * Обновляет страницу
     * @param $id
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionUpdatepage($id) {

        $artContent = $this->loadModelcontent($id);
        $artId = $artContent->articles_id;
        $redactor = $this->loadModel($artId)->redactor;
        $upload = new UploadForm();
        //var_dump($upload); exit;
        if (Yii::$app->request->isPost) {
            $upload->file = UploadedFile::getInstance($upload, 'file');

            if ($upload->file && $upload->validate()) {
                $upload->file->saveAs('uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension);

            }
            else { print_r($upload->getErrors()); }
        }


        if ($artContent->load(Yii::$app->request->post())) {
            $artContent->body = Yii::$app->request->post('ArticlesContent')['body'];
            $artContent->minititle = Yii::$app->request->post('ArticlesContent')['minititle'];
            //$artContent->source_id = Yii::$app->request->post('ArticlesContent')['source_id'];

            if(Source::find()->where(['title' => Yii::$app->request->post('ArticlesContent')['source_title']])->one()){

                $artContent->source_id = Source::find()->where(['title' => Yii::$app->request->post('ArticlesContent')['source_title']])->one()->id;
            }
            else return 'mistake';


            $artContent->articles_id = $artId;
            if(isset($upload->file))
            $artContent->audio = Url::base().'uploads/' . Yii::$app->translater->translit($upload->file->baseName) . '.' .$upload->file->extension;

            $artContent->save();

            $content = ArticlesContent::find()
                ->where(['articles_id' => $artId]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,
                'model' => $artContent,

            ]);

        } else {

            return $this->render('page_form', [
                'model' => $artContent,
                'upload' => $upload,
                'redactor' => $redactor
            ]);
        }
    }

    /**
     * Удаление страницы контента
     * @param $id
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionDeletepage($id)
    {
        $model = $this->loadModelcontent($id);
        $artId = $model->articles_id;

        if ($this->loadModelcontent($id)->delete()) {


            $content = ArticlesContent::find()
                ->where(['articles_id' => $artId]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,

            ]);
        } else {
            throw new \yii\web\HttpException(404, 'Cant delete record.');
        };


    }


    /**
     * Показывает страницы контента
     * @param $id
     * @return string
     */
    public function actionPages($id) {
        $content = ArticlesContent::find()
            ->where(['articles_id' => $id]);

        $dataCont = new ActiveDataProvider([
            'query' => $content,
            'pagination' => [
                'pageSize' => 10,
            ],

        ]);

        return $this->render('pages', [
            'content' => $dataCont,

        ]);

    }

    /**
     * Загружает запись модели текущего контроллера по айдишнику
     * @param $id
     * @return null|static
     * @throws \yii\web\HttpException
     */
    public function loadModel($id)
    {

        $model = Articles::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Возвращает модель страницы контента
     * @param $id
     * @return null|static
     * @throws \yii\web\HttpException
     */
    public function loadModelcontent($id)
    {

        $model = ArticlesContent::findOne($id);

        if ($model === null)
            throw new \yii\web\HttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Загрузка картинок статьи 
     * @param $id
     * @return \yii\web\Response
     */
    public function actionLoadArticlePictures($id){
        $model = ArticlesContent::findOne($id);

        $dom = new \DOMDocument('1.0', 'UTF-8');

        // set error level
        $internalErrors = libxml_use_internal_errors(true);

        // load HTML
        $dom->loadHTML($model->body);

        // Restore error level
        libxml_use_internal_errors($internalErrors);

        $img = $dom->getElementsByTagName("img");
        foreach ($img as $node) {

                foreach ($node->attributes as $attr) {
                    if($attr->localName === 'src') {
                        $extension = '.png';
                        if(strstr($attr->localName, 'jpg')) $extension = '.jpg';
                        $imageFile = md5($attr->nodeValue).$extension;
                       // var_dump($attr->nodeValue); exit;
                        //if()
                        copy($attr->nodeValue, '/home/romanych/public_html/plis/basic/web/uploads/article_img/'.$imageFile);

                        $image = new ImageStorage();
                        $image->img = '/home/romanych/public_html/plis/basic/web/uploads/article_img/'.$imageFile;
                        $image->orig_tag = $attr->nodeValue;
                        $image->cont_art_id = $id;
                        $image->save();

                      
                    }
                }
        }

        return $this->redirect(Url::toRoute('articles/index'));
        
    }
    
    public function actionKlavir(){


        $query  = new Query();
       // $search_result = $query_search->from('siteSearch')->match($q)->all();  // поиск осуществляется по средством метода match с переданной поисковой фразой.
        $query->from('src1')
             ->match('test')
             ->snippetCallback(function ($rows) {
                     $result = [];
                     foreach ($rows as $row) {
                            $result[] = file_get_contents('/var/lib/sphinxsearch/data/test1' . $row['id'] . '.txt');
                         }
                     return $result;
                 })
             ->all();
        var_dump($query); exit;

        $article_id = Articles::find()
            ->select('MAX(id)')
            ->scalar();
        
        if($article_id) $article = Articles::findOne($article_id);
        else return $this->redirect(Url::toRoute('articles/index'));

        $artContent = new ArticlesContent;

        if ($artContent->load(Yii::$app->request->post())) {
            $artContent->body = Yii::$app->request->post('ArticlesContent')['body'];
            $artContent->minititle = Yii::$app->request->post('ArticlesContent')['minititle'];
            $artContent->source_id = 434;

            $artContent->articles_id = $article_id;


            if($this->loadModel($article_id)->site_id == 13) {
                $act = new DiaryActs();
                $act->model_id = 6;
                $act->mark = 1;
                $act->user_id = 8;
                $act->save(false);
            }

            $artContent->save();


            $content = ArticlesContent::find()
                ->where(['articles_id' => $article_id]);

            $dataCont = new ActiveDataProvider([
                'query' => $content,

            ]);

            return $this->render('pages', [
                'content' => $dataCont,
                'model' => $artContent,

            ]);

        } else {

            return $this->render('klavir', ['model' => $artContent]);
        }


    }
        
   

    /*
    function get_picture($url, $target){

        copy($url,$target);
        return;



        $ch = curl_init($url);

        //curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.95 Safari/537.11');

        $content = curl_exec($ch);
        curl_close($ch);

        if (file_exists($target)) :
            unlink($target);
        endif;

        $fp = fopen($target , 'x');
        fwrite($fp, $content);
        fclose($fp);

       
    }
    */





}

