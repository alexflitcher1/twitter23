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
use frontend\components\ActionBanFilter;

class AdminController extends Controller 
{
    public function behaviors()
    {
        return [
            [
                'class' => 'frontend\components\ActionBanFilter',
            ],
        ];
    }
    
    public function actionIndex($p = 0, $search = null, $mode = 2) 
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $offset = 50;
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        if ($user->status != 'admin')
            return $this->redirect('/feed');
        $suber = count(Friends::find()
                            ->where(['userid' => htmlentities($user->id)])
                            ->all());
        $subs  = count(Friends::find()
                            ->where(['friendid' => htmlentities($user->id)])
                            ->all());
        $postscount = count(Posts::find()
                            ->where(['userid' => htmlentities($user->id)])
                            ->orderBy(['id' => SORT_DESC])
                            ->all());
        $popular = Popular::find()
                            ->orderBy(['count' => SORT_DESC])
                            ->limit(10)
                            ->offset(0)
                            ->all();
        $post  = [];
        $replier = [];
        $users = [];
        $likes = [];
        $model = new SearchForm();
        // if user inputed search string
        if ($model->load(Yii::$app->request->post()) 
            && $model->validate()) {
            $search = htmlentities($model->text);
        }

            if ($mode == 2) {
                if ($search)
                    $posts = Posts::find()
                            ->where(['like', 'text', '%' . htmlentities($search) . '%', false])
                            ->orderBy(['id' => SORT_DESC])
                            ->all();
                else
                    $posts = Posts::find()
                            ->where(['replyid' => '0'])
                            ->orderBy(['date' => SORT_DESC])
                            ->limit($offset)
                            ->offset($p*$offset)
                            ->all();
                for ($i = 0; $i < count($posts); $i++)
                {
                    if (Likes::findOne(['userid' => $user->id, 'postid' => $posts[$i]['id']]))
                        $likes["{$posts[$i]['id']}"] = 1;
                    $post[$i] = $posts[$i];
                    $post[$i]['authordata'] = User::findOne(['id' => $post[$i]['userid']]);
                }
                $replier = [];
                for ($i = 0; $i < count($posts); $i++)
                {
                    $replies = Posts::find()
                        ->where(['replyid' => $post[$i]['id']])
                        ->all();
                    if (count($replies)) {
                        $post[$i]['replies'] = $replies;
                        for ($j = 0; $j < count($replies); $j++)
                        {
                            if (Likes::findOne(['userid' => $user->id, 'postid' => $posts[$i]['replies'][$j]['id']]))
                                $likes["{$posts[$i]['replies'][$j]['id']}"] = 1;
                            $replier[$i][$j] = User::findOne(['id' => $post[$i]['replies'][$j]['userid']]);
                        }
                    }
                }
            }
        // users shows only on first page
        if ($p != 0) $users = [];

        $cookiesresp = Yii::$app->response->cookies;
        $cookies = Yii::$app->response->cookies;
        $cookiesresp->add(new \yii\web\Cookie([
            'name' => 'id',
            'expire' => time() + 31*24*60*60,
            'value' => serialize(['admin/index', $p, $search, $mode]),
        ]));

        return $this->render('index', ['user' => $user, 'model' => $model,
                                       'postscount' => $postscount, 'liked' => $likes,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'users' => $users,
                                       'posts' => $post, 'page' => $p,
                                       'search' => $search, 'mode' => $mode,
                                       'popular' => $popular]);
    }

    public function actionSearchIndex($search, $p, $offset, $limit)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = "none";
        $username = $cookies->get("auth")->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        if ($user->status != 'admin')
            return $this->redirect('/feed');
        if ($search)
            $posts = Posts::find()
                                ->where(['like', 'text', '%' . htmlentities($search) . '%', false])
                                ->andWhere(['replyid' => '0'])
                                ->orderBy(['date' => SORT_DESC])
                                ->limit($limit)
                                ->offset($p*$offset)
                                ->all();
        else
            $posts = Posts::find()
                ->where(['replyid' => '0'])
                ->orderBy(['date' => SORT_DESC])
                ->limit($offset)
                ->offset($p*$offset)
                ->all();
        $post  = [];
        $likes = [];
        for ($i = 0; $i < count($posts); $i++)
        {
            // get author post data
            if (Likes::findOne(['userid' => $user->id, 'postid' => $posts[$i]['id']]))
                $likes["{$posts[$i]['id']}"] = 1;
            $posts[$i]['authordata'] = User::findOne(['id' => $posts[$i]['userid']]);
        }
        $replier = [];
        for ($i = 0; $i < count($posts); $i++)
        {
            // find all notes where replyid = postid
            $replies = Posts::find()->where(['replyid' => $posts[$i]['id']])->all();
            if (count($replies)) {
                $posts[$i]['replies'] = $replies;
                for ($j = 0; $j < count($replies); $j++)
                {
                    // find reply author
                    if (Likes::findOne(['userid' => $user->id, 'postid' => $posts[$i]['replies'][$j]['id']]))
                        $likes["{$posts[$i]['replies'][$j]['id']}"] = 1;
                    $replier[$i][$j] = User::findOne(['id' => $posts[$i]['replies'][$j]['userid']]);
                }
            }
        }
        return $this->render('search-index', ['user' => $user,
        'repliers' => $replier, 'liked' => $likes,
        'posts' => $posts, 'page' => $p]);
    }

    public function actionBan($mode = 1, $id = 0, $sure = null) 
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $offset = 50;
        $username = $cookie->value;
        $banuser = User::findOne(['id' => htmlentities($id)]);
        $user  = User::findOne(['username' => htmlentities($username)]);
        if ($user->status != 'admin')
            return $this->redirect('/feed');
        if ($id == 0)
            return $this->redirect('/admin/index');
        if ($mode == 1 && $sure == null)
            return $this->render('infban', ['banuser' => $banuser, 'mode' => $mode]);
        $banuser->status = 'ban';
        $banuser->save();
        return $this->redirect('/admin/index');
    }
}