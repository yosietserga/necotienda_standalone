<div class="large-12 medium-12 small-12 columns">
    <?php if ($success) { ?><span class="message success"><?php echo $success; ?></span><?php } ?>
    <?php if ($error) { ?><span class="message warning"><?php echo $error; ?></span><?php } ?>
</div>
<?php if ($heading){?>
    <h1><?php echo $heading; ?></h1>
<?php }?>
<?php if ($text){?>
    <h1><?php echo $text; ?></h1>
<?php }?>