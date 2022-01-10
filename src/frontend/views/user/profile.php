<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = $thisuser->name . " - " . "Twitter23";
?>
<div class="page_body">
	<div class="page_content">
		<div class="page_content_header" style="background: url(/<?=Html::encode($thisuser->bgimage)?>)">
			<div class="page_content_header_ava">
				<img src="/<?=Html::encode($thisuser->img)?>">
			</div>
		</div>
		<div class="newpost_pr">
			<div class="newpost_textarea">
				
			</div>
			<div class="newpost_bts">
			</div>
		</div>
		<div class="posts">
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/posts_view.php"; ?>
		</div>
		<div class="page_menu">
				<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu.php"; ?>
				<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
				<div class="page_menu_newpost">
					<div class="page_menu_newpost_textarea">
						<?=$form->field($model, 'text')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
					</div>
					<div class="page_menu_newpost_bts">
						<div class="page_menu_newpost_tw">
							<label for="postform-img" class="btn" id="img-label">Прикрепить <a href="#"></a></label>
							<a href="#"><?=$form->field($model, 'img')->fileInput()?></a>
						</div>
						<div class="page_menu_newpost_bt">
							<button>Опубликовать</button>
						</div>
					</div>
				<?php ActiveForm::end() ?>
				</div>
			</div>
		</div>
</div>
<?php
$js = <<<JS
$('.subscribe').click(function(e) {
	var postid = $(this).attr("data-id")
	var it = this
	$.ajax({
		method: 'GET',
		url: '/posts/subscribe?id=' + $thisuser->id,
	}).done(function(data) {
		if (data*1 == 0) it.innerHTML = "Подписаться"
		else if (data*1 == 1) it.innerHTML = "Отписаться"
		console.log(data)
	});
});
JS;
$this->registerJs($js);
?>
