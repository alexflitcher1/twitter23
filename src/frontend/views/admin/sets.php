<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Функции";
?>
		<div class="page_body">
			<div class="page_content">
				<div class="page_feed_header">
					<div class="page_feed_header_left">
						Функции
					</div>
					<div class="page_feed_header_right">
						
					</div>
				</div>
				<?php $form = ActiveForm::begin(); ?>
				<div class="set_str">
					<div class="set_name">
						Тех. Обслуживание
					</div>
					<div class="set_input">
                    	<?=$form->field($model, 'tech')->dropDownList([
                            	'1' => 'Открыт',
								'0' => 'Закрыт',
                        ], ['options'=>[$model->tech=>['Selected'=>true]]]);
                    	?>
					</div>
				</div>
				<div class="set_str">
					<div class="set_name">
						Регистрация
					</div>
					<div class="set_input">
						<?=$form->field($model, 'reg')->dropDownList([
                            	'1' => 'Открыта',
								'0' => 'Закрыта',
                        ], ['options'=>[$model->reg=>['Selected'=>true]]]);
                    	?>
					</div>
				</div>
				<div class="set_bt">
                	<?=Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
            	</div>
				<?php ActiveForm::end(); ?>
			</div>
			<div class="page_menu">
				<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_admin.php"; ?>
			</div>
		</div>
	</div>