<form action="<?php echo $Url::createUrl('module/contact_form/processform'); ?>" method="post" enctype="multipart/form-data" id="<?php echo $widgetName; ?>_contact_form">
    <div class="row">
        <label><?php echo $Language->get('Full Name');?></label>
        <input type="text" name="name" value="<?php echo $name; ?>" title="<?php echo $settings['title_name']; ?>" required="required" placeholder="<?php echo $settings['placeholder_name']; ?>" />
        <?php if ($error_name) { ?><span class="error"><?php echo $error_name; ?></span><?php } ?>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <label><?php echo $Language->get('Email'); ?></label>
        <input type="email" name="email" title="<?php echo $settings['title_email']; ?>" required="required" placeholder="<?php echo $settings['placeholder_email']; ?>" />
        <?php if ($error_email) { ?><span class="error"><?php echo $error_email; ?></span><?php } ?>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <label><?php echo $Language->get('Enquiry'); ?></label>
        <div class="clearfix"></div>
        <textarea name="enquiry" required="required" placeholder="<?php echo $settings['placeholder_enquiry']; ?>"><?php echo $enquiry; ?></textarea>
        <?php if ($error_enquiry) { ?><span class="error"><?php echo $error_enquiry; ?></span><?php } ?>
    </div>

    <div class="clearfix"></div>

    <input type="submit" value="Send" />
</form>

<script>
$(function(){
    $('#<?php echo $widgetName; ?>_contact_form').on('submit', function(e){
        e.preventDefault();
        e.stopImmediatePropagation();

        animateForm('#<?php echo $widgetName; ?>_contact_form');
        processForm('#<?php echo $widgetName; ?>_contact_form', '<?php echo $widgetName; ?>');

        return false;
    });
});
</script>