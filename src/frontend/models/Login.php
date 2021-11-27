<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login model
 * 
 * Works with user data
 */
class Login extends Model 
{

    public $username;
    public $password;

    public function rules() 
    {
        return [
            [['username', 'password'], 'required', 'message' => 'Заполните поле'],
            ['username', 'exist', 'targetClass' => User::className(),
            'message' => 'Пользователя не существует'],
        ];
    }

    public function attributeLabels() 
    {
        return [
            'username' => '',
            'password' => '',
        ];
    }

}