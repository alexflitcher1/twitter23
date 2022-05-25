<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\User;
use frontend\models\Posts;
use frontend\models\Friends;
use frontend\models\Telebotauth;

class TelegramBotSend extends Model {
    public function sendSubs($postid) {
        $bot = new \TelegramBot\Api\Client('5398685034:AAGQu9onvgQ063HQM_5l_fvktYt9uK2jrtU');
        $post = Posts::findOne($postid);
        $userid = $post->userid;
        $author = User::findOne(['id' => $userid]);
        $subs = Friends::find()->where(['friendid' => $userid])->asArray()->all();
        $text = '';
        for ($i = 0; $i < count($subs); $i++) {
            $teleuser = Telebotauth::findOne(['userid' => $subs[$i]['userid']]);
            $text = str_replace("<br>", "\n", "#{$post->id}\n<b>{$author->username}</b> опубликовал(-а) в <b>{$post->date}</b>:\n{$post->text}");
            if (!is_null($teleuser)) {
                if (!$post->img) {
                    $keyboard = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup(
                        [
                            [
                                ['text' => 'Like👍', 'callback_data' => 'like_' . $post->id],
                                ['text' => 'Reply', 'callback_data' => 'repl_' . $post->id],
                                ['text' => 'Open', 'url' => 'http://twitter23.witch.quest/show?userid=30&postid=' . $post->id, 'callback_data' => 'open'],
                            ]
                        ]
                    );
                    $bot->sendMessage($teleuser->chatid, $text, 'HTML', false, null, $keyboard);
                } else {
                    $photo = substr($post->img, 1);
                    $bot->sendPhoto($teleuser->chatid, new \CURLFile($photo), $text, NULL, NULL, NULL, "HTML");
                }
            }
        }
    }
}