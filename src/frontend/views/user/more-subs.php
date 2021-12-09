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
                     <?=$datasubs[$i]->name?> <a href="/<?=$datasubs[$i]->username?>">@<?=$datasubs[$i]->username?></a>
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
<?php
$js = <<<JS
for (i = 0; i < $(".post_content_text").length; i++) {
	$(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerHTML.replace(/#(\w*)/ig, "<a href='/search?search=$1'>#$1</a>")
}
JS;
$this->registerJs($js);
?>