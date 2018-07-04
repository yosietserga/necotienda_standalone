<!doctype html>
<html class="no-js" lang="<?php echo ($Language->get('code')) ? $Language->get('code') : 'es'; ?>">
<head>
    <meta charset="<?php echo ($Language->get('charset')) ? $Language->get('charset') : 'utf-8'; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title><?php echo $title; ?></title>
    <?php if (!empty($keywords)) { ?><meta name="keywords" content="<?php echo $keywords; ?>"><?php } ?>
    <?php if (!empty($description)) { ?><meta name="description" content="<?php echo $description; ?>"><?php } ?>
    <?php if (!empty($icon)) { ?><link href="<?php echo $icon; ?>" rel="icon"><?php } else { ?>
    <link href="http://www.necotienda.org/assets/images/data/favicon.png" rel="icon" />
    <?php } ?>
    
    <meta name="HandheldFriendly" content="true" />   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <?php if ($css) { ?><style> <?php echo $css; ?> </style><?php } ?>
    
    <?php if (count($styles) > 0) { ?>
        <?php foreach ($styles as $style) { ?>
        <?php if (empty($style['href'])) continue; ?>
    <link rel="stylesheet" type="text/css" media="<?php echo $style['media']; ?>" href="<?php echo $style['href']; ?>" />
        <?php } ?>
    <?php } ?>
    
    <script>
        window.nt = {};
    <?php if (isset($_GET['token']) && !empty($_GET['token'])) { ?>
        window.nt.token = '<?php echo $_GET['token']; ?>';
        window.nt.uid = '<?php echo $this->session->get('user_id'); ?>';
    <?php } ?>
        window.nt.http_home = '<?php echo HTTP_HOME; ?>';
        window.nt.http_image = '<?php echo HTTP_IMAGE; ?>';
        window.nt.http_admin_image = '<?php echo HTTP_ADMIN_IMAGE; ?>';
        window.nt.route = '<?php echo $this->Route; ?>';
    </script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>window.$ || document.write('<script src="templates/tucacas/js/vendor/jquery-2.1.1.js"><\/script>')</script>
    <script type="text/javascript">window.CKEDITOR_BASEPATH = '<?php echo HTTP_ADMIN_JS; ?>vendor/ckeditor/';</script>


</head>
<body class="mini-navbar">

<div id="wrapper">
    <?php include_once('nav.tpl'); ?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include_once('topnav.tpl'); ?>