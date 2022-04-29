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
			<div class="fl_menu">
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($subs)?></div>
					<div class="fl_menu_name"><a href="/subscribers">
						<?=\Yii::$app->params['locales']["$language"][6]?>
					</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($suber)?></div>
					<div class="fl_menu_name"><a href="/suber?mode=1">
						<?=\Yii::$app->params['locales']["$language"][7]?>
					</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($postscount)?></div>
					<div class="fl_menu_name"><a href="/me">
						<?=\Yii::$app->params['locales']["$language"][8]?>
					</a></div>
				</div>
			</div>
			<div class="page_menu_top">
				<div class="page_menu_top_name">
					<?=\Yii::$app->params['locales']["$language"][9]?>
				</div>
				<?php for($i = 0; $i < count($popular); $i++): ?>
					<div class="page_menu_top_a">
						<a href="/search?mode=0&search=<?=Html::encode($popular[$i]->text)?>"><?=Html::encode($popular[$i]->text)?></a>
					</div>
				<?php endfor; ?>
			</div>
			<div class="page_menu_nav">
				<a href="/myfeed">
					<div class="page_menu_nav_link">
						<?=\Yii::$app->params['locales']["$language"][10]?>
					</div>
				</a>
				<a href="/feed">
					<div class="page_menu_nav_link">
						<?=\Yii::$app->params['locales']["$language"][11]?>
					</div>
				</a>
				<a href="/notifications">
					<div class="page_menu_nav_link">
						<?=\Yii::$app->params['locales']["$language"][12]?>
					</div>
				</a>
			</div>