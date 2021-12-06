<?php
use yii\helpers\Html;
?>
<?php for ($i = 0; $i < count($datasubs); $i++): ?>
            <div class="post_list">
               <div class="post_ava">
                  <img src="<?=$datasubs[$i]->img?>">
               </div>
               <div class="post_content">
                  <div class="post_content_name">
                     <?=$datasubs[$i]->name?> <a href="/profile?id=<?=$datasubs[$i]->username?>">@<?=$datasubs[$i]->username?></a>
                  </div>
                  <div class="post_content_data">
                     Дата регистрации: <?=Html::encode(date("d.m.Y", strtotime($datasubs[$i]->regdate)))?>
                  </div>
                  <div class="post_content_text">
                     <?=Html::encode($datasubs[$i]->about)?>
                  </div>
               </div>
            </div>
<?php endfor; ?> 