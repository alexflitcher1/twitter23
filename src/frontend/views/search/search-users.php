<?php
use yii\helpers\Html;
?>
<?php for ($i = 0; $i < count($users); $i++): ?>
					<div class="post">
						<div class="post_ava">
							<img src="/<?=Html::encode($users[$i]->img)?>">
						</div>
						<div class="post_content">
							<div class="post_content_name">
								<?=Html::encode($users[$i]->name)?>
								<a href="/<?=Html::encode($users[$i]->username)?>">
									@<?=Html::encode($users[$i]->username)?>
								</a>
							</div>
							<div class="post_content_data">
								<?=Html::encode($users[$i]->regdate)?>
							</div>
							<div class="post_content_text">
								<?=Html::encode($users[$i]->about)?>
							</div>
							<div class="post_content_nav">
								<div class="post_content_nav_left"></div>
								<div class="post_content_nav_right"></div>
							</div>
						</div>
					</div>
				<?php endfor; ?>
				<?php
$js = <<<JS
for (i = 0; i < $(".post_content_text").length; i++) {
	$(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerHTML.replace(/#(\w*)/ig, "<a href='/search?search=$1'>#$1</a>")
}
for (i = 0; i < $(".post_content_text").length; i++) {
	$(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerText.replace(/^((?:https?\:)?(?:\/{2})?)?((?:[\w\d_]{1,64})\.(?:[\w\d_\.]{2,64}))(\:\d{2,6})?((?:\/|\?|#|&){1}(?:[\w\d\S]+)?)?/ig, "<a href='$1$2$3'>$1$2$3</a>")
}
JS;
$this->registerJs($js);
?>