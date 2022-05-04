<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$language = \Yii::$app->request->cookies->get("language");
$this->title = \Yii::$app->params['locales']["$language"][36];
?>
<div class="page_body">
	<div class="page_content">
		<div class="page_feed_header">
			<div class="page_feed_header_left">
				<?=\Yii::$app->params['locales']["$language"][36]?>
			</div>
		</div>
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][37]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'name')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][38]?> <span>@username</span>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'username')?>
					<?php if ($error): ?>
						<div class="help-block"><?=$error?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][39]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'gender')->dropDownList([
							'woman' => 'Женский',
							'man' => 'Мужской',
							'other' => 'Другой',
						], ['options'=>[$model->gender=>['Selected'=>true]]]);
					?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][40]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'about')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][41]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'city')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					<?=\Yii::$app->params['locales']["$language"][42]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'site')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
				<?=\Yii::$app->params['locales']["$language"][43]?>
				</div>
				<div class="set_input">
					<?=$form->field($model, 'telegram')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
				<?=\Yii::$app->params['locales']["$language"][44]?>
				</div>
				<div class="set_input">
					<div class="set_bt_input">
						<a href="#">
							<?=$form->field($model, 'img')->fileInput()?>
						</a>
					</div>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
				<?=\Yii::$app->params['locales']["$language"][45]?>
				</div>
				<div class="set_input">
					<div class="set_bt_input">
						<a href="#">
							<?=$form->field($model, 'bgimage')->fileInput()?>
						</a>
					</div>
				</div>
			</div>
			<div class="set_bt">
				<button><?=\Yii::$app->params['locales']["$language"][46]?></button>
			</div>
		<?php ActiveForm::end() ?>
	</div>
	<div class="page_menu">
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_settings.php"; ?>
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<?=$form->field($model1, 'text')->textarea(['rows' => 10, 'placeholder' => \Yii::$app->params['locales']["$language"][26]])?>
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
				</div>
			<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
<?php
$js = <<<JS

JS;
$this->registerJS($js);
?>