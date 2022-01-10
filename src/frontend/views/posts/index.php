<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Twitter23";
?>
<div class="page_body">
	<div class="page_content">
		<div class="page_feed_header">
			<div class="page_feed_header_left">
				Что нового?
			</div>
			<div class="page_feed_header_right">
				<b class="page_feed_header_right_entered"></b>
				/
				320
			</div>
		</div>
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
				<div class="newpost_feed">
					<div class="newpost_textarea">
						<?=$form->field($model, 'text')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
					</div>
					<div class="newpost_bts">
						<div class="newpost_tw">
							<label for="postform-img" class="btn" id="img-label">Прикрепить <a href="#"></a></label>
							<a href="#"><?=$form->field($model, 'img')->fileInput()?></a>
						</div>
						<div class="newpost_bt">
							<button>Опубликовать</button>
						</div>
					</div>
				</div>
		<?php ActiveForm::end() ?>
		<div class="posts">
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/posts_view.php"; ?>
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/pagination.php"; ?>
		</div>
		<div class="page_menu">
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_posts.php"; ?>
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
var p = 1;
$('body').on('click', '.load_more', function(e) {
	$.ajax({
		method: 'GET',
		url: '/posts/load-more?offset=50&limit=50&p=' + p,
	}).done(function(data) {
		p += 1;
		$('.posts').append(data);
	});
});
document.querySelector(".page_feed_header_right b").innerHTML = $("textarea[name='PostForm[text]").val().length
$("textarea[name='PostForm[text]").keyup(function (e) {
   if ($(this).val().length >= 320) $(this).val($(this).val().slice(0, 320))
   document.querySelector(".page_feed_header_right b").innerHTML = $(this).val().length
})
JS;
$this->registerJs($js);
?>