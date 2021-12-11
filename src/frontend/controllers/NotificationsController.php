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
use frontend\models\Popular;
use frontend\models\Friends;
use frontend\models\Settings;
use frontend\models\PostForm;
use frontend\models\Notifications;

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
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $suber = count(Friends::find()
                        ->where(['userid' => htmlentities($user->id)])
                        ->all());
        $subs  = count(Friends::find()
                        ->where(['friendid' => htmlentities($user->id)])
                        ->all());
        $posts = count(Posts::find()
                        ->where(['userid' => htmlentities($user->id)])
                        ->orderBy(['id' => SORT_DESC])
                        ->all());
        $popular = Popular::find()
                        ->orderBy(['count' => SORT_DESC])
                        ->limit(10)
                        ->offset(0)
                        ->all();
        $notifications = Notifications::find()
                        ->where("userid=:userid AND checked = 0", ['userid' => $user->id])
                        ->orderBy(['dateadd' => SORT_ASC])
                        ->all();
        $initer = [];
        for ($i = 0; $i < count($notifications); $i++) {
            if ($notifications[$i]['type'] == 'like' || $notifications[$i]['type'] == 'reply') {
                $notifications[$i]['moredata'] = Posts::findOne(['id' => $notifications[$i]['moredata']]);
                $initer[$i] = User::findOne(['id' => $notifications[$i]['initid']]);
            }
        }
        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) 
        && $model->validate()) {
                $model->img = UploadedFile::getInstance($model, 'img');
                $imgname = $model->upload();
                if ($imgname) {
                    // count entered words
                    $allwords = explode(" ", htmlentities($model->text));
                    for ($i = 0; $i < count($allwords); $i++) {
                        $words[$allwords[$i]] = isset($words[$allwords[$i]]) ? 
                                                      $words[$allwords[$i]] + 1 : 1;
                    }
                    for ($i = 0; $i < count($allwords); $i++) {
                        $word = Popular::findOne(['text' => $allwords[$i]]);
                        if ($word) {
                            $word->count = $word->count + $words[$allwords[$i]];
                            $word->save();
                        } else {
                            $word = new Popular();
                            $word->text = $allwords[$i];
                            $word->count = $words[$allwords[$i]];
                            $word->save();
                        }
                    }
                    $npost = new Posts();
                    $npost->userid = htmlentities($user->id);
                    $npost->date = date('Y-m-d H:i:s', time());
                    $npost->text = htmlentities($model->text);
                    $npost->text = str_replace("\n", "<br>", $model->text);
                    $imgname = ($imgname === true) ? null : "/" . $imgname;
                    $npost->img = $imgname;
                    $npost->likes = 0;
                    if ($npost->save())
                        return $this->redirect("/feed?p=" . $p);
                }
        }
        return $this->render('index', ['popular' => $popular, 'subs' => $subs, 
        'notifications' => $notifications, 'user' => $user, 'initer' => $initer,
        'postscount' => $posts, 'popular' => $popular, 'suber' => $suber, 'model' => $model]);
    }

    public function actionAddLike($postid)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $userid = Posts::findOne(['id' => $postid])->userid;
        $notif = Notifications::find()
        ->where('userid = :userid AND initid = :initid AND moredata = :moredata', 
        [':userid' => $user->id, ':initid' => $userid, ':moredata' => $postid])->one();
        if (!empty($notif)) {
            if ($notif->delete())
                return 1;
        }
        $notification = new Notifications();
        $notification->userid   = $userid;
        $notification->initid   = $user->id;
        $notification->checked  = 0;
        $notification->type     = 'like';
        $notification->dateadd  = date('Y-m-d H:i:s', time());
        $notification->moredata = $postid;
        if ($notification->save()) return 1;
        return 0;
    }
}
