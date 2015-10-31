<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="content">
		<?=$content?>
		<div class="single__col2">
			<div class="block300 mb20">
				<?php if ($this->hasParam('adv_right1')): ?>
					<?= $this->siteParams['adv_right1'] ?>
				<?php endif; ?>
			</div>
			<div class="block300 mb20">
				<?php if ($this->hasParam('adv_right2')): ?>
					<?= $this->siteParams['adv_right2'] ?>
				<?php endif; ?>
			</div>
			<div class="block300 mb20">
				<?php if ($this->hasParam('adv_right3')): ?>
					<?= $this->siteParams['adv_right3'] ?>
				<?php endif; ?>
			</div>
			<div class="block300 mb20">
				<?php if ($this->hasParam('adv_right4')): ?>
					<?= $this->siteParams['adv_right4'] ?>
				<?php endif; ?>
			</div>
		</div>
		<aside>
			<?php
			$this->widget('application.widget.LastArticlesPageWidget.LastArticlesPageWidget', array(
				'render' => 'LastArticlesForTitlePage',
				'renderWrap' => 'LastArticlesPageWrapForTitle',
				'classWrap' => 'aside__posts',
				'pageSize' => 4,
				'sizeImage' => array('w' => 234, 'h' => 243),
				'ajax' => true,
//			'showCountPhotoToTitle' => true,
				'classViewWrap' => 'rbt-c',
			));
			?>
		</aside>

	</div>
</div>

<?php $this->endContent(); ?>
