<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Signup model
 * 
 * Works with frontend\controllers\UserController
 */
class Signup extends Model 
{
    public $username;
    public $password, $repass, $gender;
    public $name, $language, $email;

    public function rules() 
    {
        return [
            [['username', 'password', 'repass', 'email',
             'name', 'gender', 'language'], 
             'required', 'message' => ''],
            ['repass', 'compare', 'compareAttribute' => 'password',
             'message' => 'Пароли не совпадают'],
            ['username', 'unique', 'targetClass' => User::className(),
             'message' => 'Логин уже занят'],
            ['email', 'unique', 'targetClass' => User::className(), 
             'message' => 'Почта уже занята']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '',
            'password' => '',
            'repass' => '',
            'email' => '',
            'name' => '',
            'gender' => '',
            'language' => '',
        ];
    }
}