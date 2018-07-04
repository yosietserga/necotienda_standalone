<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>
    <div class="page-contact">
        <div class="contact-info">
            <?php if ($telephone) { ?>
                <p>
                    <strong><?php echo $Language->get('text_telephone'); ?></strong>&nbsp;<em><?php echo $telephone; ?></em>
                </p>
            <?php } ?>
            <p>
                <strong><?php echo $Language->get('text_address'); ?></strong>&nbsp;<?php echo $address; ?>
            </p>
        </div>
    <?php if (isset($success)) { ?><div class="message success"><?php echo $success; ?></div><?php } ?>
        <div class="simple-form contact-form break">
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="contact">

                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                <div class="clearfix"></div>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/email.tpl"); ?>
                <div class="clearfix"></div>

                <div class="entry-newsleter form-entry">
                    <label><?php echo $Language->get('entry_newsletter'); ?></label>
                    <input type="checkbox" name="newsletter" id="newsletter" value="1" checked="checked"/>
                </div>
                <div class="clearfix"></div>
                <div class="entry-comment form-entry">
                    <label><?php echo $Language->get('entry_enquiry'); ?></label>
                    <div class="clearfix"></div>
                    <textarea name="enquiry" id="enquiry" required="required" placeholder="Ingresa tus comentarios aqu&iacute;..."><?php echo $enquiry; ?></textarea>
                    <?php if ($error_enquiry) { ?><span class="error" id="error_enquiry"><?php echo $error_enquiry; ?></span><?php } ?>
                </div>
                <div class="clearfix"></div>
                <div class="necoform-actions" data-actions="necoform"></div>
            </form>
        </div>
    </div>
    
        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
        </div>
        <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>