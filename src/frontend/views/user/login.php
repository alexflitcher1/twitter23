<!-- <div class="loyaut">
<div class="header">
<div class="logo">
<a href="#">Twitter23</a>
</div>
<div class="nav">
<a href="#">Русский</a>
<a href="#">English</a>
</div>
</div> -->
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Авторизация";
?>
<div class="page_body_login">
    <div class="page_body_login_left">
        <div class="page_body_login_name">Что такое Twitter23?</div>
        <div class="page_body_login_img">
            <img src="/res/tour_2.gif">
        </div>
        <div class="page_body_login_text">
            Twitter23 - Это пародия на Twitter 2009 года. Этот сервис позволяет друзьям, родственникам и коллегам общаться и оставаться на связи, обмениваясь быстрыми и частыми твитами отвечая на один простой вопрос: <span class="page_body_login_text_bold">Что произошло нового?</span>
        </div>
        <div class="page_body_login_bt">
            <a href="/signup">Зарегистрироваться</a>
        </div>
    </div>
    <?php $form = ActiveForm::begin(); ?>
        <div class="page_body_login_right">
            <div class="page_body_login_right_name">
                Пожалуйста, войдите
            </div>
            <div class="page_body_login_right_form">
                <div class="page_body_login_right_str">
                    <div class="page_body_login_right_str_name">
                        Имя пользователя
                    </div>
                    <div class="page_body_login_right_str_input">
                        <?=$form->field($model, 'username')?>
                    </div>
                </div>
                <div class="page_body_login_right_str">
                    <div class="page_body_login_right_str_name">
                        Пароль
                    </div>
                    <div class="page_body_login_right_str_input">
                        <?=$form->field($model, 'password')->passwordInput()?>
                        <?php if (isset($error)): ?>
                            <div class="help-block"><?=$error?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="page_body_login_right_bt">
                    <?=Html::submitButton('Войти', ['class' => 'btn btn-success'])?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<!-- </div> -->
