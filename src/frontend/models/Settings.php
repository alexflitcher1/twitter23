<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Settings model
 * 
 * Works with user settings data
 */
class Settings extends Model 
{
    public $gender, $about, $city, $site;
    public $name, $telegram, $img, $username;

    public function rules()
    {
        return [ 
            [['gender', 'name'], 'required', 'message' => ''],
            [['telegram', 'city', 'site', 'about', 'username'], 'string'],
            [['img'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
            'gender' => '',
            'about' => '',
            'city' => '',
            'site' => '',
            'name' => '',
            'telegram' => '',
            'img' => '',
            'username' => '',
        ];
    }
}