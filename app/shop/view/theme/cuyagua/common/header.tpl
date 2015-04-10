<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>"> <!--<![endif]-->
<head>
    <meta charset="<?php echo ($Language->get('charset')) ? $Language->get('charset') : 'utf-8'; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo $title; ?></title>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>
    <meta name="author" content="Jesús Ramón Bejarano Martínez">
    
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($icon) { ?>
        <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,600|Oswald:400,700' rel='stylesheet' type='text/css' media='screen and (min-width:62.063em)'>-->
    <!--<link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700|Roboto:400,400italic,700,300,300italic,700italic' rel='stylesheet' type='text/css' media='screen and (min-width:64.063em)'>-->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,600|Oswald:400,700' rel='stylesheet' type='text/css' media='all'>

    <link rel="stylesheet" href="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/css/theme.css'; ?>" media="all">

    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!--<script>window.Modernizr || document.write('<script src="<?php echo HTTP_JS; ?>modernizr.js"><\/script>')</script>-->
    <!--<script>window.$ || document.write('<script src="<?php echo HTTP_JS; ?>vendor/jquery.min.js"><\/script>')</script>-->

    <!--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>-->

</head>
<body >

<!-- overheader-top-bar -->
<div id="page" class="overheader">
    <div class="row">
        <nav class="top-bar nt-editable">

            <!-- overheader-actions -->
            <section class="row">
                <div class="nav large-1 medium-1 small-1 columns hide-for-large-up">
                    <a class="left-offcanvas-trigger" href="#leftOffCanvas">
                        <span class="hamburger"><i class="fa fa-bars"></i></span>
                    </a>
                </div>

                <div itemscope itemtype="http://schema.org/LocalBusiness" class="phone large-2 medium-2 small-2 columns title-area show-for-large-up">
                    <a itemprop="telephone" class="tel" data-action="call">
                        <i class="fa fa-phone"></i><?php echo $Config->get('config_telephone'); ?>
                    </a>
                </div>

                <div class="search action-input nt-editable large-6 medium-12 small-12 columns" data-component="main-search">
                    <div class="row collapse">
                        <div id="search" class="large-10 medium-10 small-10 columns">
                            <input class="search-input" id="filterKeyword" type="search" placeholder="Buscar en tienda. Ej: Producto..." data-input="search"/>
                        </div>
                        <div class="large-1 medium-1 small-1 columns">
                            <a class="clear-trigger" title="Limpiar campo" data-action="clear-input" style=""><i class="fa fa-remove"></i></a>
                        </div>
                        <div class="large-1 medium-1 small-1 columns">
                            <a class="search-trigger" title="Buscar" onclick="moduleSearch($('#filterKeyword'));"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </div>

                <div class="config-actions large-4 medium-5 small-7 columns">
                    <ul class="row">
                        <li class="overheader-action large-4 medium-3 small-3 columns nt-editable hide-for-large-up" data-action="overheader" data-show="main-search">
                            <span class="location-heading overheader-heading">
                                <i class="fa fa-search"></i>
                            </span>
                        </li>

                        <!-- location actions -->
                        <li class="location overheader-action large-4 medium-3 small-3 columns nt-editable" data-action="overheader">
                            <div class="" data-show="conf"></div>
                            <span class="location-heading overheader-heading">
                                <i class="fa fa-compass"></i>
                                <small class="show-for-large-up">Localización</small>
                            </span>
                            <div class=" location-lists menu">
                                <?php if (count($currencies) > 1) { ?>
                                    <div class="currencies-list">
                                        <span>Moneda:</span>
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
                                <?php if (count($languages) > 1) { ?>
                                    <div class="languages-list">
                                        <span>Lenguaje:</span>
                                        <?php foreach ($languages as $language) { ?>
                                            <?php if ($language['code'] === $language_code) { ?>
                                                <span><?php echo $language['name']; ?></span>
                                            <?php } ?>
                                        <?php } ?>
                                        <ul class="list">
                                            <?php foreach ($languages as $language) { ?>
                                                <li>
                                                    <a href="<?php echo $current_url . '&hl=' . $language["code"];?>">
                                                        <img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>">
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                        <!-- /location-actions -->

                        <!-- /account actions -->
                       <li class="account overheader-action large-4 medium-3 small-3 columns nt-menu nt-editable" data-action="overheader">
                           <div class="" data-show="conf"></div>
                            <span class="overheader-heading">
                                <i class="fa fa-group"></i>
                                <small class="show-for-large-up"><?php echo $Language->get('text_my_account'); ?></small>
                            </span>
                            <div id="accountPanel" class="account-panel menu stacked-input-list">
                                <ul>
                                <!-- account-actions-if-logged -->
                                    <?php if ($isLogged) { ?>
                                        <!--<li class="background-animated-blue">
                                            <i class="fa fa-child"></i>
                                            <a href="<?php echo $Url::createUrl("account/activities"); ?>" title="<?php echo $Language->get('text_my_actitivties'); ?>"><?php echo $Language->get('text_my_actitivties');?></a>
                                        </li>-->
                                        <!--<li class="background-animated-blue">
                                            <i class="fa fa-database"></i>
                                            <a href="<?php echo $Url::createUrl("account/lists"); ?>" title="<?php echo $Language->get('text_my_lists'); ?>"><?php echo $Language->get('text_my_lists');?></a>
                                        </li>-->
                                        <li class="action-iconed">
                                            <i class="fa fa-gift"></i>
                                            <a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get('text_my_orders'); ?>"><?php echo $Language->get('text_my_orders');?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-credit-card"></i>
                                            <a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get('text_payments'); ?>"><?php echo $Language->get('text_payments');?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-bank"></i>
                                            <a href="<?php echo $Url::createUrl("account/balance"); ?>" title="<?php echo $Language->get('text_credits'); ?>"><?php echo $Language->get('text_credits');?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-wechat"></i>
                                            <a href="<?php echo $Url::createUrl("account/review"); ?>" title="<?php echo $Language->get('text_my_reviews'); ?>"><?php echo $Language->get('text_my_reviews');?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-home"></i>
                                            <a href="<?php echo $Url::createUrl("account/address"); ?>" title="<?php echo $Language->get('text_my_addresses'); ?>"><?php echo $Language->get('text_my_addresses');?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-sliders"></i>
                                            <a href="#" title="<?php echo $Language->get('text_compare'); ?>"><?php echo $Language->get('text_compare'); ?></a>
                                        </li>
                                        <li class="action-iconed">
                                            <i class="fa fa-sign-out"></i>
                                            <a href="<?php echo $Url::createUrl("account/logout"); ?>" title="<?php echo $Language->get('text_logout'); ?>"><?php echo $Language->get('text_logout'); ?></a>
                                        </li>
                                    <?php } else { ?>
                                            <li>
                                                <input class="login-username" type="text" id="loginUsername" name="username" value="" placeholder="Usuario" /></li>
                                            <li>
                                                <input type="hidden" id="tokenLogin" name="token" value="<?php echo $token; ?>" />
                                                <input class="login-password" type="password" id="loginPassword" name="password" value="" placeholder="Constresaña" />
                                            </li>
                                            <li>
                                                <div class="action-button action-login">
                                                    <a onclick="$(this).parent().remove();$('#loginLoading').show();$.post('<?php echo $Url::createUrl("account/login/header"); ?>',{ email:$('#loginUsername').val(), password:$('#loginPassword').crypt({method:'md5'}), token:$('#tokenLogin').val() }, function(response) { var data = $.parseJSON(response); if (data.error==1) { window.location.href = '<?php echo $Url::createUrl("account/login"); ?>&error=true' } else if (data.success==1) { $('#loginLoading').hide();$(this).show();window.location.reload(); } });" title="<?php echo $Language->get("text_login"); ?>"><?php echo $Language->get("text_login"); ?></a>
                                                </div>
                                                <div id="loginLoading" class="action-button action-login" style="display:none; text-align: center;" >
                                                    <a><i class="fa fa-refresh fa-spin"></i></a>
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
                    <!-- /account-actions -->

                    <!-- cart-actions -->
                    <li class="cart overheader-action account large-4 medium-3 small-3 columns nt-menu nt-editable" data-action="overheader">
                        <div class="" data-show="conf" data-request="cart"></div>
                        <span class="overheader-heading">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="added-count"><small><?php echo count($this->cart->getProducts());?></small></span>
                            <small class="show-for-large-up"><?php echo $Language->get('text_cart'); ?></small>
                            </span>
                        <div id="cartPanel" class="cart-panel menu nt-menu nt-menu-down nt-editable" data-component="cart-overview">
                            <ul></ul>
                        </div>
                    </li>
                    <!--/cart-actions -->
                    </ul>
                </div>
                <!-- /location-actions -->
            </section>
        </nav>
    </div>
</div>


