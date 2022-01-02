<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use frontend\models\User;
use frontend\models\Login;
use frontend\models\Posts;
use frontend\models\Likes;
use frontend\models\Signup;
use frontend\models\Friends;
use frontend\models\Popular;
use frontend\models\PostForm;
use frontend\models\SearchForm;

class SiteController extends Controller 
{
    public function actionGetThemes() 
    {
        return json_encode(Yii::$app->params['themes']);
    }
}