<?php $language = \Yii::$app->request->cookies->get("language"); ?>
<div class="pagination">
	<div class="center"><button class="load_more"><?=\Yii::$app->params['locales']["$language"][26]?></button></div>
</div>