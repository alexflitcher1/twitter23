<?php
namespace frontend\components;

use Yii;
use yii\helpers\Url;
use frontend\models\User;
use yii\base\ActionFilter;
use frontend\models\SiteSettings;

class ActionTechFilter extends ActionFilter
{
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
        $user = User::findOne(['username' => $username]);
        $siteset = SiteSettings::findOne(['name' => 'tech']);
        if ($user->status != 'admin')
            if (!$siteset->status)
                if (Url::to() != "/tech")
                    Yii::$app->response->redirect(Url::to('/tech'));
        return parent::afterAction($action, $result);
    }
}