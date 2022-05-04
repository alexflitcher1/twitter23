<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Twitter23";
$language = \Yii::$app->request->cookies->get("language");
?>
		<div class="page_body">
			<div class="page_content">

				<div class="page_feed_header">
					<div class="page_feed_header_left">
						<?=\Yii::$app->params['locales']["$language"][2]?>
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
										<?php if (isset($initer[$i]->id) && isset($notifications[$i]['moredata']->id)): ?>
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a>
										<a href="/show?userid=<?=$initer[$i]->id?>&postid=<?=$notifications[$i]['moredata']->id?>">
										<?=\Yii::$app->params['locales']["$language"][28]?> </a>
										<?php endif; ?>
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
										<?php if (isset($initer[$i]->id) && isset($notifications[$i]['moredata']->id)): ?>
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a>
										<a href="/show?userid=<?=$initer[$i]->id?>&postid=<?=$notifications[$i]['moredata']->id?>">
										<?=\Yii::$app->params['locales']["$language"][32]?></a>
										<?php endif; ?>
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
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> <?=\Yii::$app->params['locales']["$language"][29]?>
									</div>
									<div class="post_content_data">
										<?=$notifications[$i]->dateadd?>
									</div>
									<div class="post_content_text">
										<a href="/<?=$initer[$i]->username?>"><?=\Yii::$app->params['locales']["$language"][31]?></a>
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
										<?=$initer[$i]->name?> <a href="/<?=$initer[$i]->username?>">@<?=$initer[$i]->username?></a> <?=\Yii::$app->params['locales']["$language"][30]?>
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
			<div class="page_menu">
			<?php require_once \Yii::$app->params['pathToPatterns'] . "/page_menu_posts.php"; ?>
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<div class="page_menu_newpost">
				<div class="page_menu_newpost_textarea">
					<?=$form->field($model, 'text')->textarea(['rows' => 10, 'placeholder' => \Yii::$app->params['locales']["$language"][27]])?>
				</div>
				<div class="page_menu_newpost_bts">
					<div class="page_menu_newpost_tw">
						<label for="postform-img" class="btn" id="img-label"><?=\Yii::$app->params['locales']["$language"][24]?> <a href="#"></a></label>
						<a href="#"><?=$form->field($model, 'img')->fileInput()?></a>
					</div>
					<div class="page_menu_newpost_bt">
						<button><?=\Yii::$app->params['locales']["$language"][25]?></button>
					</div>
				</div>
			<?php ActiveForm::end() ?>
			</div></div>
		</div>
</div>
<?php
$js = <<<JS

JS;
$this->registerJs($js);
?>
