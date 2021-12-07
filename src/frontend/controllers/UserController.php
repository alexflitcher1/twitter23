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

/**
 * User controller
 * 
 * @author <Alex Flitcher>
 */
class UserController extends Controller
{
    /**
     * Index function
     * 
     * Show this user profile.
     * 
     * @param string $mode set post mode, add - add post, reply - reply post
     * @param int $replypost depricated
     * @return mixed
    */
    public function actionIndex($mode = "add", $replypost = 0)
    {
        // check auth
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
        $posts = Posts::find()
                        ->where(['userid' => htmlentities($user->id)])
                        ->orderBy(['id' => SORT_DESC])
                        ->all();
        $post  = [];
        $words = [];
        for ($i = 0; $i < count($posts); $i++)
        {
            $post[$i] = $posts[$i];
        }
        $replier = [];
        // get all repliers for this posts
        for ($i = 0; $i < count($posts); $i++)
        {
            $replies = Posts::find()->where(['replyid' => $post[$i]['id']])->all();
            if (count($replies)) {
                $post[$i]['replies'] = $replies;
                for ($j = 0; $j < count($replies); $j++)
                {
                    $replier[$i][$j] = User::findOne(['id' => $post[$i]['replies'][$j]['userid']]);
                }
            }
        }

        $model = new PostForm();
        if ($mode == "add") {
            // check entered data
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
                            return $this->redirect("/me");
                    }
            }
            $cookiesresp = Yii::$app->response->cookies;
            $cookiesresp->add(new \yii\web\Cookie([
                'name' => 'id',
                'expire' => time() + 31*24*60*60,
                'value' => serialize(['me']),
            ]));
        } elseif ($mode == "reply") {
            if ($replypost != 0) {
                $postr = Posts::findOne("userid = :userid AND id = :postid",
                                [':userid' => $user->id, ':id' => $replypost]);

                if ($model->load(Yii::$app->request->post()) 
                    && $model->validate()) {
                    $model->img = UploadedFile::getInstance($model, 'img');
                    $imgname = $model->upload();
                    if ($imgname) {
                        $npost = new Posts();
                        $npost->userid = htmlentities($user->id);
                        $npost->date = date('Y-m-d H:i:s', time());
                        $npost->text = htmlentities($model->text);
                        $npost->text = str_replace("\n", "<br>", $model->text);
                        $imgname = ($imgname === true) ? null : "/" . $imgname;
                        $npost->img = $imgname;
                        $npost->replyid = htmlentities($replypost);
                        $npost->likes = 0;
                        if ($npost->save()) {
                            // redirect to last page where user clicked reply button
                            if (!$cookies->get("id"))
                                return $this->redirect("/me");
                            if (isset(unserialize($cookies->get("id"))[0]) && 
                                unserialize($cookies->get("id"))[0] == "feed")
                                return $this->redirect("/feed?p=" . 
                                    unserialize($cookies->get("id"))[1]);
                            elseif (isset(unserialize($cookies->get("id"))[0]) && 
                                    unserialize($cookies->get("id"))[0] == "search")
                                return $this->redirect("/search?p=" . 
                                    unserialize($cookies->get("id"))[1] . 
                                    "&search=" . unserialize($cookies->get("id"))[2] 
                                    . "&mode=" . 
                                    unserialize($cookies->get("id"))[3]);
                            elseif (isset(unserialize($cookies->get("id"))[0]) && 
                                    unserialize($cookies->get("id"))[0] == "me")
                                return $this->redirect("/me");
                            return $this->redirect("/profile?id=" . 
                                    unserialize($cookies->get("id"))[1]);
                        }
                    }
                }
            }
        }
        return $this->render('index', ['user' => $user, 'posts' => $post,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'model' => $model]);
    }

    /** 
     * Login function
     * 
     * This function authorize user and save his username in cookie
     * 
     * @return mixed
    */
    public function actionLogin()
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if ($cookies->get("auth"))
            return $this->redirect("/feed");
        
        $model = new Login();
        if ($model->load(Yii::$app->request->post()) 
            && $model->validate()) {
            $user = User::findOne(['username' => htmlentities($model->username)]);

            $hash = htmlentities($user->password);
            // if entered user password is right
            if (Yii::$app->getSecurity()->validatePassword(
                htmlentities(htmlentities($model->password)), $hash)) {
                $cookies = Yii::$app->response->cookies;

                $cookies->add(new \yii\web\Cookie([
                    'name' => 'auth',
                    'expire' => time() + 31*24*60*60,
                    'value' => htmlentities($model->username),
                ]));
                return $this->redirect('/feed');
            } else {
                return $this->render('login', ['model' => $model,
                'error' => 'Не правильный пароль']);
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Profile function
     * 
     * Show any user profile
     * 
     * @param int $id parameter define user profile
     * @return mixed
    */
    public function actionProfile($id)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $user  = User::findOne(['username' => htmlentities($id)]);
        $thisuser = User::findOne(['username' => $cookies->get("auth")]);

        $status = Friends::find()
                            ->where(['friendid' => $user->id])
                            ->andWhere(['userid' => $thisuser->id])
                            ->one() ? "Отписаться" : "Подписаться";
        $suber = count(Friends::find()
                            ->where(['userid' => htmlentities($user->id)])
                            ->all());
        $subs  = count(Friends::find()
                            ->where(['friendid' => htmlentities($user->id)])
                            ->all());
        $posts = Posts::find()
                            ->where(['userid' => htmlentities($user->id)])
                            ->orderBy(['id' => SORT_DESC])
                            ->all();
        $post  = [];
        for ($i = 0; $i < count($posts); $i++)
        {
            $post[$i] = $posts[$i];
        }
        $replier = [];
        for ($i = 0; $i < count($posts); $i++)
        {
            // get all repliers
            $replies = Posts::find()->where(['replyid' => $post[$i]['id']])->all();
            if (count($replies)) {
                $post[$i]['replies'] = $replies;
                for ($j = 0; $j < count($replies); $j++)
                {
                    $replier[$i][$j] = User::findOne(['id' => $post[$i]['replies'][$j]]);
                }
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
                        return $this->redirect("/me");
                }
        }

        $cookiesresp = Yii::$app->response->cookies;
        unset($cookiesresp['page']);
        $cookiesresp->add(new \yii\web\Cookie([
            'name' => 'id',
            'expire' => time() + 31*24*60*60,
            'value' => serialize(['profile', $id]),
        ]));

        return $this->render('profile', ['user' => $user, 'posts' => $post,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 
                                       'status' => $status, 'model' => $model]);
    }

    /**
     * Signup function
     * 
     * This function make new note in database with 
     * user data wrote user in view/user/signup.php
     * 
     * @return mixed
     */
    public function actionSignup()
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if ($cookies->get("auth"))
            return $this->redirect("/feed");

        $model = new Signup();
        if ($model->load(Yii::$app->request->post()) 
            && $model->validate()) {
            $user               = new User();

            $user->username     = htmlentities($model->username);
            $user->name         = htmlentities($model->name);
            $user->email        = htmlentities($model->email);
            $user->gender       = htmlentities($model->gender);
            $user->language     = htmlentities($model->language);
            $user->regdate      = date('Y-m-d H:i:s', time());
            $user->password     =
            htmlentities(Yii::$app->getSecurity()->generatePasswordHash($model->password));

            if ($user->save()) {
                $cookies = Yii::$app->response->cookies;

                $cookies->add(new \yii\web\Cookie([
                    'name' => 'auth',
                    'expire' => time() + 14*24*60*60,
                    'value' => htmlentities($model->username),
                ]));
                return $this->redirect('/feed');
            }
            return $this->render('signup', ['model' => $model]);
        }
        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Settings function
     * 
     * This function change parameters selected
     * use in view/user/settings.php
     * 
     * @todo do logic part
     * @return mixed
     */
    public function actionSettings()
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        return $this->render('settings');
    }

    /**
     * Settings Profile function
     * 
     * This function can change user data. User can 
     * change his data in view/user/settingsprofile.php
     * 
     * @return mixed
     */
    public function actionSettingsProfile()
    {
        // check auth
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
        $model = new Settings();
        $model->gender   = $user->gender;
        $model->about    = $user->about;
        $model->city     = $user->city;
        $model->site     = $user->site;
        $model->name     = $user->name;
        $model->telegram = $user->telegram;
        $model->username = $user->username;
        if ($model->load(Yii::$app->request->post()) 
        && $model->validate()) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->bgimage = UploadedFile::getInstance($model, 'bgimage');
            $imgname2 = $model->uploadBg();
            $imgname = $model->upload();
            $error = null;
            if ($imgname) {
                $user->username = htmlentities($user->username);
                if ($user->username != htmlentities($model->username)) {
                    $isuserexists = User::findOne(['username' => htmlentities($model->username)]);
                    if ($isuserexists) {
                        $error = "Имя занято";
                        $user->username = htmlentities($user->username);
                    } else $user->username = htmlentities($model->username);
                }

                $user->gender       = htmlentities($model->gender);
                $user->about        = htmlentities($model->about);
                $user->city         = htmlentities($model->city);
                $user->site         = htmlentities($model->site);
                $user->name         = htmlentities($model->name);
                $user->telegram     = htmlentities($model->telegram);
                $user->img          = ($imgname === true) ? $user->img : $imgname;
                $user->bgimage          = ($imgname2 === true) ? $user->bgimage : $imgname2;
                if ($user->save()) {
                    $cookies = Yii::$app->response->cookies;
                    $cookies->add(new \yii\web\Cookie([
                        'name' => 'auth',
                        'expire' => time() + 14*24*60*60,
                        'value' => htmlentities($user->username),
                    ]));
                    return $this->render('settingsprofile', ['model' => $model, 'user' => $user, 
                    'suber' => $suber, 'subs' => $subs, 'posts' => $posts, 'error' => $error]);
                }
            }
        }

        $model1 = new PostForm();
        if ($model1->load(Yii::$app->request->post()) 
            && $model1->validate()) {
                $model1->img = UploadedFile::getInstance($model1, 'img');
                $imgname = $model1->upload();
                if ($imgname) {
                    // count entered words
                    $allwords = explode(" ", htmlentities($model1->text));
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
                    $npost->text = htmlentities($model1->text);
                    $npost->text = str_replace("\n", "<br>", $model1->text);
                    $imgname = ($imgname === true) ? null : "/" . $imgname;
                    $npost->img = $imgname;
                    $npost->likes = 0;
                    if ($npost->save())
                        return $this->redirect("/me");
                }
        }
        return $this->render('settingsprofile', ['model' => $model, 'user' => $user, 
        'suber' => $suber, 'subs' => $subs, 'posts' => $posts, 'error' => null, 'model1' => $model1]);
    }

    /**
     * Quit function
     * 
     * Delete 'auth' cookie
     * 
     * @return mixed
     */
    public function actionQuit()
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookies = Yii::$app->response->cookies;
        $cookies->remove("auth");
        return $this->redirect("/login");
    }

    /**
     * 404 function
     * 
     * Make 404 error
     * 
     * @return mixed
     */    
    public function actionError()
    {
        // check auth
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
        $postscount = count(Posts::find()
                                    ->where(['userid' => htmlentities($user->id)])
                                    ->all());

        $randpost = Posts::find()
                            ->where(['replyid' => '0'])
                            ->orderBy('RAND()')
                            ->limit(1)
                            ->offset(0)
                            ->one();
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
                    return $this->redirect("/me");
            }
    }
        $randpost['authordata'] = User::findOne(['id' => $randpost->userid]);
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            if ($exception->statusCode == 404)
                return $this->render('error404', [
                            'exception' => $exception, 'model' => $model,
                            'user' => $user, 'suber' => $suber,
                            'subs' => $subs, 'posts' => $postscount,
                            'randpost' => $randpost, 'author' => $author]);
            else
                return $this->render('error', ['exception' => $exception]);
        }
    }

    public function actionSubscribers($id = 0, $p = 0, $mode = 0)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $offset = 50;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $popular = Popular::find()
            ->orderBy(['count' => SORT_DESC])
            ->limit(10)
            ->offset(0)
            ->all();
        $modename = $mode == 0 ? 'friendid' : 'userid';
        if ($id == 0) {
            $subers = Friends::find()
                ->where([$modename => $user->id])
                ->limit($offset)
                ->offset($p*$offset)
                ->all();
        } else {
            $subers = Friends::find()
                ->where([$modename => $id])
                ->limit($offset)
                ->offset($p*$offset)
                ->all();
        }
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
        $modename = $mode == 0 ? 'userid' : 'friendid';
        $datasubs = [];
        for ($i = 0; $i < count($subers); $i++) {
            $datasubs[$i] = User::findOne(['id' => $subers[$i][$modename]]);
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
                        return $this->redirect("/me");
                }
        }
        return $this->render('subscribers', ['user' => $user, 'popular' => $popular, 'datasubs' => $datasubs,
                                             'suber' => $suber, 'subs' => $subs, 'posts' => $posts, 'id' => $id,
                                             'model' => $model, 'mode' => $mode]);
    }

    public function actionMoreSubs($p = 0, $id = 0, $offset = 50, $limit = 50, $mode = 0) 
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = 'none';
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $modename = $mode == 0 ? 'friendid' : 'userid';
        if ($id == 0) {
            $subers = Friends::find()
                ->where([$modename => $user->id])
                ->limit($offset)
                ->offset($p*$offset)
                ->all();
        } else {
            $subers = Friends::find()
                ->where([$modename => $id])
                ->limit($offset)
                ->offset($p*$offset)
                ->all();

        }
        $modename = $mode == 0 ? 'userid' : 'friendid';
        $datasubs = [];
        for ($i = 0; $i < count($subers); $i++) {
            $datasubs[$i] = User::findOne(['id' => $subers[$i][$modename]]);
        }
        return $this->render('more-subs', ['datasubs' => $datasubs]);
    }
}
