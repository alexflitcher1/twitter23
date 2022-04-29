<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$language = \Yii::$app->request->cookies->get("language");
?>
<div class="page_menu_sticky">
			<div class="profile_names">
				<div class="profile_names_left">
					<img src="/<?=Html::encode($user->img)?>" class="profile_names_ava">
				</div>
				<div class="profile_names_right">
					<div class="profile_names_username"><?=Html::encode($user->username)?></div>
					<div class="profile_names_name"><?=Html::encode($user->name)?></div>
				</div>
			</div>
			<div class="page_menu_bio">
				<div class="page_menu_bio_str">
					<?php if (strlen($user->about)): ?>
						<span class="page_menu_bio_str_name">
						<?=\Yii::$app->params['locales']["$language"][13]?>
						</span>
						<?=Html::encode($user->about)?>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">
					<?=\Yii::$app->params['locales']["$language"][14]?>
					</span>
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
						<span class="page_menu_bio_str_name">
						<?=\Yii::$app->params['locales']["$language"][15]?>
						</span>
						<?=Html::encode($user->city)?>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<?php if (strlen($user->site)): ?>
						<span class="page_menu_bio_str_name">
						<?=\Yii::$app->params['locales']["$language"][16]?>
						</span>
						<a href="https://<?=Html::encode($user->site)?>">
							<?=Html::encode($user->site)?>
						</a>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<?php if (strlen($user->telegram)): ?>
						<span class="page_menu_bio_str_name">
						<?=\Yii::$app->params['locales']["$language"][17]?>
						</span>
						<a href="https://t.me/<?=Html::encode($user->telegram)?>">
							<?=Html::encode($user->telegram)?>
						</a>
					<?php endif; ?>
				</div>
				<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">
					<?=\Yii::$app->params['locales']["$language"][18]?>
					</span>
					<?=Html::encode(date("d.m.Y", strtotime($user->regdate)))?>
				</div>
			</div>
			<div class="fl_menu">
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$subs?></div>
					<div class="fl_menu_name"><a href="/subscribers">
					<?=\Yii::$app->params['locales']["$language"][6]?>
					</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=$suber?></div>
					<div class="fl_menu_name"><a href="/suber?mode=1">
					<?=\Yii::$app->params['locales']["$language"][7]?>
					</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=count($posts)?></div>
					<div class="fl_menu_name"><a href="/me">
					<?=\Yii::$app->params['locales']["$language"][8]?>
					</a></div>
				</div>
			</div>
			<div class="page_menu_nav">
				<a href="/settings">
					<div class="page_menu_nav_link">
					<?=\Yii::$app->params['locales']["$language"][35]?>
					</div>
				</a>
				<a href="/me">
					<div class="page_menu_nav_link_active">
					<?=\Yii::$app->params['locales']["$language"][36]?>
					</div>
				</a>
			</div>