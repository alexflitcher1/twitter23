<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Settings model
 * 
 * Works with user settings data
 */
class ChangePas extends Model 
{
    public $oldpas, $newpas, $retnpas;

    public function rules()
    {
        return [ 
            [['oldpas', 'newpas', 'retnpas'], 'required', 'message' => ''],
            ['retnpas', 'compare', 'compareAttribute' => 'newpas', 'message' => 'Пароли не совпадают'],
        ];
    }

    public function attributeLabels() 
    {
        return [
            'oldpas' => '',
            'newpas' => '',
            'retnpas' => '',
        ];
    }
}