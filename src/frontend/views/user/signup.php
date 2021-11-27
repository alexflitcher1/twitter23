<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Регистрация";
?>
<div class="page_body_login">
    <div class="page_body_login_left">
        <div class="page_feed_header">
            <div class="page_feed_header_left">
                Регистрация
            </div>
        </div>
        <?php $form = ActiveForm::begin(); ?>
            <div class="set_str">
                <div class="set_name">
                    Язык / Language
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'language')->dropDownList([
                            '1' => 'Русский',
                            '2' => 'Английский',
                        ]);
                    ?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Электрическая почта
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'email')?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Пароль
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'password')->passwordInput()?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Повторите пароль
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'repass')->passwordInput()?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Имя
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'name')?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Имя пользователя <span>@username</span>
                </div>
                <div class="set_input">
                    <?= $form->field($model, 'username') ?>
                </div>
            </div>
            <div class="set_str">
                <div class="set_name">
                    Пол / Гендер
                </div>
                <div class="set_input">
                    <?=$form->field($model, 'gender')->dropDownList([
                            '2' => 'Женский',
                            '1' => 'Мужской',
                            '3' => 'Другой',
                        ]);
                    ?>
                </div>
            </div>
            <div class="set_bt">
                <?=Html::submitButton('Регистрация', ['class' => 'btn btn-success'])?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="page_body_login_right">
        <div class="page_body_login_right_name">Пожалуйста, войдите</div>
        <div class="page_body_login_right_form">
            <div class="page_body_login_right_str">
                <div class="page_body_login_right_str_name">
                    Имя пользователя
                </div>
                <div class="page_body_login_right_str_input">
                    <input type="" name="">
                </div>
            </div>
            <div class="page_body_login_right_str">
                <div class="page_body_login_right_str_name">
                    Пароль
                </div>
                <div class="page_body_login_right_str_input">
                    <input type="" name="">
                </div>
            </div>
            <div class="page_body_login_right_bt">
                <button>Войти</button>
            </div>
        </div>
    </div>
</div>
