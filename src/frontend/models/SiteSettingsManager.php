<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Settings model
 * 
 * Works with user settings data
 */
class SiteSettingsManager extends Model 
{
    public $tech, $reg;

    public function rules()
    {
        return [ 
            [['tech', 'reg'], 'required', 'message' => ''],
        ];
    }

    public function attributeLabels() 
    {
        return [
            'tech' => '',
            'reg' => '',
        ];
    }
}