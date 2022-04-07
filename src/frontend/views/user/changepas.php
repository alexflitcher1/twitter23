<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Ваши настройки";
?>
	<div class="page_body">
			<div class="page_content">
				<div class="page_feed_header">
					<div class="page_feed_header_left">
						Сменить пароль
					</div>
				</div>
				<?php $form = ActiveForm::begin() ?>
				<div class="set_str">
					<div class="set_name">
						Введите старый пароль
					</div>
					<div class="set_input">
                        <?=$form->field($model, 'oldpas')?>
                        <?=$error?>
					</div>
				</div>
				<div class="set_str">
					<div class="set_name">
						Введите новый пароль
					</div>
					<div class="set_input">
                        <?=$form->field($model, 'newpas')?>
					</div>
				</div>
                <div class="set_str">
					<div class="set_name">
						Повторите новый пароль
					</div>
					<div class="set_input">
                        <?=$form->field($model, 'retnpas')?>
					</div>
				</div>
				<div class="set_bt">
					<button>Сохранить</button>
				</div>
				<?php ActiveForm::end() ?>
			</div>
			<div class="page_menu">
			<!--- Open posts pattern -->
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_settings.php"; ?>
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<?=$form->field($model1, 'text')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<label for="postform-img" class="btn" id="img-label">Прикрепить <a href="#"></a></label>
						<a href="#"><?=$form->field($model1, 'img')->fileInput()?></a>
					</div>
					<div class="page_menu_newpost_bt">
							<button>Опубликовать</button>
						</div>
					</div>
				</div>
			<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
		</div>
	</div>