<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$language = \Yii::$app->request->cookies->get("language");
$this->title = \Yii::$app->params['locales']["$language"][33];
?>
<div class="page_body">
	<div class="page_content">
		<div class="page_feed_header">
			<div class="page_feed_header_left">
				<?=\Yii::$app->params['locales']["$language"][33]?>
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
					<?=Html::submitButton(\Yii::$app->params['locales']["$language"][33], ['class' => 'btn btn-success'])?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
		<div class="posts">
			<?php if (($mode == 1 || $mode == 0) && $page == 0 && isset($users) && count($users)): ?>
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
				<?php if ($mode == 0): ?>
					<div class="showmore">
						<a href="/search?search=<?=Html::encode($search)?>&mode=1">
							<button class='.load_more'><?=\Yii::$app->params['locales']["$language"][26]?></button>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/posts_view.php"; ?>
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/pagination.php"; ?>	
			</div>
			<div class="page_menu">
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_posts.php"; ?>
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<?=$form->field($model1, 'text')->textarea(['rows' => 10, 'placeholder' => \Yii::$app->params['locales']["$language"][27]])?>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<label for="postform-img" class="btn" id="img-label"><?=\Yii::$app->params['locales']["$language"][24]?> <a href="#"></a></label>
						<a href="#"><?=$form->field($model1, 'img')->fileInput()?></a>
					</div>
					<div class="page_menu_newpost_bt">
						<button><?=\Yii::$app->params['locales']["$language"][25]?></button>
					</div>
				</div>
			<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>
<?php
$js = <<<JS
var p = 1;
$('body').on('click', '.load_more', function(e) {
	if ($mode == 0 || $mode == 2) {
		$.ajax({
			method: 'GET',
			url: '/search/search-more?offset=50&limit=50&search=$search&p=' + p,
		}).done(function(data) {
			p += 1;
			$('.posts').append(data);
		});
	} else if ($mode == 1) {
		$.ajax({
			method: 'GET',
			url: '/search/search-users?offset=50&limit=50&search=$search&p=' + p,
		}).done(function(data) {
			p += 1;
			$('.posts').append(data);
		});
	}
});
JS;
$this->registerJs($js);
?>
