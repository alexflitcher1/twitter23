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
        $offset = 50;
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
        $likes = [];
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
        }
        // users shows only on first page
        if ($p != 0) $users = [];

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
                for ($i = 0; $i < count($words); $i++) {
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

        $cookiesresp = Yii::$app->response->cookies;
        $cookies = Yii::$app->response->cookies;
        $cookiesresp->add(new \yii\web\Cookie([
            'name' => 'id',
            'expire' => time() + 31*24*60*60,
            'value' => serialize(['search', $p, $search, $mode]),
        ]));

        return $this->render('index', ['user' => $user, 'model' => $model,
                                       'postscount' => $postscount, 'liked' => $likes,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'users' => $users,
                                       'posts' => $post, 'page' => $p,
                                       'search' => $search, 'mode' => $mode,
                                       'popular' => $popular, 'model1' => $model1]);

    }

    public function actionSearchMore($search, $p, $offset, $limit)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = "none";
        $username = $cookies->get("auth")->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $posts = Posts::find()
                            ->where(['like', 'text', '%' . htmlentities($search) . '%', false])
                            ->andWhere(['replyid' => '0'])
                            ->orderBy(['date' => SORT_DESC])
                            ->limit($limit)
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
        return $this->render('search-posts', ['user' => $user,
        'repliers' => $replier, 'liked' => $likes,
        'posts' => $posts, 'page' => $p]);
    }

    public function actionSearchUsers($search, $p, $offset, $limit)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = "none";
        $username = $cookies->get("auth")->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $users = User::find()
                ->where(['like', 'username',  '%' . htmlentities($search) . '%', false])
                ->offset($p*$offset)->limit($offset)
                ->all();
        return $this->render('search-users', ['user' => $user,
        'users' => $users, 'page' => $p]);
    }
}
