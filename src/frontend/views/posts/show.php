<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Твит";
?>
<pre>
<?php print_r($post) ?>
<?php print_r($author) ?>
<?php print_r($user) ?>
</pre>
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