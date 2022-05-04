<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Settings model
 * 
 * Works with user settings data
 */
class MainSettings extends Model 
{
    public $lang, $theme, $color, $pcss;

    public function rules()
    {
        return [ 
            [['lang', 'theme', 'color'], 'required', 'message' => ''],
            [['pcss'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if (isset($this->pcss->baseName)) { 
                $rand = "";
                for ($i = 0; $i < 10; $i++) {
                    $rand .= rand(0, 100);
                }
                $name = 'pcss/' . time() . $rand . '.' . 'css';
                $this->pcss->saveAs($name);
                $this->pcss = null;
                return $name;
            }
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels() 
    {
        return [
            'lang' => '',
            'theme' => '',
            'color' => '',
            'pcss' => '',
        ];
    }
}