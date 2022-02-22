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
use frontend\models\Notifications;
use frontend\components\ActionBanFilter;
use frontend\components\ActionTechFilter;

/**
 * Posts controller
 * 
 * @author <Alex Flitcher>
 */
class PostsController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'frontend\components\ActionBanFilter',
            ],
            [
                'class' => 'frontend\components\ActionTechFilter',
            ],
        ];
    }
    /**
     * Feed funcitons
     * 
     * This funciton search all posts and partly return this data
     * 
     * @param int $p page of results, count of result set $offset variable
     * @return mixed
     */
    public function actionIndex($p = 0)
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
        $posts = Posts::find()
                            ->where(['replyid' => '0'])
                            ->orderBy(['date' => SORT_DESC])
                            ->limit($offset)
                            ->offset($p*$offset)
                            ->all();
        $popular = Popular::find()
                            ->orderBy(['count' => SORT_DESC])
                            ->limit(10)
                            ->offset(0)
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
                    $lastinsertid = "";
                    if ($npost->save() && ($lastinsertid = Yii::$app->db->getLastInsertID())) {
                        $matches = [];
                        if (preg_match_all("/@\w+/i", htmlentities($model->text), $matches)) {
                            for ($i = 0; $i < count($matches[0]); $i++) {
                                $taguname = str_replace('@', '', $matches[0][$i]);
                                $tagudata = User::findOne(['username' => $taguname]);
                                if (!empty($tagudata)) {
                                    $nofitication           = new Notifications();
                                    $nofitication->userid   = $tagudata->id;
                                    $nofitication->type     = 'tag';
                                    $nofitication->checked  = 0;
                                    $nofitication->moredata = $lastinsertid;
                                    $nofitication->initid   = $user->id;
                                    $nofitication->dateadd  = date('Y-m-d H:i:s', time());
                                    $nofitication->save();
                                }
                            }
                        }
                        return $this->redirect("/feed?p=" . $p);
                    }
                }
        }

        $model = new PostForm();
        $cookiesresp = Yii::$app->response->cookies;
        $cookies = Yii::$app->response->cookies;
        $cookiesresp->add(new \yii\web\Cookie([
            'name' => 'id',
            'expire' => time() + 31*24*60*60,
            'value' => serialize(['feed', $p]),
        ]));

        return $this->render('index', ['user' => $user, 
                                       'postscount' => $postscount,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'liked' => $likes, 
                                       'popular' => $popular, 'model' => $model,
                                       'posts' => $posts, 'page' => $p]);
    }

    public function actionMyfeed($p = 0) 
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
        $friends = Friends::find()->where(['userid' => $user->id])->all();
        $ids = [];

        for ($i = 0; $i < count($friends); $i++)
            $ids[$i] = $friends[$i]['friendid'];
        
        $posts = Posts::find()
            ->where(['replyid' => '0'])
            ->andWhere(['in', 'userid', $ids])
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
                    $lastinsertid = "";
                    if ($npost->save() && ($lastinsertid = Yii::$app->db->getLastInsertID())) {
                        $matches = [];
                        if (preg_match_all("/@\w+/i", htmlentities($model->text), $matches)) {
                            for ($i = 0; $i < count($matches[0]); $i++) {
                                $taguname = str_replace('@', '', $matches[0][$i]);
                                $tagudata = User::findOne(['username' => $taguname]);
                                if (!empty($tagudata)) {
                                    $nofitication           = new Notifications();
                                    $nofitication->userid   = $tagudata->id;
                                    $nofitication->type     = 'tag';
                                    $nofitication->checked  = 0;
                                    $nofitication->moredata = $lastinsertid;
                                    $nofitication->initid   = $user->id;
                                    $nofitication->dateadd  = date('Y-m-d H:i:s', time());
                                    $nofitication->save();
                                }
                            }
                        }
                        return $this->redirect("/myfeed?p=" . $p);
                    }
                }
        }
        
        $model = new PostForm();
        $cookiesresp = Yii::$app->response->cookies;
        $cookies = Yii::$app->response->cookies;
        $cookiesresp->add(new \yii\web\Cookie([
            'name' => 'id',
            'expire' => time() + 31*24*60*60,
            'value' => serialize(['feed', $p]),
        ]));
        
        return $this->render('myfeed', ['user' => $user, 
                                       'postscount' => $postscount,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'liked' => $likes, 
                                       'popular' => $popular, 'model' => $model,
                                        'posts' => $posts, 'page' => $p]);
    }

    /**
     * Like function
     * 
     * This function add or delete like note in database
     * 
     * @param int $id post id
     * @return int 1 - add. -1 - delete
     */
    public function actionLike($id)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookies = Yii::$app->request->cookies;
        $username = $cookies->get("auth");
        $post = Posts::findOne(['id' => $id]);
        $user = User::findOne(['username' => $username]);
        $like = Likes::findOne(['userid' => $user->id, 'postid' => $id]);
        $plus = 0;
        // if like not exists make it...
        if (empty($like)) {
            $plus = 1;
            $liked = new Likes();
            $liked->userid = $user->id;
            $liked->postid = $id;
            $liked->save();
            $post->likes = $post->likes + 1;
            $post->save();
        } else {
            // ... or delete it
            $plus = -1;
            $like->delete();
            $post->likes = $post->likes - 1;
            $post->save();
        }
        return $plus;
    }

    /**
     * Delete post function
     * 
     * Delete post
     * 
     * @param int $id post id which will delete
     * @return mixed
     */
    public function actionDelete($id)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookies = Yii::$app->request->cookies;
        $username = $cookies->get("auth");
        $post = Posts::findOne(['id' => $id]);
        $user = User::findOne(['username' => $username]);
        // if this user id equal author post id...
        if ($user->id == $post->userid || $user->status == 'admin') {
            // ... delete post
            if ($post->delete()) return 1;
        }
        return 0;
    }

    /**
     * Subscribe function
     * 
     * Function add/delete subscribe note in database
     * 
     * @param int $id friend id
     * @return int
     */
    public function actionSubscribe($id)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookies = Yii::$app->request->cookies;
        $username = $cookies->get("auth");
        $user = User::findOne(['username' => $username]);
        $friends = Friends::findOne(['userid' => $user->id, 'friendid' => $id]);
        $plus = 0;
        // if this user doesn't subscribe...
        if (empty($friends)) {
            // ... subscribe
            $nofitication = new Notifications();
            $nofitication->moredata = "";
            $nofitication->userid = $id;
            $nofitication->initid = $user->id;
            $nofitication->type = 'subscribe';
            $nofitication->checked = 0;
            $nofitication->dateadd  = date('Y-m-d H:i:s', time());
            $nofitication->save();
            $plus = 1;
            $friended = new Friends();
            $friended->userid = $user->id;
            $friended->friendid = $id;
            $friended->save();
        } else {
            // ... unsubscribe
            $nofitication = Notifications::findOne(['userid' => $id, 'initid' => $user->id, 'type' => 'subscribe']);
            if (!empty($nofitication)) $nofitication->delete();
            $plus = 0;
            $friends->delete();
        }
        return $plus;
    }

    /**
     * Edit function
     * 
     * This function changes user post
     * 
     * @param int $id edit post id
     * @return mixed
     */
    public function actionEdit($id)
    {
        // check auth
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $cookie = $cookies->get('auth');
        $username = $cookie->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $post = Posts::findOne(['id' => $id]);
        $model = new PostForm();
        if ($user->id == $post->userid || $user->status == 'admin') {
            if ($model->load(Yii::$app->request->post()) 
            && $model->validate()) {
                $model->img = UploadedFile::getInstance($model, 'img');
                $imgname = $model->upload();
                if ($imgname) {
                    $post->text = htmlentities($model->text);
                    $imgname = ($imgname === true) ? $post->img : "/" . $imgname;
                    $post->img = $imgname;
                    if ($post->save())
                        return $this->redirect("/me");
                }
            }
        }
        return $this->render('edit', ['model' => $model, 'user' => $user,
                                      'post' => $post]);
    }

    public function actionLoadMore($offset, $limit, $p)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = "none";
        $username = $cookies->get("auth")->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $posts = Posts::find()
                            ->where(['replyid' => '0'])
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
        return $this->render('load-more', ['user' => $user,
        'repliers' => $replier, 'liked' => $likes,
        'posts' => $posts, 'page' => $p]);
    }

    public function actionLoadMoreMyfeed($offset, $limit, $p)
    {
        $cookies = Yii::$app->request->cookies;
        if (!$cookies->get("auth"))
            return $this->redirect("/login");
        $this->layout = "none";
        $username = $cookies->get("auth")->value;
        $user  = User::findOne(['username' => htmlentities($username)]);
        $friends = Friends::find()->where(['userid' => $user->id])->all();
        $ids = [];

        for ($i = 0; $i < count($friends); $i++)
            $ids[$i] = $friends[$i]['friendid'];
        
        $posts = Posts::find()
            ->where(['replyid' => '0'])
            ->andWhere(['in', 'userid', $ids])
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
        return $this->render('load-more-myfeed', ['user' => $user,
        'repliers' => $replier, 'liked' => $likes,
        'posts' => $posts, 'page' => $p]);
    }

    public function actionShow($postid, $userid)
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
        $postscount = count(Posts::find()
                            ->where(['userid' => htmlentities($user->id)])
                            ->orderBy(['id' => SORT_DESC])
                            ->all());
        $userid = User::findOne(['id' => htmlentities($userid)]);
        if (empty($userid)) return $this->redirect("/feed");
        
        $posts = Posts::find()->where(['id' => htmlentities($postid)])->all();

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
                        return $this->redirect("/feed");
                }
        }
        return $this->render('show', ['user' => $user, 
                                       'postscount' => $postscount,
                                       'suber' => $suber, 'subs' => $subs,
                                       'repliers' => $replier, 'liked' => $likes, 
                                       'model' => $model, 'posts' => $posts]);
    }
}
