<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 * @TODO Не грузятся wav-файлы
 * @TODO Дать возможность загружать не загружать файлы
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $img;

    const MAX_SIZE_FILE = 2048000000;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
         [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => ['mp3', 'wav'], 'maxSize' => self::MAX_SIZE_FILE],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'png'], 'maxSize' => self::MAX_SIZE_FILE],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('@web/uploads/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}