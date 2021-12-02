<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Поиск";
?>
<div class="page_body">
	<div class="page_content">
		<div class="page_feed_header">
			<div class="page_feed_header_left">
				Поиск
			</div>
			<div class="page_feed_header_right"></div>
		</div>
		<?php $form = ActiveForm::begin(); ?>
			<div class="search">
				<div class="search_input">
					<?=$form->field($model, 'text')?>
				</div>
				<div class="search_choose"></div>
				<div class="search_bt">
					<?=Html::submitButton('Поиск', ['class' => 'btn btn-success'])?>
				</div>
			</div>
		<?php ActiveForm::end(); ?>
		<div class="posts">
			<?php if (($mode == 1 || $mode == 0) && $page == 0 && isset($users) && count($users)): ?>
				<?php for ($i = 0; $i < count($users); $i++): ?>
					<div class="post">
						<div class="post_ava">
							<img src="/<?=Html::encode($users[$i]->img)?>">
						</div>
						<div class="post_content">
							<div class="post_content_name">
								<?=Html::encode($users[$i]->name)?>
								<a href="/profile?id=<?=Html::encode($users[$i]->username)?>">
									@<?=Html::encode($users[$i]->username)?>
								</a>
							</div>
							<div class="post_content_data">
								<?=Html::encode($users[$i]->regdate)?>
							</div>
							<div class="post_content_text">
								<?=Html::encode($users[$i]->about)?>
							</div>
							<div class="post_content_nav">
								<div class="post_content_nav_left"></div>
								<div class="post_content_nav_right"></div>
							</div>
						</div>
					</div>
				<?php endfor; ?>
				<?php if ($mode == 0): ?>
					<div class="showmore">
						<a href="/search?search=<?=Html::encode($search)?>&mode=1">
							<button class='.load_more'>Показать ещё</button>
						</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($mode == 2 || $mode == 0) ?>
				<?php for ($i = 0; $i < count($posts); $i++): ?>
					<?php if (empty($posts[$i]['replies']) && $posts[$i]['replyid'] == 0): ?>
						<div class="post">
							<div class="post_ava">
								<img src="/<?=Html::encode($posts[$i]['authordata']->img)?>">
							</div>
							<div class="post_content">
								<div class="post_content_name">
									<?=Html::encode($posts[$i]['authordata']->name)?>
									<a href="/profile?id=<?=Html::encode($posts[$i]['authordata']->username)?>">
										@<?=Html::encode($posts[$i]['authordata']->username)?>
									</a>
								</div>
								<div class="post_content_data">
									<?=Html::encode($posts[$i]['date'])?>
								</div>
								<div class="post_content_text">
									<?=$posts[$i]['text']?>
								</div>
								<?php if ($posts[$i]['img']): ?>
									<div class="post_content_img">
										<img src="<?=Html::encode($posts[$i]['img'])?>">
									</div>
								<?php endif; ?>
								<div class="post_content_nav">
									<div class="post_content_nav_left">
										<a href="/me?mode=reply&replypost=<?=Html::encode($posts[$i]['id'])?>">
											Ответить (0)
										</a>
									</div>
									<div class="post_content_nav_right">
										<a class="like" data-id="<?=Html::encode($posts[$i]['id'])?>">
											Нравится (<?=Html::encode($posts[$i]['likes'])?>)
										</a>
									</div>
								</div>
							</div>
						</div>
					<?php elseif (!empty($posts[$i]['replies'])): ?>
						<div class="post_replay">
							<div class="post_replay_top">
								<div class="post_ava">
									<img src="/<?=Html::encode($posts[$i]['authordata']->img)?>">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										<?=Html::encode($posts[$i]['authordata']->name)?>
										<a href="/profile?id=<?=Html::encode($posts[$i]['authordata']->username)?>">
											@<?=Html::encode($posts[$i]['authordata']->username)?>
										</a>
									</div>
									<div class="post_content_data">
										<?=Html::encode($posts[$i]['date'])?>
									</div>
									<div class="post_content_text">
										<?=$posts[$i]['text']?>
									</div>
									<?php if ($posts[$i]['img']): ?>
										<div class="post_content_img">
											<img src="<?=Html::encode($posts[$i]['img'])?>">
										</div>
									<?php endif; ?>
									<div class="post_content_nav">
										<div class="post_content_nav_left">
											<a href="/me?mode=reply&replyid=<?=Html::encode($posts[$i]['userid'])?>&replypost=<?=Html::encode($posts[$i]['id'])?>">
												Ответить (<?=count($posts[$i]['replies'])?>)
											</a>
										</div>
										<div class="post_content_nav_right">
											<a class="like" data-id="<?=Html::encode($posts[$i]['id'])?>">
												Нравится (<?=Html::encode($posts[$i]['likes'])?>)
											</a>
										</div>
									</div>
								</div>
							</div>
							<?php for ($j = 0; $j < count($posts[$i]['replies']); $j++): ?>
								<div class="post_replay_bl"></div>
									<div class="post_replay_bottom">
										<div class="post_ava">
											<img src="/<?=Html::encode($repliers[$i][$j]->img)?>">
										</div>
										<div class="post_content">
											<div class="post_content_name">
												<?=Html::encode($repliers[$i][$j]->name)?> 
												<a href="/profile?id=<?=Html::encode($repliers[$i][$j]->username)?>">
													@<?=Html::encode($repliers[$i][$j]->username)?>
												</a>
											</div>
											<div class="post_content_data">
												<?=Html::encode($posts[$i]['replies'][$j]->date)?>
											</div>
											<div class="post_content_text">
												<a href="#">
													@<?=Html::encode($posts[$i]['authordata']->username)?>
												</a> 
												<?=$posts[$i]['replies'][$j]->text?>
											</div>
											<?php if ($posts[$i]['replies'][$j]->img != null): ?>
												<div class="post_content_img">
													<img src="<?=Html::encode($posts[$i]['replies'][$j]->img)?>">
												</div>
											<?php endif; ?>
											<div class="post_content_nav">
												<div class="post_content_nav_left">
													<?php if ($posts[$i]['replies'][$j]->userid == $user->id): ?>
														<a class="delete" data-id="<?=Html::encode($posts[$i]['replies'][$j]->id)?>">
															Удалить
														</a> 
														<a href="/edit?id=<?=Html::encode($posts[$i]['replies'][$j]->id)?>" class="edit">
															Редактировать
														</a>
													<?php endif; ?>
													<a href="#">Ответить</a>
												</div>
												<div class="post_content_nav_right">
													<a class="like" data-id=<?=Html::encode($posts[$i]['replies'][$j]->id)?>>
														Нравится (<?=$posts[$i]['replies'][$j]->likes?>)
													</a>
												</div>
											</div>
										</div>
									</div>
								<?php endfor; ?>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
				<div class="pagination">
					<div class="center"><button class="load_more">Показать ещё</button></div>
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
			<div class="fl_menu">
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($subs)?></div>
					<div class="fl_menu_name"><a href="#">Подписчики</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($subs)?></div>
					<div class="fl_menu_name"><a href="#">Подписки</a></div>
				</div>
				<div class="fl_menu_block">
					<div class="fl_menu_n"><?=Html::encode($postscount)?></div>
					<div class="fl_menu_name"><a href="#">Твиты</a></div>
				</div>
			</div>
			<div class="page_menu_top">
				<div class="page_menu_top_name">
					Популярное
				</div>
				<?php for($i = 0; $i < count($popular); $i++): ?>
					<div class="page_menu_top_a">
						<a href="/search?mode=0&search=<?=Html::encode($popular[$i]->text)?>">
							<?=Html::encode($popular[$i]->text)?>
						</a>
					</div>
				<?php endfor; ?>
			</div>
			<div class="page_menu_nav">
				<a href="#">
					<div class="page_menu_nav_link">Мои Новости</div>
				</a>
				<a href="/feed">
					<div class="page_menu_nav_link">Все новости</div>
				</a>
				<a href="/notifications">
					<div class="page_menu_nav_link">Уведомления</div>
				</a>
			</div>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<textarea placeholder="Что нового?"></textarea>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<a href="#">Прикрепить</a>
					</div>
					<div class="page_menu_newpost_bt">
						<button>Опубликовать</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js = <<<JS
var p = 1;
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
$('.posts').on('click', '.delete', function(e) {
	var postid = $(this).attr("data-id")
	var it = e.target;
	$.ajax({
		method: 'GET', 
		url: '/posts/delete?id=' + postid,
	}).done(function(data) {
		location.reload();
	});
});
$('body').on('click', '.load_more', function(e) {
	if ($mode == 0 || $mode == 2) {
		$.ajax({
			method: 'GET',
			url: '/search/search-more?offset=50&limit=50&search=$search&p=' + p,
		}).done(function(data) {
			p += 1;
			$('.posts').append(data);
		});
	} else if ($mode == 1) {
		$.ajax({
			method: 'GET',
			url: '/search/search-users?offset=50&limit=50&search=$search&p=' + p,
		}).done(function(data) {
			p += 1;
			$('.posts').append(data);
		});
	}
});
JS;
$this->registerJs($js);
?>
