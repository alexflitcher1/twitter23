<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Редактирование";
?>
<div class="page_body">
    <div class="page_content">
        <div class="page_content_header" style="background: url(/<?=Html::encode($user->bgimage)?>)">
            <div class="page_content_header_ava">
                <img src="/<?=Html::encode($user->img)?>">
            </div>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <div class="newpost_pr">
                <div class="newpost_textarea">
                    <?=$form->field($model, 'text')->textarea(['rows' => 10, 'placeholder' => "Что нового?", 'value' => $post->text])?>
                </div>
                <div class="newpost_bts">
                    <div class="newpost_tw">
                        <label for="postform-img" class="btn" id="img-label">Прикрепить <a href="#"></a></label>
                        <a href="#"><?= $form->field($model, 'img')->fileInput() ?></a>
                    </div>
                    <div class="newpost_bt">
                        <button>Редактировать</button>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php
$js = <<<JS

JS;
$this->registerJs($js);
?>