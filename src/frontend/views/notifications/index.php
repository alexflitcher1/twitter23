<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Twitter23";
?>


		<div class="page_body">
			<div class="page_content">

				<div class="page_feed_header">
					<div class="page_feed_header_left">
						Уведомления
					</div>
					<div class="page_feed_header_right">
						<?=count($notifications)?>
					</div>
				</div>

				<div class="posts">
					<?php for ($i = 0; $i < count($notifications); $i++): ?>
						<?php if ($notifications[$i]['type'] == 'like'): ?>
							<div class="post">
								<div class="post_ava">
									<img src="<?=$initer[$i]->img?>">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										<?=$initer[$i]->name?> <a href="#">@<?=$initer[$i]->username?></a> оценил ваш твит
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_post">
										<div class="post_ava">
											<img src="<?=$user->img?>">
										</div>
										<div class="post_content_nfpost">
											<div class="post_content_name">
												<?=$user->name?> <a href="#">@<?=$user->username?></a>
											</div>
											<div class="post_content_data">
												<?=$notifications[$i]['moredata']->date?>
											</div>
											<div class="post_content_text">
												<?=$notifications[$i]['moredata']->text?>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($notifications[$i]['type'] == 'reply'): ?>
							<div class="post">
								<div class="post_ava">
									<img src="<?=$initer[$i]->img?>">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> упомянул вас в
										<a href="#">вашем посте</a>
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_post">
										<div class="post_ava">
											<img src="<?=$user->img?>">
										</div>
										<div class="post_content_nfpost">
											<div class="post_content_name">
												<?=$user->name?> <a href="/<?=$user->username?>">@<?=$user->username?></a>
											</div>
											<div class="post_content_data">
												<?=$notifications[$i]->dateadd?>
											</div>
											<div class="post_content_text">
												<a href="/<?=$user->username?>">@<?=$user->username?></a> <?=$notifications[$i]['moredata']->text?>
											</div>
											<div class="post_content_nav_post">
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($notifications[$i]['type'] == 'subscribe'): ?>
							<div class="post">
								<div class="post_ava">
									<img src="<?=$initer[$i]->img?>">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										<?=$initer[$i]->name?> <a href="#">@<?=$initer[$i]->usernmae?></a> подписалась на вас
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_text">
										<a href="/<?=$initer[$i]->usernmae?>">Подписаться в ответ</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
			</div>
			<div class="page_menu"><div class="page_menu_sticky">
			<div class="profile_names">
				<div class="profile_names_left">
					<img src="/<?=Html::encode($user->img)?>" class="profile_names_ava">
				</div>
				<div class="profile_names_right">
					<div class="profile_names_username">@<?=Html::encode($user->username)?></div>
					<div class="profile_names_name"><?=Html::encode($user->name)?></div>
				</div>
			</div>
				</div>
                <div class="fl_menu">
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($subs)?></div>
					<div class="fl_menu_name"><a href="/subscribers">Подписчики</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($suber)?></div>
					<div class="fl_menu_name"><a href="/suber?mode=1">Подписки</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($postscount)?></div>
					<div class="fl_menu_name"><a href="/me">Твиты</a></div>
				</div>
			</div>


                <div class="page_menu_top">
				<div class="page_menu_top_name">
					Популярное
				</div>
				<?php for($i = 0; $i < count($popular); $i++): ?>
					<div class="page_menu_top_a">
						<a href="/search?mode=0&search=<?=Html::encode($popular[$i]->text)?>"><?=Html::encode($popular[$i]->text)?></a>
					</div>
				<?php endfor; ?>
			</div>
			<div class="page_menu_nav">
				<a href="/feed">
					<div class="page_menu_nav_link_active">Мои Новости</div>
				</a>
				<a href="/feed">
					<div class="page_menu_nav_link">Все новости</div>
				</a>
				<a href="/notifications">
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
			</div></div>
		</div>
<?php
$js = <<<JS
for (i = 0; i < $(".post_content_text").length; i++) {
	$(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerText.replace(/(https?:\/\/)?([\w-]{1,32}\.[\w-]{1,32})[^\s@]*/ig, "<a href='$1$2'>$1$2</a>")
}
for (i = 0; i < $(".post_content_text").length; i++) {
	$(".post_content_text")[i].innerHTML = $(".post_content_text")[i].innerHTML.replace(/#(\w*)/ig, "<a href='/search?search=$1'>#$1</a>")
}
$('.posts').on('click', '.like', function(e) {
	var postid = $(this).attr("data-id")
	var it = e.target;
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
if (!window.Clipboard) {
   var pasteCatcher = document.createElement("div");
    
   // Firefox вставляет все изображения в элементы с contenteditable
   pasteCatcher.setAttribute("contenteditable", "");
    
   pasteCatcher.style.display = "none";
   document.body.appendChild(pasteCatcher);
 
   // элемент должен быть в фокусе
   pasteCatcher.focus();
   document.addEventListener("click", function() { pasteCatcher.focus(); });
} 
// добавляем обработчик событию
window.addEventListener("paste", pasteHandler);
 
function pasteHandler(e) {
// если поддерживается event.clipboardData (Chrome)
      if (e.clipboardData) {
      // получаем все содержимое буфера
      var items = e.clipboardData.items;
      if (items) {
         // находим изображение
         for (var i = 0; i < items.length; i++) {
            if (items[i].type.indexOf("image") !== -1) {
               // представляем изображение в виде файла
               var blob = items[i].getAsFile();
			   document.getElementById('postform-img').files = e.clipboardData.files
               // создаем временный урл объекта
               var URLObj = window.URL || window.webkitURL;
               var source = URLObj.createObjectURL(blob);                
               // добавляем картинку в DOM
               //createImage(source);
            }
         }
      }
   // для Firefox проверяем элемент с атрибутом contenteditable
   } else {      
      setTimeout(checkInput, 1);
   }
}
 
function checkInput() {
    var child = pasteCatcher.childNodes[0];   
   pasteCatcher.innerHTML = "";    
   if (child) {
// если пользователь вставил изображение – создаем изображение
      if (child.tagName === "IMG") {
         createImage(child.src);
      }
   }
}
 
function createImage(source) {
   var pastedImage = new Image();
   pastedImage.onload = function() {
	   // вставить в DOM
   }
   pastedImage.src = source;
   
}
JS;
$this->registerJs($js);
?>