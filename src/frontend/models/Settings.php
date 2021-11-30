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
    public $gender, $about, $city, $site, $bgimage;
    public $name, $telegram, $img, $username;

    public function rules()
    {
        return [ 
            [['gender', 'name'], 'required', 'message' => ''],
            [['telegram', 'city', 'site', 'about', 'username'], 'string'],
            [['img', 'bgimage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, webp'],
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
                $img = 'uploads/' . time() . $rand . '.' . $this->img->extension;
                $this->img->saveAs($img);
                $this->img = null;
                return $img;
            }
            return true;
        } else {
            return false;
        }
    }

    public function uploadBg()
    {
        if ($this->validate()) {
            if (isset($this->bgimage->baseName)) { 
                $rand = "";
                for ($i = 0; $i < 10; $i++) {
                    $rand .= rand(0, 100);
                }
                $img = 'bg/' . time() . $rand . '.' . $this->bgimage->extension;
                $this->bgimage->saveAs($img);
                $this->bgimage = null;
                return $img;
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
            'bgimage' => '',
        ];
    }
}