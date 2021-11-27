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

/**
 * Posts controller
 * 
 * @author <Alex Flitcher>
 */
class PostsController extends Controller
{
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
        for ($i = 0; $i < count($posts); $i++)
        {
            // get author post data
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
                    $replier[$i][$j] = User::findOne(['id' => $posts[$i]['replies'][$j]['userid']]);
                }
            }
        }

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
                                       'repliers' => $replier, 
                                       'popular' => $popular,
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
        if ($user->id == $post->userid) {
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
            $plus = 1;
            $friended = new Friends();
            $friended->userid = $user->id;
            $friended->friendid = $id;
            $friended->save();
        } else {
            // ... unsubscribe
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
        if ($user->id == $post->userid) {
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
}
