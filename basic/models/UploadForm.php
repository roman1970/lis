<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    const MAX_SIZE_FILE = 204800000;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
         [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => ['mp3'], 'maxSize' => self::MAX_SIZE_FILE],
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