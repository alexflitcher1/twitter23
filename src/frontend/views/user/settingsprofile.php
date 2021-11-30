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
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
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
					<?=$form->field($model, 'username')?>
					<?php if ($error): ?>
						<div class="help-block"><?=$error?></div>
					<?php endif; ?>
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
			<div class="set_str">
				<div class="set_name">
					О себе
				</div>
				<div class="set_input">
					<?=$form->field($model, 'about')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					Город
				</div>
				<div class="set_input">
					<?=$form->field($model, 'city')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					Сайт
				</div>
				<div class="set_input">
					<?=$form->field($model, 'site')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					Telegram
				</div>
				<div class="set_input">
					<?=$form->field($model, 'telegram')?>
				</div>
			</div>
			<div class="set_str">
				<div class="set_name">
					Аватар
				</div>
				<div class="set_input">
					<div class="set_bt_input">
						<a href="#">
							<?=$form->field($model, 'img')->fileInput()?>
						</a>
					</div>
				</div>
			</div>
			<div class="set_bt">
				<button>Сохранить</button>
			</div>
		<?php ActiveForm::end() ?>
	</div>
	<div class="page_menu">
		<div class="page_menu_sticky">
			<div class="profile_names">
				<div class="profile_names_left">
					<img src="/<?=Html::encode($user->img)?>" class="profile_names_ava">
				</div>
				<div class="profile_names_right">
					<div class="profile_names_username">@<?=Html::encode($user->username)?></div>
					<div class="profile_names_name"><?=Html::encode($user->name)?></div>
				</div>
			</div>
			<div class="page_menu_bio">
				<div class="page_menu_bio_str">
					<?php if (strlen($user->about)): ?>
						<span class="page_menu_bio_str_name">О себе</span>
						<?=Html::encode($user->about)?>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">Пол</span>
					<?php if (Html::encode($user->gender) == 'woman'): ?>
						<?=Html::encode('Женский')?>
					<?php elseif (Html::encode($user->gender) == 'man'): ?>
						<?=Html::encode('Мужской')?>
					<?php else: ?>
						<?=Html::encode('Другой')?>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<?php if (strlen($user->city)): ?>
						<span class="page_menu_bio_str_name">Город</span>
						<?=Html::encode($user->city)?>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<?php if (strlen($user->site)): ?>
						<span class="page_menu_bio_str_name">Сайт</span>
						<a href="<?=Html::encode($user->site)?>">
							<?=Html::encode($user->site)?>
						</a>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<?php if (strlen($user->telegram)): ?>
						<span class="page_menu_bio_str_name">Telegram</span>
						<a href="https://t.me/<?=Html::encode($user->telegram)?>">
							<?=Html::encode($user->telegram)?>
						</a>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">Дата Регистрации</span>
					<?=Html::encode(date("d.m.Y", strtotime($user->regdate)))?>
				</div>
			</div>
			<div class="fl_menu">
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$subs?></div>
					<div class="fl_menu_name"><a href="#">Подписчики</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$suber?></div>
					<div class="fl_menu_name"><a href="#">Подписки</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$posts?></div>
					<div class="fl_menu_name"><a href="#">Твиты</a></div>
				</div>
			</div>
			<div class="page_menu_nav">
				<a href="/settings">
					<div class="page_menu_nav_link">Основное</div>
				</a>
				<a href="/me">
					<div class="page_menu_nav_link_active">Профиль</div>
				</a>
			</div>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<textarea placeholder="Что нового?"></textarea>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<a href="#">Прикрепить</a>
					</div>
					<div class="page_menu_newpost_bt">
							<button>Опубликовать</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>