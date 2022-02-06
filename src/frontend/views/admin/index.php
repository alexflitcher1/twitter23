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
			<div class="page_menu"><div class="page_menu_sticky">
				<div class="profile_names">
					<div class="profile_names_left">
						<img src="/<?=$user->img?>" class="profile_names_ava">
					</div>
					<div class="profile_names_right">
						<div class="profile_names_username"><?=$user->username?></div>
						<div class="profile_names_name"><?=$user->name?></div>
					</div>
				</div>
				<div class="page_menu_nav">
					<a href="#">
						<div class="page_menu_nav_link">Пользователи</div>
					</a>
					<a href="#">
						<div class="page_menu_nav_link_active">Твиты</div>
					</a>
					<a href="#">
						<div class="page_menu_nav_link">Администраторы</div>
					</a>
					<a href="#">
						<div class="page_menu_nav_link">Функции</div>
					</a>
				</div>





			</div></div>
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
