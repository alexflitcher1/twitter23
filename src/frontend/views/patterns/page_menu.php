<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="page_menu_sticky">
				<div class="profile_names">
					<div class="profile_names_left">
						<img src="/<?=Html::encode($thisuser->img)?>" class="profile_names_ava">
					</div>
					<div class="profile_names_right">
						<div class="profile_names_username"><?=Html::encode($thisuser->username)?></div>
						<div class="profile_names_name"><?=Html::encode($thisuser->name)?></div>
					</div>
				</div>
				<div class="page_menu_bio">
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->about)): ?>
							<span class="page_menu_bio_str_name">О себе</span>
							<?=Html::encode($thisuser->about)?>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<span class="page_menu_bio_str_name">Пол</span>
						<?php if (Html::encode($thisuser->gender) == 'woman'): ?>
							<?=Html::encode('Женский')?>
						<?php elseif (Html::encode($thisuser->gender) == 'man'): ?>
							<?=Html::encode('Мужской')?>
						<?php else: ?>
							<?=Html::encode('Другой')?>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->city)): ?>
							<span class="page_menu_bio_str_name">Город</span>
							<?=Html::encode($thisuser->city)?>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->site)): ?>
							<span class="page_menu_bio_str_name">Сайт</span>
							<a href="https://<?=Html::encode($thisuser->site)?>">
								<?=Html::encode($thisuser->site)?>
							</a>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->telegram)): ?>
							<span class="page_menu_bio_str_name">Telegram</span>
							<a href="https://t.me/<?=Html::encode($thisuser->telegram)?>">
								<?=Html::encode($thisuser->telegram)?>
							</a>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<span class="page_menu_bio_str_name">Дата Регистрации</span>
						<?=Html::encode(date("d.m.Y", strtotime($thisuser->regdate)))?>
					</div>
				</div>
				<div class="fl_menu">
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode($subs)?></div>
						<div class="fl_menu_name"><a href="/subscribers?id=<?=$thisuser->id?>">Подписчики</a></div>
					</div>
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode($suber)?></div>
						<div class="fl_menu_name"><a href="/suber?id=<?=$thisuser->id?>&mode=1">Подписки</a></div>
					</div>
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode(count($posts))?></div>
						<div class="fl_menu_name"><a href="/<?=$thisuser->username?>">Твиты</a></div>
					</div>
				</div>
				<div class="page_menu_nav">
					<a href="/notifications">
						<div class="page_menu_nav_link">Уведомления</div>
					</a>
                    <?php if ($thisuser->id == $user->id): ?>
                        <a href="/settings-profile">
							<div class="page_menu_nav_link">Редактировать</div>
						</a>
                    <?php else: ?>
					    <a href="#">
					    	<div class="page_menu_nav_link subscribe"><?=Html::encode($status)?></div>
					    </a>
                    <?php endif; ?>
				</div>
