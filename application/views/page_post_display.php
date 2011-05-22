<div class="post-title"> <?=$post['title']?> </div>
<div class="top-cmds">
	<?php while ($btn = $topCmds->next()) {?>
		<?php if ($topCmds->i() > 1): ?>
			<span class="separator">|</span>	
		<?php endif ?>
		<span class="cmd-button-top">
			<?php if ($btn->hasIcon()): ?>
				<img src="<?=$btn->icon()?>"/>
			<?php endif ?>
			<a href="<?=$btn->link()?>"><?=$btn->name()?></a>	
		</span>
	<?php } ?>
</div>
<br/>
<div class="post-content"> <?=$post['content']?> </div>
<div class="bottom-cmds">
	<?php while ($btn = $bottomCmds->next()) {?>
		<?php if ($bottomCmds->i() > 1): ?>
			<span class="separator">|</span>	
		<?php endif ?>

		<span class="cmd-button-bottom">
			<?php if ($btn->hasIcon()): ?>
				<img src="<?=$btn->icon()?>"/>
			<?php endif;?>
			<a href="<?=$btn->link()?>"><?=$btn->name()?></a>	
		</span>
	<?php } ?>
</div>
