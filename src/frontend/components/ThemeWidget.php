<?php
namespace frontend\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use frontend\models\User;

class ThemeWidget extends Widget
{
    public $page;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        switch ($user['theme']) {
            case 'default':
                \frontend\assets\DefaultAsset::register($this->page); break;
        }
    }
}