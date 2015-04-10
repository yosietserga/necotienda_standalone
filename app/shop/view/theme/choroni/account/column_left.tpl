<div class="box">
    <div class="header">Pedidos</div>
    <div class="content">
        <ul>
            <li>
                <a href="<?php echo $Url::createUrl("account/order"); ?>"><?php echo $Language->get('text_history'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/payment"); ?>"><?php echo $Language->get('text_payments'); ?></a>
            </li>
            <!--
            <li>
                <a href="<?php echo $Url::createUrl("account/download"); ?>"><?php echo $Language->get('text_download'); ?></a>
            </li>
            -->
	</ul>
    </div>
</div>
<!--
<div class="box">
    <div class="header">Perfil</div>
    <div class="content">
        <ul>
            <li>
                <a href="<?php echo $Url::createUrl("account/profile"); ?>"><?php echo $Language->get('text_profile'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/activities"); ?>"><?php echo $Language->get('text_my_activities'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/hobbies"); ?>"><?php echo $Language->get('text_hobbies'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/social"); ?>"><?php echo $Language->get('text_social_networks'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/newsletter"); ?>"><?php echo $Language->get('text_newsletter'); ?></a>
            </li>
	</ul>
    </div>
</div>
-->
<div class="box">
    <div class="header"><?php echo $Language->get('text_messages'); ?></div>
    <div class="content">
        <ul>
            <li>
                <a href="<?php echo $Url::createUrl("account/message/create"); ?>"><?php echo $Language->get('text_create_message'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/message"); ?>"><?php echo $Language->get('text_inbounce'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/message/sent"); ?>"><?php echo $Language->get('text_outbounce'); ?></a>
            </li>
	</ul>
    </div>
</div>
<div class="box">
    <div class="header">Cuenta</div>
    <div class="content">
        <ul>
            <li>
                <a href="<?php echo $Url::createUrl("account/edit"); ?>"><?php echo $Language->get('text_my_account'); ?></a>
            </li>
            <!--
            <li>
                <a href="<?php echo $Url::createUrl("account/balance"); ?>"><?php echo $Language->get('text_balance'); ?></a>
            </li>
            -->
            <li>
                <a href="<?php echo $Url::createUrl("account/review"); ?>"><?php echo $Language->get('text_my_comment'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/address"); ?>"><?php echo $Language->get('text_address'); ?></a>
            </li>
            <li>
                <a href="<?php echo $Url::createUrl("account/password"); ?>"><?php echo $Language->get('text_password'); ?></a>
            </li>
	</ul>
    </div>
</div>
<!--
<div class="box">
    <div class="header">Terminar Cuenta</div>
    <div class="content">
        <ul>
            <li>
                <a href="<?php echo $Url::createUrl("account/cancel "); ?>"><?php echo $Language->get('text_cancel_account'); ?></a>
            </li>
	</ul>
    </div>
</div>
 -->