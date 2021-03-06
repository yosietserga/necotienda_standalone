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
    
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>
    
    <?php if ($css) { ?><style><?php echo $css; ?></style><?php } ?>
    
    <?php if (count($styles) > 0) { ?>
        <?php foreach ($styles as $style) { ?>
        <?php if (empty($style['href'])) continue; ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>" />
        <?php } ?>
    <?php } ?>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>window.Modernizr || document.write('<script src="<?php echo HTTP_JS; ?>modernizr.js"><\/script>')</script>
    <script>window.$ || document.write('<script src="<?php echo HTTP_JS; ?>vendor/jquery.min.js"><\/script>')</script>
</head>
<body id="mainbody">
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<?php if ($is_admin) { require_once('admin.tpl'); } ?>
<section id="overheader" class="nt-editable">

    <div class="container">
    
        <div class="grid_10 hideOnMobile">
            <ul id="links" class="nt-editable">
                <li><a href="<?php echo HTTP_HOME; ?>" title="<?php echo $Language->get('text_home'); ?>"><?php echo $Language->get('text_home'); ?></a></li>
                <li><a href="<?php echo $Url::createUrl('store/special'); ?>" title="<?php echo $Language->get('text_special'); ?>"><?php echo $Language->get('text_special'); ?></a></li>
                <li><a href="<?php echo $Url::createUrl('checkout/cart'); ?>" title="<?php echo $Language->get('text_cart'); ?>"><?php echo $Language->get('text_cart'); ?></a></li>
                <li><a href="<?php echo $Url::createUrl('page/sitemap'); ?>" title="<?php echo $Language->get('text_sitemap'); ?>"><?php echo $Language->get('text_sitemap'); ?></a></li>
                <li><a href="<?php echo $Url::createUrl('page/contact'); ?>" title="<?php echo $Language->get('text_contact'); ?>"><?php echo $Language->get('text_contact'); ?></a></li>
            </ul>
        </div>
        
        <?php if (count($currencies)>1) { ?>
        <div class="grid_1">
            <div id="currencies" class="nt-editable" onclick="changeCurrency('<?php echo $Url::createUrl('common/header/getcurrencies'); ?>')">
                <i class="fa fa-money"></i>&nbsp;
            <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency['code'] == $currency_code) { ?>
                    <?php echo $currency['code']; ?>
                <?php } ?>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
        
        <?php if (count($languages)>1) { ?>
        <div class="grid_1">
            <div id="languages" class="nt-editable" onclick="changeLanguage('<?php echo $Url::createUrl('common/header/getlanguages'); ?>')">
            <?php foreach ($languages as $language) { ?>
                <?php if ($language['code'] == $language_code) { ?>
                <img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />
                <?php } ?>
            <?php } ?>
            </div>
        </div>
        <?php } ?>
        
    </div>
</section>

<div class="container">
    <header id="header" class="nt-editable">
        <div class="grid_4">
            <div id="logo" class="nt-editable">
                <?php if ($logo) { ?>
                    <a title="<?php echo $store; ?>" href="<?php echo $Url::createUrl("common/home"); ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
                <?php } else { ?>
                    <a title="<?php echo $store; ?>" href="<?php echo $Url::createUrl("common/home"); ?>"><?php echo $text_store; ?></a>
                <?php } ?>
            </div>
        </div>
        
        <div class="grid_8" style="text-align:right;">
        
            <div id="accountPanel" class="nt-menu nt-menu-down nt-editable">
                <p><i class="fa fa-group"></i>&nbsp;&nbsp;<?php echo $Language->get('text_my_account'); ?></p>
                <ul>
                <?php if ($isLogged) { ?>
                    <li class="background-animated-blue">
                        <i class="fa fa-child"></i>
                        <a href="<?php echo $Url::createUrl("account/activities"); ?>" title="<?php echo $Language->get('text_my_actitivties'); ?>"><?php echo $Language->get('text_my_actitivties');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-database"></i>
                        <a href="<?php echo $Url::createUrl("account/lists"); ?>" title="<?php echo $Language->get('text_my_lists'); ?>"><?php echo $Language->get('text_my_lists');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-gift"></i>
                        <a href="<?php echo $Url::createUrl("account/order"); ?>" title="<?php echo $Language->get('text_my_orders'); ?>"><?php echo $Language->get('text_my_orders');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-credit-card"></i>
                        <a href="<?php echo $Url::createUrl("account/payment"); ?>" title="<?php echo $Language->get('text_payments'); ?>"><?php echo $Language->get('text_payments');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-bank"></i>
                        <a href="<?php echo $Url::createUrl("account/balance"); ?>" title="<?php echo $Language->get('text_credits'); ?>"><?php echo $Language->get('text_credits');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-wechat"></i>
                        <a href="<?php echo $Url::createUrl("account/review"); ?>" title="<?php echo $Language->get('text_my_reviews'); ?>"><?php echo $Language->get('text_my_reviews');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-home"></i>
                        <a href="<?php echo $Url::createUrl("account/address"); ?>" title="<?php echo $Language->get('text_my_addresses'); ?>"><?php echo $Language->get('text_my_addresses');?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-sliders"></i>
                        <a href="#" title="<?php echo $Language->get('text_compare'); ?>"><?php echo $Language->get('text_compare'); ?></a>
                    </li>
                    <li class="background-animated-blue">
                        <i class="fa fa-sign-out"></i>
                        <a href="<?php echo $Url::createUrl("account/logout"); ?>" title="<?php echo $Language->get('text_logout'); ?>"><?php echo $Language->get('text_logout'); ?></a>
                    </li>
                <?php } else { ?>
                    <li><input type="text" id="loginUsername" name="username" value="" placeholder="Nombre de Usuario" /></li>
                    <li>
                        <input type="hidden" id="tokenLogin" name="token" value="<?php echo $token; ?>" />
                        <input type="password" id="loginPassword" name="password" value="" placeholder="password" />
                    </li>
                    <li>
                        <a class="button" onclick="$(this).hide();$('#loginLoading').show();$.post('<?php echo $Url::createUrl("account/login/header"); ?>',{ email:$('#loginUsername').val(), password:$('#loginPassword').crypt({method:'md5'}), token:$('#tokenLogin').val() }, function(response) { var data = $.parseJSON(response); if (data.error==1) { window.location.href = '<?php echo $Url::createUrl("account/login"); ?>&error=true' } else if (data.success==1) { $('#loginLoading').hide();$(this).show();window.location.reload(); } });" title="<?php echo $Language->get("text_login"); ?>"><?php echo $Language->get("text_login"); ?></a>
                        <a class="button" style="display:none" id="loginLoading"><i class="fa fa-refresh fa-spin"></i></a>
                    </li>
                    <li><div class="clear"></div></li>
                    <li><a href="<?php echo $Url::createUrl("account/register"); ?>" title="<?php echo $Language->get("text_register"); ?>"><?php echo $Language->get("text_register"); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><a href="<?php echo $Url::createUrl("account/forgotten"); ?>" title="<?php echo $Language->get("text_forgotten"); ?>"><?php echo $Language->get("text_forgotten"); ?></a></li>
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
            </div>
        
            <div id="cartPanel" class="nt-menu nt-menu-down nt-editable hideOnMobile">
                <p><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<?php echo $Language->get('text_cart'); ?></p>
                <ul></ul>
            </div>
        
            <div id="search" class="nt-editable">
                <input type="text" id="filterKeyword" value="" placeholder="Buscar" />
                <a title="Buscar" onclick="moduleSearch($('#filterKeyword'));"><i class="fa fa-search fa-2x"></i></a>
            </div>
            <script>
            $(function(){
                $('#filterKeyword').on('keyup',function(e){
                    var code = e.keyCode || e.which;
                    if ($(this).val().length > 0 && code == 13){
                        moduleSearch(this);
                    }
                });
            });
            </script>
            
        </div>
    </header>
</div>

<div class="clear"></div>