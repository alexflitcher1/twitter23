<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\DefaultAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use frontend\components\ThemeWidget;
ThemeWidget::widget(['page' => $this]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="/res/favicon2.png" type="image/png">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<div class="top">
	Наверх
</div>
<div class="loyaut">
<div class="header">
	<div class="logo">
		<a href="/feed">Twitter23</a>
	</div>
	<div class="nav">
		<a href="/feed">
			<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<?php $language = \Yii::$app->request->cookies->get("language"); ?>
			<?=\Yii::$app->params['locales']["$language"][0]?>
			<?php else: ?>
			<?=\Yii::$app->params['locales']["russian"][0]?>
			<?php endif; ?>
		</a>
		<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<a href="/<?=Yii::$app->request->cookies->get("auth")?>">
				<?=\Yii::$app->params['locales']["$language"][1]?>
			</a>
		<?php else: ?>
			<a href="/me"><?=\Yii::$app->params['locales']["russian"][1]?></a>
		<?php endif; ?>
		<a href="/notifications">
			<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<?=\Yii::$app->params['locales']["$language"][2]?>
			<?php else: ?>
			<?=\Yii::$app->params['locales']["russian"][2]?>
			<?php endif; ?>
		</a>
		<a href="/search">
			<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<?=\Yii::$app->params['locales']["$language"][3]?>
			<?php else: ?>
			<?=\Yii::$app->params['locales']["russian"][3]?>
			<?php endif; ?>
		</a>
		<a href="/settings-profile">
			<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<?=\Yii::$app->params['locales']["$language"][4]?>
			<?php else: ?>
			<?=\Yii::$app->params['locales']["russian"][4]?>
			<?php endif; ?>
		</a>
		<a href="/user/quit">
			<?php if ((Yii::$app->request->cookies->get("auth"))): ?>
			<?=\Yii::$app->params['locales']["$language"][5]?>
			<?php else: ?>
			<?=\Yii::$app->params['locales']["russian"][5]?>
			<?php endif; ?>
		</a>
	</div>
</div>
<?=$content?>
<div class="footer"> 

<div class="footer_span">Twitter23 2022</div> 

<div class="footer_links"> О сайте Контакты Помощь Telegram-Канал Telegram-Чат GitHub</div> 
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
<script>
    document.getElementsByTagName('html')[0].style.display = "block"
</script>