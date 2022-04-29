<?php
namespace backend\controllers;

use backend\models\User;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'backend\models\User';
}