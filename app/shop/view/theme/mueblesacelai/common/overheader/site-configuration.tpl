

<?php if (count($languages) > 1) { ?>
    <div class="languages-list">
    <?php foreach ($languages as $language) { ?>

        <?php if ($language['code'] === $language_code) { ?>
        <span><?php echo $language['name']; ?></span>
        <?php } ?>

    <?php } ?>

        <ul class="list">
        <?php foreach ($languages as $language) { ?>

            <li>
                <a href="<?php echo $current_url . '&hl=' . $language['code']; ?>">
                    <img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>">
                    <span><?php echo $language['name']; ?></span>
                </a>
            </li>

        <?php } ?>
        </ul>

    </div>
<?php } ?>

<?php if ($Config->get('config_store_mode') === 'store' && count($currencies) > 1) { ?>
    <div class="currencies-list">
    <?php foreach ($currencies as $currency) { ?>

        <?php if ($currency['code'] === $currency_code) { ?>
        <span><?php echo $currency['code']; ?></span>
        <?php } ?>

    <?php } ?>

        <ul class="list">
        <?php foreach ($currencies as $currency) { ?>

            <li>
                <a href="<?php echo $current_url . '&cc=' . $currency["code"];?>">
                <?php echo $currency['code']; ?>
                </a>
            </li>

        <?php } ?>
        </ul>

    </div>
<?php } ?>



<?php if ($Config->get('config_show_stores_list') && count($stores) > 1) { ?>
<?php //TODO: add stores list by config ?>
<?php } ?>


<ul class="row">
    <li class="account" nt-editable>


        <strong class="overheader-heading">
            <small><?php echo $Language->get('text_my_account'); ?></small>
        </strong>

        <div id="accountPanel" class="account-panel <?php if ($isLogged) {echo 'logged ';}?>dropdown-menu stacked-input-list">
            <ul>
                <!-- account-actions-if-logged -->
                <?php if ($isLogged) { ?>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-gift">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/gift.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get('text_my_orders'); ?>">
                        <?php echo $Language->get('text_my_orders');?>
                    </a>
                </li>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-credit-card">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/credit-card.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get('text_payments'); ?>">
                        <?php echo $Language->get('text_payments');?>
                    </a>
                </li>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-library">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/library.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/balance"); ?>" title="<?php echo $Language->get('text_credits'); ?>"><?php echo $Language->get('text_credits');?>
                    </a>
                </li>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-bubbles">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/bubbles.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/review"); ?>" title="<?php echo $Language->get('text_my_reviews'); ?>"><?php echo $Language->get('text_my_reviews');?>
                    </a>
                </li>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-home">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/home.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/address"); ?>" title="<?php echo $Language->get('text_my_addresses'); ?>"><?php echo $Language->get('text_my_addresses');?>
                    </a>
                </li>
                <li class="action-iconed">
                    <i class="icon config-menu-icon icon-exit">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/exit.tpl"); ?>
                    </i>
                    <a href="<?php echo $Url::createUrl("account/logout"); ?>" title="<?php echo $Language->get('text_logout'); ?>"><?php echo $Language->get('text_logout'); ?></a>
                </li>
                <?php } else { ?>
                <li>
                    <input data-entry="homeLoginUser" class="login-username" type="text" id="loginUsername" name="username" value="" placeholder="Usuario" />
                </li>
                <li>
                    <input data-entry="homeLoginToken" type="hidden" id="tokenLogin" name="token" value="<?php echo $token; ?>" />
                    <input data-entry="homeLoginPassword" class="login-password" type="password" id="loginPassword" name="password" value="" placeholder="Constresaña" />
                </li>
                <li>
                    <div class="btn btn-login btn--primary" role="button">
                        <a data-action="login" data-resource='<?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/loader.tpl'); ?>' title="<?php echo $Language->get("text_login"); ?>">
                            <?php echo $Language->get("text_login"); ?>
                        </a>
                    </div>
                </li>
                <li>
                    <a class="account-register" href="<?php echo $Url::createUrl("account/register"); ?>" title="<?php echo $Language->get("text_register"); ?>">
                        <?php echo $Language->get("text_register"); ?>
                    </a>
                </li>
                <li>
                    <a class="account-forgotten" href="<?php echo $Url::createUrl("account/forgotten"); ?>" title="<?php echo $Language->get("text_forgotten"); ?>"><?php echo $Language->get("text_forgotten"); ?>
                    </a>
                </li>
                <?php if ($facebook_app_id) { ?>
                <li>
                    <a class="socialSmallButton facebookButton" href="<?php echo $Url::createUrl("api/facebook",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_facebook'); ?></a>
                </li>
                <?php } ?>

                <?php if ($twitter_oauth_token_secret) { ?>
                <li>
                    <a class="socialSmallButton twitterButton" href="<?php echo $Url::createUrl("api/twitter",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_twitter'); ?></a>
                </li>
                <?php } ?>

                <?php if ($google_client_id) { ?>
                <li>
                    <a class="socialSmallButton googleButton" href="<?php echo $Url::createUrl("api/google",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_google'); ?></a>
                </li>
                <?php } ?>

                <?php if ($live_client_id) { ?>
                <li>
                    <a class="socialSmallButton liveButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_live'); ?></a>
                </li>
                <?php } ?>
            <?php } ?>
            </ul>
            <!-- /account-actions-if-logged -->
        </div>
    </li>

    <!-- cart-actions -->
<?php if ($Config->get('config_store_mode') === 'store') { ?>

    <?php if (count($languages) >= 2 || count($currencies) >= 2) { ?>
    <li class="cart overheader-action account large-4 medium-3 small-3 columns nt-menu nt-editable" data-action="overheader">
    <?php }else { ?>
    <li class="cart overheader-action account large-6 medium-4 small-4 columns nt-menu nt-editable" data-action="overheader">
    <?php }?>

        <div data-show="conf" data-request="cart"></div>
        
        <strong class="overheader-heading">

            <span class="counter"><em><?php echo count($this->cart->getProducts());?></em></span>
            <small><?php echo $Language->get('text_cart'); ?></small>

        </strong>

        <div id="cartPanel" class="cart-panel dropdown-menu nt-menu nt-menu-down nt-editable" data-component="cart-overview" data-resource="<?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/loader.tpl'); ?>">
            <ul></ul>
        </div>
    </li>
<?php } ?>
    <!--/cart-actions -->

</ul>