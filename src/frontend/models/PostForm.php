<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Post model
 * 
 * Works with user posts
 */
class PostForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $img, $text;

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => '', 'when' => function($model) {
                return false;
            }, 'whenClient' => "function (attribute, value) {
                if ($('#postform-img').val() != '')
                    return false;
                return true;
            }"],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            if (isset($this->img->baseName)) { 
                $rand = "";
                for ($i = 0; $i < 10; $i++) {
                    $rand .= rand(0, 100);
                }
                $this->img->saveAs('uploads/' . time() . $rand . '.' . $this->img->extension);
                return 'uploads/' . time() . $rand . '.' . $this->img->extension;
            }
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels() 
    {
        return [
            'text' => '',
            'img' => '',
        ];
    }
}
