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
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
    <!--<link href='http://fonts.googleapis.com/css?family=Raleway:400,600|Oswald:400,700' rel='stylesheet' type='text/css' media='all'>-->

    <link rel="stylesheet" href="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/css/theme.css'; ?>" media="all">

    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.1/modernizr.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>

    <!--<script>window.Modernizr || document.write('<script src="<?php echo HTTP_JS; ?>modernizr.js"><\/script>')</script>-->
    <!--<script>window.$ || document.write('<script src="<?php echo HTTP_JS; ?>vendor/jquery.min.js"><\/script>')</script>-->


</head>
<?php if (empty($breadcrumbs) || $breadcrumbs === null) { ?>

<body data-section="home" class="home-page">

<?php } else { ?>

<body>

<?php } ?>

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

                <?php //include(DIR_TEMPLATE. $this->config->get('config_template') ."/common/search.tpl"); ?>
                <?php //include(DIR_TEMPLATE. $this->config->get('config_template') ."/common/configuration.tpl"); ?>

                <!-- /location-actions -->
            </section>
        </nav>
    </div>
</div>


