<div class="row">
	<div class="links medium-12 small-12">
		<div class="heading">
			<h3>
				<?php echo $Language->get('text_my_orders');?>
			</h3>
		</div>

		<ul>
			<li>
				<a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get('text_history'); ?>"><?php echo $Language->get('text_history'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get('text_payments'); ?>"><?php echo $Language->get('text_payments'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/review"); ?>" title="<?php echo $Language->get('Comments'); ?>"><?php echo $Language->get('text_payments'); ?></a>
			</li>
		</ul>
	</div>

	<?php /*
	<div class="links medium-12 small-12">
		<div class="heading">
			<h3>
				<?php echo $Language->get('text_messages');?>
			</h3>
		</div>

		<ul>
			<li>
				<a href="<?php echo $Url::createUrl("account/message/create"); ?>" title="<?php echo $Language->get('text_create_message'); ?>"><?php echo $Language->get('text_create_message'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/message"); ?>" title="<?php echo $Language->get('text_inbounce'); ?>"><?php echo $Language->get('text_inbounce'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/message/sent"); ?>" title="<?php echo $Language->get('text_outbounce'); ?>"><?php echo $Language->get('text_outbounce'); ?></a>
			</li>
		</ul>
	</div>
	*/ ?>

	<div class="links medium-12 small-12">
		<div class="heading">
			<h3>
				<?php echo $Language->get('text_account');?>

			</h3>
		</div>

		<ul>
			<li>
				<a href="<?php echo $Url::createUrl("account/edit"); ?>" title="<?php echo $Language->get('text_my_account');?>"><?php echo $Language->get('text_my_account'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/review"); ?>" title="<?php echo $Language->get('text_my_comment');?>"><?php echo $Language->get('text_my_comment'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/address"); ?>" title="<?php echo $Language->get('text_address');?>"><?php echo $Language->get('text_address'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/password"); ?>" title="<?php echo $Language->get('text_password');?>"><?php echo $Language->get('text_password');?></a>
			</li>
		</ul>
	</div>
</div>