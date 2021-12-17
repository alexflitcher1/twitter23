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
    public $lang, $theme;

    public function rules()
    {
        return [ 
            [['lang', 'theme'], 'required', 'message' => ''],
        ];
    }

    public function attributeLabels() 
    {
        return [
            'lang' => '',
            'theme' => '',
        ];
    }
}