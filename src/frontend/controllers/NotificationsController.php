<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Notifications controller
 * 
 * @author <Alex Flitcher>
 * @todo Create notifications system
 */
class NotificationsController extends Controller
{
    /**
     * Index function
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        return $this->render('index');
    }
}
