<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Упсс...";
?>
<div class="page_body">
    <div class="page_content">
        <div class="page_content_header" style="background: url(res/404_header.png)"></div>
        <div class="page_404_header">
            <div class="page_feed_header_left">
                Ого, вы нашли страницу Шрёдингера!
            </div>
        </div>
        <div class="page_404">
            Наверно вы перешли не по той ссылке, бывает! Не грустите и посмотрите на рандомный твит:
            <div class="post">
                <div class="post_ava">
                    <img src="/<?=Html::encode($randpost['authordata']->img)?>">
                </div>
                <div class="post_content">
                    <div class="post_content_name">
                    <?=Html::encode($randpost['authordata']->name)?> 
                    <a href="/profile?id=<?=Html::encode($randpost['authordata']->username)?>">
                        @<?=Html::encode($randpost['authordata']->username)?>
                    </a>
                    </div>
                    <div class="post_content_data">
                        <?=Html::encode($randpost['date'])?>
                    </div>
                    <div class="post_content_text">
                        <?=$randpost['text']?>
                    </div>
                    <div class="post_content_nav">
                        <div class="post_content_nav_left">
                            <a href="/me?mode=reply&replyid=<?=Html::encode($randpost['userid'])?>&replypost=<?=Html::encode($randpost['id'])?>">
                                Ответить
                            </a>
                        </div>
                        <div class="post_content_nav_right">
                            <a class="like" data-id="<?=Html::encode($randpost['id'])?>">
                                Нравится (<?=Html::encode($randpost['likes'])?>)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page_menu">
	    <div class="page_menu_sticky">
		    <div class="profile_names">
				<div class="profile_names_left">
					<img src="/<?=Html::encode($user->img)?>" class="profile_names_ava">
				</div>
			    <div class="profile_names_right">
    				<div class="profile_names_username">
	    				@<?=Html::encode($user->username)?>
		    		</div>
			    	<div class="profile_names_name">
						<?=Html::encode($user->name)?>
					</div>
				</div>
    		</div>
	    	<div class="page_menu_bio">
		    	<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">О себе</span>
					<?=Html::encode($user->about)?>
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
		    		<span class="page_menu_bio_str_name">Город</span>
					<?=Html::encode($user->city)?>
				</div>
				<div class="page_menu_bio_str">
			    	<span class="page_menu_bio_str_name">Сайт</span>
				    <a href="<?=Html::encode($user->site)?>">
					    <?=Html::encode($user->site)?>
    				</a>
	    		</div>
		    	<div class="page_menu_bio_str">
					<span class="page_menu_bio_str_name">Telegram</span>
					<a href="https://t.me/<?=Html::encode($user->telegram)?>">
						<?=Html::encode($user->telegram)?>
			    	</a>
    			</div>
	    		<div class="page_menu_bio_str">
		    		<span class="page_menu_bio_str_name">Дата Регистрации</span>
					<?=Html::encode($user->regdate)?>
				</div>
		    </div>
    		<div class="fl_menu">
	    		<div class="fl_menu_block">
		    		<div class="fl_menu_n"><?=Html::encode($subs)?></div>
					<div class="fl_menu_name"><a href="/subscribers">Подписчики</a></div>
				</div>
				<div class="fl_menu_block">
			    	<div class="fl_menu_n"><?=Html::encode($suber)?></div>
				    <div class="fl_menu_name"><a href="/subs?mode=1">Подписки</a></div>
    			</div>
	    		<div class="fl_menu_block">
		    		<div class="fl_menu_n"><?=Html::encode(count($posts))?></div>
					    <div class="fl_menu_name"><a href="/me">Твиты</a></div>
				    </div>
				</div>
    		    <div class="page_menu_nav">
	    			<a href="/notifications">
		    			<div class="page_menu_nav_link">Уведомления</div>
			    	</a>
				    <a href="#">
			            <div class="page_menu_nav_link">Редактировать</div>
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
<?php
$js = <<<JS
$('.like').click(function(e) {
	var postid = $(this).attr("data-id")
	var it = this
	$.ajax({
		method: 'GET', 
		url: '/posts/like?id=' + postid,
	}).done(function(data) {
		it.innerHTML = it.innerHTML.match(/\d+/g) * 1 + data * 1
		it.innerHTML = "Нравится (" + it.innerHTML + ")"
		console.log(it.innerHTML.match(/\d+/g))
	});
});
$("#postform-img").change(function() {
  filename = this.files[0].name
  $("#img-label a").html(filename)
  console.log(filename);
});
JS;
$this->registerJs($js);
?>