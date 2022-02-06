<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
			<?php for ($i = 0; $i < count($posts); $i++): ?>
				<?php if (empty($posts[$i]['replies']) && $posts[$i]['replyid'] == 0): ?>
					<div class="post">
						<div class="post_ava">
							<img src="/<?=Html::encode($posts[$i]['authordata']->img)?>">
						</div>
						<div class="post_content">
							<div class="post_content_name">
								<?=Html::encode($posts[$i]['authordata']->name)?> <a href="/<?=Html::encode($posts[$i]['authordata']->username)?>">@<?=Html::encode($posts[$i]['authordata']->username)?></a>
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
										<a class="delete" data-id="<?=Html::encode($posts[$i]->id)?>">Удалить</a> /
										<a href="/edit?id=<?=Html::encode($posts[$i]->id)?>" class="edit">Редактировать</a> /
										<a href="/admin/ban?mode=1&id=<?=Html::encode($posts[$i]->userid)?>" class="ban">Заблокировать автора навсегда</a> /
										<a href="/admin/ban?mode=2&id=<?=Html::encode($posts[$i]->userid)?>" class="ban">Заблокировать автора на время</a> /
										<a href="/me?mode=reply&replypost=<?=Html::encode($posts[$i]['id'])?>">
											Ответить (0)
										</a> /
										<a
										<?php if (isset($liked["{$posts[$i]['id']}"])): ?>
											<?= $liked["{$posts[$i]['id']}"] ? "class='like underline'" : "class='like'" ?>
										<?php else: ?>
											<?="class='like'"?>
										<?php endif; ?>
										data-id="<?=Html::encode($posts[$i]['id'])?>">Нравится (<?=Html::encode($posts[$i]['likes'])?>)
										</a>
								</div>
								<div class="post_content_nav_right">
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
									<?=Html::encode($posts[$i]['authordata']->name)?> <a href="/<?=Html::encode($posts[$i]['authordata']->username)?>">@<?=Html::encode($posts[$i]['authordata']->username)?></a>
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
											<a class="delete" data-id="<?=Html::encode($posts[$i]->id)?>">Удалить</a> /
											<a href="/edit?id=<?=Html::encode($posts[$i]->id)?>" class="edit">Редактировать</a> /
											<a href="/admin/ban?mode=1&id=<?=Html::encode($posts[$i]->userid)?>" class="ban">Заблокировать автора навсегда</a> /
											<a href="/admin/ban?mode=2&id=<?=Html::encode($posts[$i]->userid)?>" class="ban">Заблокировать автора на время</a> /
											<a href="/me?mode=reply&replyid=<?=Html::encode($posts[$i]['userid'])?>&replypost=<?=Html::encode($posts[$i]['id'])?>">
												Ответить (<?=count($posts[$i]['replies'])?>)
											</a> /
											<a
											<?php if (isset($liked["{$posts[$i]['id']}"])): ?>
												<?= $liked["{$posts[$i]['id']}"] ? "class='like underline'" : "class='like'" ?>
											<?php else: ?>
												<?="class='like'"?>
											<?php endif; ?>
											data-id="<?=Html::encode($posts[$i]['id'])?>">Нравится (<?=Html::encode($posts[$i]['likes'])?>)
											</a>
									</div>
									<div class="post_content_nav_right">
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
											<?=Html::encode($repliers[$i][$j]->name)?> <a href="/<?=Html::encode($repliers[$i][$j]->username)?>">@<?=Html::encode($repliers[$i][$j]->username)?></a>
										</div>
										<div class="post_content_data">
											<?=Html::encode($posts[$i]['replies'][$j]->date)?>
										</div>
										<div class="post_content_text">
											<?=$posts[$i]['replies'][$j]->text?>
										</div>
										<?php if ($posts[$i]['replies'][$j]->img != null): ?>
											<div class="post_content_img">
												<img src="<?=Html::encode($posts[$i]['replies'][$j]->img)?>">
											</div>
										<?php endif; ?>
										<div class="post_content_nav">
											<div class="post_content_nav_left">
													<a class="delete" data-id="<?=Html::encode($posts[$i]['replies'][$j]->id)?>">Удалить</a> /
													<a href="/edit?id=<?=Html::encode($posts[$i]['replies'][$j]->id)?>" class="edit">Редактировать</a> /
													<a href="/admin/ban?mode=1&id=<?=Html::encode($posts[$i]['replies'][$j]->userid)?>" class="ban">Заблокировать автора навсегда</a> /
													<a href="/admin/ban?mode=2&id=<?=Html::encode($posts[$i]['replies'][$j]->userid)?>" class="ban">Заблокировать автора на время</a> /
													<a href="/me?mode=reply&replierid=<?=$posts[$i]['replies'][$j]->id?>&replypost=<?=Html::encode($posts[$i]->id)?>">Ответить</a> /
													<a
													<?php if (isset($liked["{$posts[$i]['replies'][$j]->id}"])): ?>
														<?= $liked["{$posts[$i]['replies'][$j]->id}"] ? "class='like underline'" : "class='like'" ?>
													<?php else: ?>
														<?="class='like'"?>
													<?php endif; ?>
													data-id="<?=Html::encode($posts[$i]['replies'][$j]->id)?>">Нравится (<?=$posts[$i]['replies'][$j]->likes?>)
												</a>
											</div>
											<div class="post_content_nav_right">
											</div>
										</div>
									</div>
								</div>
							<?php endfor; ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			</div>