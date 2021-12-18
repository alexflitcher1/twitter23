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
								'1' => 'Русский',
								'2' => 'English',
							]);
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
								'twitter23modern' => 'Twitter23Modern',
								'none' => 'None',
								'red' => 'Red',
								'blue' => 'Blue',
								'green' => 'Green',
								'brown' => 'Brown',
								'orange' => 'Orange',
								'pink' => 'Pink',
								'yellow' => 'Yellow',
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
					<div class="fl_menu_name"><a href="/subscribers">Подписчики</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$suber?></div>
					<div class="fl_menu_name"><a href="/suber?mode=1">Подписки</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$posts?></div>
					<div class="fl_menu_name"><a href="/me">Твиты</a></div>
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