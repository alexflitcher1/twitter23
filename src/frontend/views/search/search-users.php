<?php
use yii\helpers\Html;
?>
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