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
<div class="loyaut">
<div class="header">
	<div class="logo">
		<a href="/feed">Twitter23</a>
	</div>
	<div class="nav">
		<a href="/feed">Новости</a>
		<a href="/me">Профиль</a>
		<a href="/notifications">Уведомления</a>
		<a href="/search">Поиск</a>
		<a href="/settings-profile">Настройки</a>
		<a href="/user/quit">Выйти</a>
	</div>
</div>
<?=$content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
<script>
    document.getElementsByTagName('html')[0].style.display = "block"
</script>