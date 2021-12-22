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
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> оценил(а) 
										<a href="#">ваш твит</a>
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
												<?=$user->name?> <a href="/<?=$initer[$i]->username?>">@<?=$user->username?></a>
											</div>
											<div class="post_content_data">
												<?php if (isset($notifications[$i]['moredata'])): ?>
													<?=$notifications[$i]['moredata']->date?>
												<?php endif; ?>
											</div>
											<div class="post_content_text">
												<?php if (isset($notifications[$i]['moredata']->text)): ?>
													<?=$notifications[$i]['moredata']->text?>
												<?php else: ?>
													<b>Пост удалён</b>
												<?php endif; ?>
											</div>
											<?php if (isset($notifications[$i]['moredata']->img)): ?>
												<?php if ($notifications[$i]['moredata']->img != null): ?>
													<div class="post_content_img">
														<img src="<?=Html::encode($notifications[$i]['moredata']->img)?>">
													</div>
												<?php endif; ?>
											<?php endif; ?>
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
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> ответил на 
										<a href="#">ваш пост</a>
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
												<?php if (isset($notifications[$i]['moredata'])): ?>
													<?=$notifications[$i]['moredata']->date?>
												<?php endif; ?>
											</div>
											<div class="post_content_text">
												<?php if (isset($notifications[$i]['moredata']->text)): ?>
													<?=$notifications[$i]['moredata']->text?>
												<?php else: ?>
													<b>Пост удалён</b>
												<?php endif; ?>
											</div>
											<?php if (isset($notifications[$i]['moredata']->img)): ?>
												<?php if ($notifications[$i]['moredata']->img != null): ?>
													<div class="post_content_img">
														<img src="<?=Html::encode($notifications[$i]['moredata']->img)?>">
													</div>
												<?php endif; ?>
											<?php endif; ?>
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
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> подписалась на вас
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_text">
										<a href="/<?=$initer[$i]->username?>">Подписаться в ответ</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($notifications[$i]['type'] == 'tag'): ?>
							<div class="post">
								<div class="post_ava">
									<img src="<?=$initer[$i]->img?>">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> упомянул вас
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_post" style="margin-left:-10px">
										<div class="post_content_nfpost">
											<div class="post_content_text">
												<?php if (isset($notifications[$i]['moredata']->text)): ?>
													<?=$notifications[$i]['moredata']->text?>
												<?php else: ?>
													<b>Пост удалён</b>
												<?php endif; ?>
											</div>
											<?php if (isset($notifications[$i]['moredata']->img)): ?>
												<?php if ($notifications[$i]['moredata']->img != null): ?>
													<div class="post_content_img">
														<img src="<?=Html::encode($notifications[$i]['moredata']->img)?>">
													</div>
												<?php endif; ?>
											<?php endif; ?>
											<div class="post_content_nav_post">
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
						<?php if ($notifications[$i]['type'] == 'system'): ?>
							<div class="post">
								<div class="post_ava">
									<img src="/res/favicon2.png">
								</div>
								<div class="post_content">
									<div class="post_content_name">
										Системное сообщение
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_text">
										<?=$notifications[$i]['moredata']?>
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
					<div class="profile_names_username"><?=Html::encode($user->username)?></div>
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

JS;
$this->registerJs($js);
?>