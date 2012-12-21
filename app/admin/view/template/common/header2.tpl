<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="expires" content="tue, 01 Jun 2015 19:45:00 GMT" />
    <title><?php echo $title; ?></title>
    
    <?php if ($keywords) { ?>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <?php } ?>
    <?php if ($description) { ?>
    <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    
    <base href="<?php echo $base; ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>stylesheet/layouts/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>stylesheet/layouts/screen.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>stylesheet/jquery-ui-1.8.14.custom.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>stylesheet/layouts/twocolscenterfeatured.css" />

    <script type="text/javascript" src="javascript/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/jquery/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="javascript/jquery/farbtastic/farbtastic.js"></script>
    <script type="text/javascript" src="javascript/jquery/necojs/neco.colorpicker.js"></script>
</head>

<body>