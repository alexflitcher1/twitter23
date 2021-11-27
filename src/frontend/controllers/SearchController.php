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

/**
 * Search controller
 * 
 * @author <Alex Flitcher>
 */
class SearchController extends Controller
{
    /**
     * Search function
     * 
     * This function search info in database
     * 
     * @param int $p page of results, count of result set $offset variable
     * @param null|string $search Search string
     * @param int $mode define search mode. 0 - find all types of data. 
     * @param int $mode 1 - find only users. 2 - find only posts
     * @return mixed
     */
    public function actionIndex($p = 0, $search = null, $mode = 0)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $offset = 10;
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
        $model = new SearchForm();
        // if user inputed search string
        if ($model->load(Yii::$app->request->post()) 
            && $model->validate()) {
            $search = htmlentities($model->text);
        }

        if ($search) {
            if ($mode == 0) {
                $users = User::find()
                            ->where(['like', 'username',  '%' . htmlentities($search) . '%', false])
                            ->limit(3)
                            ->all();
                $posts = Posts::find()
                            ->offset($p*$offset)
                            ->limit($offset)
                            ->where(['like', 'text', '%' . htmlentities($search) . '%', false])
                            ->andWhere(['replyid' => '0'])
                            ->orderBy(['id' => SORT_DESC])
                            ->all();
                for ($i = 0; $i < count($posts); $i++)
                {
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
                            $replier[$i][$j] = User::findOne(['id' => $post[$i]['replies'][$j]['userid']]);
                        }
                    }
                }
            } elseif ($mode == 1) {
                $users = User::find()
                        ->where(['like', 'username',  '%' . htmlentities($search) . '%', false])
                        ->offset($p*$offset)->limit($offset)
                        ->all();
            } elseif ($mode == 2) {
                $posts = Posts::find()
                        ->where(['like', 'text', '%' . htmlentities($search) . '%', false])
                        ->orderBy(['id' => SORT_DESC])
                        ->all();
                for ($i = 0; $i < count($posts); $i++)
                {
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
                            $replier[$i][$j] = User::findOne(['id' => $post[$i]['replies'][$j]['userid']]);
                        }
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
            'value' => serialize(['search', $p, $search, $mode]),
        ]));

        return $this->render('index', ['user' => $user, 'model' => $model,
                                       'postscount' => $postscount,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'users' => $users,
                                       'posts' => $post, 'page' => $p,
                                       'search' => $search, 'mode' => $mode,
                                       'popular' => $popular]);

    }
}
