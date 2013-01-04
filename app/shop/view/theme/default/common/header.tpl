<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="es"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="es"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/i/378 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title><?php echo $title; ?></title>
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <?php } ?>
    
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>">
    <?php } ?>
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">

    <?php if ($icon) { ?>
    <link href="<?php echo $icon; ?>" rel="icon">
    <?php } ?>
    
    <?php if (count($styles) > 0) { ?>
        <?php foreach ($styles as $style) { ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>">
        <?php } ?>
    <?php } ?>
    
    <script src="<?php echo HTTP_JS; ?>modernizr.js"></script>
</head>
<body>
  <!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
<?php if ($is_admin) { require_once('admin.tpl'); } ?>
<header id="header"> 
    <div class="container_16">
        <div id="logo" class="grid_5">
            <?php if ($logo) { ?>
                <a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', $home); ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
            <?php } else { ?>
                <a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', $home); ?>"><?php echo $text_store; ?></a>
            <?php } ?>
        </div>
        
        <div id="search" class="grid_6">
            <input class="searchInput" type="text"  id="filter_keyword" value="<?php echo $text_keyword; ?>" onfocus="if (this.value == 'Buscar') this.value = '';" onblur="if (this.value == '') this.value = 'Buscar';" />
            <a class="searchButton" title="Buscar" onclick="moduleSearch();"><?php echo $button_go; ?></a>
        </div>
        
        <div class="grid_5">
            <div id="links">
                <ul>
                    <li><a href="<?php echo str_replace('&', '&amp;', $cart); ?>" title="Carrito de Compra">Carrito de Compra</a></li>
                    <li><a href="#" title="">FAQs</a></li>
                    <li><a href="<?php echo str_replace('&', '&amp;', $sitemap); ?>" title="Mapa del Sitio">Mapa del Sitio</a></li>
                    <?php if ($logged) {?>
                    <li><a href="<?php echo str_replace('&', '&amp;', $logout); ?>" title="Salir">Salir</a></li>
                    <?php } ?>
                </ul>
            </div>
            
            <div id="geolocate">
                <div>
                    <?php   if ($currencies) { ?>
                    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="currency_form">
                      <div class="switcher">
                        <?php foreach ($currencies as $currency) { ?>
                        <?php if ($currency['code'] == $currency_code) { ?>
                        <div class="selected"><a class="select_top" title="<?php echo $currency['title']; ?>"><?php echo $currency['title']; ?></a></div>
                        <?php } ?>
                        <?php } ?>
                        <div class="option">
                          <?php foreach ($currencies as $currency) { ?>
                          <a class="select_top" title="<?php echo $currency['title']; ?>" onclick="$('input[name=\'currency_code\']').attr('value', '<?php echo $currency['code']; ?>'); $('#currency_form').submit();"><?php echo $currency['title']; ?></a>
                          <?php } ?>
                        </div>
                      </div>
                      <div style="display: inline;">
                        <input type="hidden" name="currency_code" value="">
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
                      </div>
                    </form>
                    <?php } ?>
                </div>
                <div>
                    <?php if ($languages) { ?>
                    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="language_form">
                      <div class="switcher">
                        <?php foreach ($languages as $language) { ?>
                        <?php if ($language['code'] == $language_code) { ?>
                        <div class="selected"><a class="select_top" title="<?php echo $language['name']; ?>"><img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>">&nbsp;&nbsp;<?php echo $language['name']; ?></a></div>
                        <?php } ?>
                        <?php } ?>
                        <div class="option">
                          <?php foreach ($languages as $language) { ?>
                          <a class="select_top" title="<?php echo $language['name']; ?>" onclick="$('input[name=\'language_code\']').attr('value', '<?php echo $language['code']; ?>'); $('#language_form').submit();"><img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>">&nbsp;&nbsp;<?php echo $language['name']; ?></a>
                          <?php } ?>
                        </div>
                      </div>
                      <div>
                        <input type="hidden" name="language_code" value="">
                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">
                      </div>
                    </form>
                    <?php }  ?>
                </div>
            </div>
        </div>
    </div>
</header>