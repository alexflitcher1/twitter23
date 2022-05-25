<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Подписчики";
?>
   <div class="page_body">
      <div class="page_content">
         <div class="page_feed_header">
            <div class="page_feed_header_left">
               Подписчики
            </div>
            <div class="page_feed_header_right">
               <?=count($datasubs)?>
            </div>
         </div>
         <div class="posts">
			<?php for ($i = 0; $i < count($datasubs); $i++): ?>
            <div class="post_list">
               <div class="post_ava">
                  <img src="<?=$datasubs[$i]->img?>">
               </div>
               <div class="post_content">
                  <div class="post_content_name">
                     <?=$datasubs[$i]->name?> <a href="/<?=$datasubs[$i]->username?>">@<?=$datasubs[$i]->username?></a>
                  </div>
                  <div class="post_content_data">
                     Дата регистрации: <?=Html::encode(date("d.m.Y", strtotime($datasubs[$i]->regdate)))?>
                  </div>
                  <div class="post_content_text">
                     <?=Html::encode($datasubs[$i]->about)?>
                  </div>
               </div>
            </div>
			<?php endfor; ?> 
		</div>
		<div class="pagination">
				<div class="center"><button class="load_more">Показать ещё</button></div>
		</div>
      </div>
      <div class="page_menu">
         <div class="page_menu_sticky">
            <div class="profile_names">
               <div class="profile_names_left">
                  <img src="<?=$user->img?>" class="profile_names_ava">
               </div>
               <div class="profile_names_right">
                  <div class="profile_names_username"><?=$user->username?></div>
                  <div class="profile_names_name"><?=$user->name?></div>
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
            <div class="page_menu_top">
               <div class="page_menu_top_name">
                  Популярное
               </div>
			   <?php for ($i = 0; $i < count($popular); $i++): ?>
               <div class="page_menu_top_a">
                  <a href="/search?search=<?=$popular[$i]->text?>"><?=$popular[$i]->text?></a>
               </div>
			   <?php endfor; ?>
               
            </div>
            <div class="page_menu_nav">
               <a href="#">
                  <div class="page_menu_nav_link">Мои Новости</div>
               </a>
               <a href="#">
                  <div class="page_menu_nav_link">Все новости</div>
               </a>
               <a href="#">
                  <div class="page_menu_nav_link">Уведомления</div>
               </a>
            </div>
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<?=$form->field($model, 'text')->textarea(['rows' => 10, 'placeholder' => "Что нового?"])?>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<label for="postform-img" class="btn" id="img-label">Прикрепить <a href="#"></a></label>
						<a href="#"><?=$form->field($model, 'img')->fileInput()?></a>
					</div>
					<div class="page_menu_newpost_bt">
						<button>Опубликовать</button>
					</div>
				</div>
			<?php ActiveForm::end() ?>
         </div>
      </div>
   </div>
</div>
<?php
$js = <<<JS
var p = 1;
$('body').on('click', '.load_more', function(e) {
	$.ajax({
		method: 'GET',
		url: '/user/more-subs?offset=50&limit=50&id=' + $id + '&p=' + p + '&mode=' + $mode,
	}).done(function(data) {
		p += 1;
		$('.posts').append(data);
	});
});
JS;
$this->registerJs($js);
?>