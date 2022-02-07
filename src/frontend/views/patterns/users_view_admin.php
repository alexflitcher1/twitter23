<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Поиск";
?>
<?php for ($i = 0; $i < count($users); $i++): ?>
					<div class="post">
						<div class="post_ava">
							<img src="/<?=Html::encode($users[$i]->img)?>">
						</div>
						<div class="post_content">
							<div class="post_content_name">
								<?=Html::encode($users[$i]->name)?>
								<a href="/<?=Html::encode($users[$i]->username)?>">
									@<?=Html::encode($users[$i]->username)?>
								</a>
							</div>
							<div class="post_content_data">
								<?=Html::encode($users[$i]->regdate)?>
								<?php if ($users[$i]->status == 'ban'): ?>
									(заблокирован)
								<?php endif; ?>
							</div>
							<div class="post_content_text">
								<?=Html::encode($users[$i]->about)?>
							</div>
							<div class="post_content_nav">
								<div class="post_content_nav_left">
									<?php if ($users[$i]->status == 'admin'): ?>
										<a href="/admin/add?mode=2&id=<?=Html::encode($users[$i]->id)?>" class="ban">Снять с поста администратора</a> /
									<?php else: ?>
										<a href="/admin/add?mode=1&id=<?=Html::encode($users[$i]->id)?>" class="ban">Поставить на пост администратора</a> /
									<?php endif; ?>
									<a href="/admin/ban?mode=1&id=<?=Html::encode($users[$i]->id)?>" class="ban">Заблокировать навсегда</a> /
									<a href="/admin/ban?mode=2&id=<?=Html::encode($users[$i]->id)?>" class="ban">Заблокировать на время</a>
								</div>
								<div class="post_content_nav_right"></div>
							</div>
						</div>
					</div>
<?php endfor; ?>