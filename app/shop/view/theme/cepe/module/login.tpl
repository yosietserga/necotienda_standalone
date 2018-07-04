<li class="nt-editable login-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>"> 
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 
    <!-- login-widget-content -->
    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
    <?php if (!$this->customer->islogged()) { ?>
        <div class="simple-form">
            <form name="login" id="<?php echo $widgetName; ?>_login_form">
                <div class="stacked-input-list">
                    <ul>
                        <li>
                            <input class="login-username" type="email" name="login_email" id="<?php echo $widgetName; ?>_login_email" value="" placeholder="Ingresa tu email"/>
                        </li>

                        <li>
                            <input type="hidden" name="login_token" id="<?php echo $widgetName; ?>_login_token" value="<?php echo $tokenLogin; ?>" />
                            <input class="login-password" type="password" name="login_password" id="<?php echo $widgetName; ?>_login_password" value="" placeholder="password" autocomplete="off" />
                        </li>

                        <li>
                            <div class="btn btn-login btn--primary" role="button" aria-label="Login">
                                <a id="<?php echo $widgetName; ?>_submit_login"><?php echo $Language->get('text_login'); ?></a>
                            </div>
                        </li>

                        <li>
                            <a class="account-register" href="<?php echo $Url::createUrl("account/register"); ?>"><?php echo $Language->get('text_register'); ?></a>
                        </li>

                        <li>
                            <a class="account-forgotten" href="<?php echo $Url::createUrl("account/forgotten"); ?>"><?php echo $Language->get('text_forgotten'); ?></a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
    <?php } else {  ?>
        <div class="sidebar-list">
            <ul>
                <li>
                    <a href="<?php echo $Url::createUrl("account/account"); ?>" title="<?php echo $Language->get("text_my_account"); ?>"><?php echo $Language->get("text_my_account"); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get("text_my_orders"); ?>"><?php echo $Language->get("text_my_orders"); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get("text_payments"); ?>"><?php echo $Language->get("text_payments"); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl("account/logout"); ?>" title="<?php echo $Language->get("text_logout"); ?>"><?php echo $Language->get("text_logout"); ?></a>
                </li>
            </ul>
        </div>
    <?php } ?>
    </div>
    <!-- /login-widget-content -->
</li>
<?php if (!$this->customer->islogged()) { ?>
<script>
(function () {
    window.deferjQuery(function () {
        $('#<?php echo $widgetName; ?>_submit_login').on('click',function(event){
            $.post('<?php echo $Url::createUrl("module/login/login"); ?>',{
                email:$('#<?php echo $widgetName; ?>_login_email').val(),
                password:$('#<?php echo $widgetName; ?>_login_password').crypt({method:'md5'}),
                token:$('#<?php echo $widgetName; ?>_login_token').val()
            },
            function(response){
                $('#temp').remove();
                $('#<?php echo $widgetName; ?>_login_email').removeClass('neco-input-error');

                try {
                   data = $.parseJSON(response);
                } catch(error) {
                    data = response;
                }

                if (typeof data.success !== 'undefined') {
                    window.location.reload();
                }

                if (typeof data.error !== 'undefined') {
                    $('#<?php echo $widgetName; ?>_login_email').addClass('neco-input-error').after('<div class="message warning" id="temp">'+ data.msg +'</div>');
                }
            })
        });
    });
})();
</script>
<?php } ?>