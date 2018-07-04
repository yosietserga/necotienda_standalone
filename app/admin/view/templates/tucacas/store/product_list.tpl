<?php echo $header; ?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?php echo $Language->get('heading_title'); ?></h2>
        <?php include_once(dirname(__FILE__) .'/../common/breadcrumbs.tpl'); ?>
    </div>

    <?php if ($success) { ?><div class="grid_12"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg || $error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo ($msg) ? $msg : $error_warning; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_12"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
    <div class="grid_12" id="msg"></div>

</div>

<div id="app"></div>
<?php echo $footer; ?>

