<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Ваши настройки";
?>
	<div class="page_body">
			<div class="page_content">
				<div class="page_feed_header">
					<div class="page_feed_header_left">
						Настройки
					</div>
				</div>
				<?php $form = ActiveForm::begin() ?>
				<div class="set_str">
					<div class="set_name">
						Язык / Language
					</div>
					<div class="set_input">
							<?=$form->field($model, 'lang')->dropDownList([
								'russian' => 'Русский',
								'english' => 'English',
							], ['options'=>[$model->lang=>['Selected'=>true]]]);
						?>
					</div>
				</div>
				<div class="set_str">
					<div class="set_name">
						Тема оформления
					</div>
					<div class="set_input">
						<?=$form->field($model, 'theme')->dropDownList([
								'default' => 'По умолчанию',
								'default-dark' => 'По умолчанию (тёмная)',
								'twitter23modern' => 'Twitter23Modern',
								'none' => 'None',
							], ['options'=>[$model->theme=>['Selected'=>true]]]);
						?>
					</div>
				</div>
				<div class="set_str">
					<div class="set_name">
						Цветовая схема
					</div>
					<div class="set_input">
						<?=$form->field($model, 'color')->dropDownList([
								'default-red' => 'Red',
								'default-blue' => 'Blue',
								'default-green' => 'Green',
								'default-brown' => 'Brown',
								'default-orange' => 'Orange',
								'default-pink' => 'Pink',
								'default-yellow' => 'Yellow',
							]);
						?>
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
<?php
$js = <<<JS
$('#mainsettings-color').html('')
$.ajax({
	url: "/site/get-themes",
	method: 'get',
}).done(function(data) {
	data = JSON.parse(data)
	value = $('#mainsettings-theme').val()
	for (i = 0; i < data[value].length; i++) {
		if (data[value][i] != "none")
			$('#mainsettings-color').append($('<option>', {
   				value: value + "-" + data[value][i],
   				text: data[value][i],
			}));
		else
			$('#mainsettings-color').append($('<option>', {
   				value: value,
   				text: data[value][i],
			}));
	}
})
$('body').on('change', '#mainsettings-theme', function(e) { 
	$('#mainsettings-color').html('')
	$.ajax({
		url: "/site/get-themes",
		method: 'get',
	}).done(function(data) {
		data = JSON.parse(data)
		value = $('#mainsettings-theme').val()
		for (i = 0; i < data[value].length; i++) {
			if (data[value][i] != "none")
				$('#mainsettings-color').append($('<option>', {
   					value: value + "-" + data[value][i],
	   				text: data[value][i],
				}));
			else
				$('#mainsettings-color').append($('<option>', {
   					value: value,
	   				text: data[value][i],
				}));
		}
	})
})
JS;
$this->registerJs($js);
?>