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
        if ($cookies->get("auth")) {
            $cookie = $cookies->get('auth');
            $username = $cookie->value;
            $user  = User::findOne(['username' => htmlentities($username)]);
            switch ($user['theme']) {
                case 'default':
                    \frontend\assets\DefaultAsset::register($this->page); return 0;
                case 'twitter23modern':
                    \frontend\assets\Twitter23ModernAsset::register($this->page); return 0;
                case 'none':
                    \frontend\assets\NoneAsset::register($this->page); return 0;
                case 'blue':
                    \frontend\assets\BlueAsset::register($this->page); return 0;
                case 'yellow':
                    \frontend\assets\YellowAsset::register($this->page); return 0;
                case 'pink':
                    \frontend\assets\PinkAsset::register($this->page); return 0;
                case 'orange':
                    \frontend\assets\OrangeAsset::register($this->page); return 0;
                case 'green':
                    \frontend\assets\GreenAsset::register($this->page); return 0;
                case 'red':
                    \frontend\assets\RedAsset::register($this->page); return 0;
                case 'brown':
                    \frontend\assets\BrownAsset::register($this->page); return 0;
            }
        }
        \frontend\assets\DefaultAsset::register($this->page);
        return 0;
    }
}