<?php
namespace frontend\components;

use Yii;
use yii\helpers\Url;
use frontend\models\User;
use yii\base\ActionFilter;

class ActionBanFilter extends ActionFilter
{
    private $_startTime;

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return parent::afterAction($action, $result);
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        if ($user->status == 'ban')
            if (Url::to() != "/ban")
                Yii::$app->response->redirect(Url::to('/ban'));
        return parent::afterAction($action, $result);
    }
}