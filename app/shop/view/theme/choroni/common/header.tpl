<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />

    <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title><?php echo $title; ?></title>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>
    
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width" />

    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon" />
    <?php } ?>
    
    <?php if (count($styles) > 0) { ?>
        <?php foreach ($styles as $style) { ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>" />
        <?php } ?>
    <?php } ?>
    
    <script src="<?php echo HTTP_JS; ?>modernizr.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>window.$ || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>

</head>
<body id="mainbody">
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<?php if ($is_admin) { require_once('admin.tpl'); } ?>
<section id="overheader" class="nt-editable">

    <div class="container_16">
    
        <div class="grid_8">
            <ul id="links" class="nt-editable">
                <li><a href="<?php $Url::createUrl('common/home'); ?>" title="<?php echo $text_home; ?>"><?php echo $text_home; ?></a></li>
                <li><a href="<?php $Url::createUrl('store/special'); ?>" title="<?php echo $text_home; ?>"><?php echo $text_special; ?></a></li>
                <li><a href="<?php $Url::createUrl('checkout/cart'); ?>" title="<?php echo $text_home; ?>"><?php echo $text_cart; ?></a></li>
                <li><a href="<?php $Url::createUrl('content/sitemap'); ?>" title="<?php echo $text_home; ?>"><?php echo $text_sitemap; ?></a></li>
                <li><a href="<?php $Url::createUrl('content/contact'); ?>" title="<?php echo $text_home; ?>"><?php echo $text_contact; ?></a></li>
            </ul>
        </div>
        
        <?php if ($currencies) { ?>
        <div class="grid_3">
            <div id="currencies" class="nt-dd1 nt-editable">
            
                <p>MONEDA:&nbsp;
                <?php foreach ($currencies as $currency) { ?>
                    <?php if ($currency['code'] == $currency_code) { ?>
                    <b><?php echo $currency['title']; ?>&nbsp;( <?php echo $currency['code']; ?> )</b>
                    <?php } ?>
                <?php } ?>
                    <span>&nbsp;</span>
                </p>
                
                <ul>
                <?php foreach ($currencies as $currency) { ?>
                    <li><a title="<?php echo $currency['title']; ?>" onclick="$('input[name=\'currency_code\']').val('<?php echo $currency['code']; ?>'); $('#currency_form').submit();"><?php echo $currency['title']; ?>&nbsp;( <?php echo $currency['code']; ?> )</a></li>
                <?php } ?>
                </ul>
                
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="currency_form">
                    <input type="hidden" name="currency_code" value="" />
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                </form>
                
            </div>
        </div>
        <?php } ?>
        
        <?php if ($languages) { ?>
        <div class="grid_3">
            <div id="languages" class="nt-dd1 nt-editable">
            
                <p>IDIOMA:&nbsp;
                <?php foreach ($languages as $language) { ?>
                    <?php if ($language['code'] == $language_code) { ?>
                    <b><img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />&nbsp;&nbsp;<?php echo $language['name']; ?></b>
                    <?php } ?>
                <?php } ?>
                    <span>&nbsp;</span>
                </p>
                
                <ul>
                <?php foreach ($languages as $language) { ?>
                    <li>
                        <a title="<?php echo $language['name']; ?>" onclick="$('input[name=\'language_code\']').val('<?php echo $language['code']; ?>'); $('#language_form').submit();">
                            <img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>" />&nbsp;&nbsp;
                            <?php echo $language['name']; ?>
                        </a>
                    </li>
                <?php } ?>
                </ul>
                
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="language_form">
                    <input type="hidden" name="language_code" value="" />
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                </form>
                
            </div>
        </div>
        <?php } ?>
        
        <div class="grid_2">
            <div id="loginPanel" class="nt-dd1 nt-editable">
                <p>&nbsp;</p>
                <ul>
                <?php if ($isLogged) { ?>
                    <li><h2><?php echo $greetings; ?></h2></li>
                    <li><a href="<?php echo $Url::createUrl("account/account"); ?>" title=""><?php echo $text_account;?></a></li>
                    <li><a href="<?php echo $Url::createUrl("account/message"); ?>" title=""><?php echo $text_messages;?></a></li>
                    <li><a href="<?php echo $Url::createUrl("account/logout"); ?>" title=""><?php echo $text_logout;?></a></li>
                <?php } else { ?>
                    <li><input type="text" id="loginUsername" name="username" value="" placeholder="Nombre de Usuario" /></li>
                    <li><input type="password" id="loginPassword" name="password" value="" placeholder="password" /></li>
                    <li><a class="button" onclick="$.post('<?php echo $Url::createUrl("account/login/header"); ?>',{ email:$('#loginUsername').val(), password:$('#loginPassword').val() }, function(response) { var data = $.parseJSON(response); if (data.success==1) { window.location = 'data.redirect'; } else { window.location = '<?php echo $Url::createUrl("account/login"); ?>&error=true' } });" title="<?php echo $text_login;?>"><?php echo $text_login;?></a></li>
                    <li><a href="<?php echo $Url::createUrl("account/forgotten"); ?>" title="<?php echo $text_forgotten;?>"><?php echo $text_forgotten;?></a></li>
                <?php } ?>
                </ul>
            </div>
        </div>
        
    </div>
    
</section>

<header id="header" class="nt-editable">

    <div class="container_16">
    
        <div class="grid_5">
            <div id="logo" class="nt-editable">
                <?php if ($logo) { ?>
                    <a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', $home); ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
                <?php } else { ?>
                    <a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', $home); ?>"><?php echo $text_store; ?></a>
                <?php } ?>
            </div>
        </div>
        
        <div class="grid_10" style="text-align:right;">
        
            <div id="search" class="nt-editable">
                <input type="text" id="filter_keyword" value="" placeholder="Buscar" />
                <a title="Buscar" onclick="moduleSearch();">&nbsp;</a>
            </div>
        
            <div class="clear"></div>
            
            <div id="accountPanel" class="nt-dd1 nt-editable">
                <p><?php echo $text_my_account; ?>&nbsp;&nbsp;<b>&nbsp;</b></p>
                <ul>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_my_actitivties;?>"><?php echo $text_my_actitivties;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_my_lists;?>"><?php echo $text_my_lists;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_my_orders;?>"><?php echo $text_my_orders;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_payments;?>"><?php echo $text_payments;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_credits;?>"><?php echo $text_credits;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_my_reviews;?>"><?php echo $text_my_reviews;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_my_addresses;?>"><?php echo $text_my_addresses;?></a></li>
                    <li><a href="<?php echo $Url::createUrl(""); ?>" title="<?php echo $text_compare;?>"><?php echo $text_compare;?></a></li>
                </ul>
            </div>
        
            <div id="cartPanel" class="nt-dd1 nt-editable">
                <p><?php echo $text_cart; ?>&nbsp;&nbsp;<b>&nbsp;</b></p>
                <ul>
                    <?php if ($cartHasProducts) { ?>
                    <li><h2>Productos</h2></li>
                    <li>
                        <img src="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" />
                        <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name'];?>"><?php echo $product['name'];?><div><?php echo $product['model'];?></div></a>
                        <div><?php echo $product['qty'];?></div>
                        <?php if ($display_prices) { ?>
                        <div><?php echo $product['price'];?></div>
                        <?php } ?>
                    </li>
                    <?php } else { ?>
                    <li>No ha agregado productos al carrito</li>
                    <?php } ?>
                </ul>
            </div>
        
        </div>
        
    </div>
    
</header>