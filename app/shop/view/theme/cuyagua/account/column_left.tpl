<!--MENU-ORDERS-->
<div class="menu-orders">
	<div class="heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3> 
                <?php echo $Language->get('text_my_orders');?>
            </h3>
        </div>
    </div>
	<div class="widget-content sidebar-list account-list">
		<ul>
			<li>
				<a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get('text_history'); ?>"><?php echo $Language->get('text_history'); ?></a>
			</li>
			<li>
				<a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get('text_payments'); ?>"><?php echo $Language->get('text_payments'); ?></a>
			</li>
		</ul>
	</div>
</div>
<!--/menu-orders-->

<!--MENU-MESSAGES-->
<div class="menu-messages">
    <div class="heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3> 
                <?php echo $Language->get('text_messages');?>
            </h3>
        </div>
    </div>
	<div class="widget-content sidebar-list account-list">
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
</div>
<!--/MENU-MESSAGES-->

<!--MENU-ACCOUNT-->
<div class="actions-account">
	<div class="heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3> 
                <?php echo $Language->get('text_account');?>

            </h3>
        </div>
    </div>
	<div class="widget-content sidebar-list account-list">
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
<!--/MENU-ACCOUNT-->
