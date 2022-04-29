<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$language = \Yii::$app->request->cookies->get("language");
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
							<span class="page_menu_bio_str_name">
								<?=\Yii::$app->params['locales']["$language"][13]?>
							</span>
							<?=Html::encode($thisuser->about)?>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<span class="page_menu_bio_str_name">
							<?=\Yii::$app->params['locales']["$language"][14]?>
						</span>
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
							<span class="page_menu_bio_str_name">
							<?=\Yii::$app->params['locales']["$language"][15]?>
							</span>
							<?=Html::encode($thisuser->city)?>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->site)): ?>
							<span class="page_menu_bio_str_name">
							<?=\Yii::$app->params['locales']["$language"][16]?>
							</span>
							<a href="https://<?=Html::encode($thisuser->site)?>">
								<?=Html::encode($thisuser->site)?>
							</a>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<?php if (strlen($thisuser->telegram)): ?>
							<span class="page_menu_bio_str_name">
							<?=\Yii::$app->params['locales']["$language"][17]?>
							</span>
							<a href="https://t.me/<?=Html::encode($thisuser->telegram)?>">
								<?=Html::encode($thisuser->telegram)?>
							</a>
						<?php endif; ?>
					</div>
					<div class="page_menu_bio_str">
						<span class="page_menu_bio_str_name">
						<?=\Yii::$app->params['locales']["$language"][18]?>
						</span>
						<?=Html::encode(date("d.m.Y", strtotime($thisuser->regdate)))?>
					</div>
				</div>
				<div class="fl_menu">
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode($subs)?></div>
						<div class="fl_menu_name"><a href="/subscribers?id=<?=$thisuser->id?>">
						<?=\Yii::$app->params['locales']["$language"][6]?></a></div>
					</div>
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode($suber)?></div>
						<div class="fl_menu_name"><a href="/suber?id=<?=$thisuser->id?>&mode=1">
						<?=\Yii::$app->params['locales']["$language"][7]?></a></div>
					</div>
					<div class="fl_menu_block">
						<div class="fl_menu_n"><?=Html::encode(count($posts))?></div>
						<div class="fl_menu_name"><a href="/<?=$thisuser->username?>">
						<?=\Yii::$app->params['locales']["$language"][8]?></a></div>
					</div>
				</div>
				<div class="page_menu_nav">
					<a href="/notifications">
						<div class="page_menu_nav_link"><?=\Yii::$app->params['locales']["$language"][12]?></div>
					</a>
                    <?php if ($thisuser->id == $user->id): ?>
                        <a href="/settings-profile">
							<div class="page_menu_nav_link"><?=\Yii::$app->params['locales']["$language"][19]?></div>
						</a>
                    <?php else: ?>
					    <a href="#">
					    	<div class="page_menu_nav_link subscribe"><?=Html::encode($status)?></div>
					    </a>
                    <?php endif; ?>
				</div>
