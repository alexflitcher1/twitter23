<?php
namespace frontend\models;

use yii\base\Model;

/**
 * Seach model
 * 
 * Works with user search query
 */
class SearchForm extends Model
{
    public $text, $mode = 0;

    public function rules()
    {
        return [
            [['text'], 'required', 'message' => ''],
        ];
    }

    public function attributeLabels() 
    {
        return [
            'text' => '',
        ];
    }
}
