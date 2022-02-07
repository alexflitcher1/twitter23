<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Поиск";
?>
		<div class="page_body">
		<div class="page_content">
		<div class="page_feed_header">
			<div class="page_feed_header_left">
				Поиск
			</div>
			<div class="page_feed_header_right"></div>
		</div>
		<?php $form = ActiveForm::begin(); ?>
			<div class="search">
				<div class="search_input">
					<?=$form->field($model, 'text')?>
				</div>
				<div class="search_choose"></div>
				<div class="search_bt">
					<?=Html::submitButton('Поиск', ['class' => 'btn btn-success'])?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
		<div class="posts">
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/posts_view_admin.php"; ?>
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/pagination.php"; ?>	
			</div>
			<div class="page_menu">
				<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_admin.php"; ?>
			</div>
		</div>
<?php
$js = <<<JS
var p = 1;
$('body').on('click', '.load_more', function(e) {
	if ($mode == 0 || $mode == 2) {
		$.ajax({
			method: 'GET',
			url: '/admin/search-index?offset=50&limit=50&search=$search&p=' + p,
		}).done(function(data) {
			p += 1;
			$('.posts').append(data);
		});
	}
});
JS;
$this->registerJs($js);
?>
