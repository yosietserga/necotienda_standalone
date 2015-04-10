<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
        <?php if ($heading_title) { ?>
            <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                <div class="heading-title">
                    <h3>
                        <i class="icon heading-icon fa fa-phone fa-2x"></i>
                        <?php echo $heading_title; ?>
                    </h3>
                </div>
            </div>
        <?php } ?>
        <div class="contact-page">
            <div class="row">
                <div class="contact-info large-3 medium-3 small-12 columns">
                    <!--<h1><?php echo $store; ?></h1>-->
                    <?php if ($contact_page) { echo $contact_page; } ?>
                    <?php if ($google_maps) { echo $google_maps; } ?>
                    <p class="store-address">
                        <?php echo $Language->get('text_address'); ?><?php echo $address; ?>
                    </p>
                    <?php if ($telephone) { ?>
                        <p>
                            <?php echo $Language->get('text_telephone'); ?><?php echo $telephone; ?>
                        </p>
                    <?php } ?>
                </div>
                <?php if (isset($success)) { ?><div class="message success"><?php echo $success; ?></div><?php } ?>
                <div class="large-9 medium-9 small-12 columns">
                    <div class="simple-form contact-form break">
                        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="contact">
                            <div class="input-row row">
                                <div class="large-6 medium-6 small-6 columns">

                                    <div class="entry-name form-entry">
                                        <label><?php echo $Language->get('entry_name'); ?></label>
                                        <input type="text" name="name" id="name" value="<?php echo $name; ?>" required="required" placeholder="Nombre Completo" />
                                        <?php if ($error_name) { ?><span class="error" id="error_name"><?php echo $error_name; ?></span><?php } ?>
                                    </div>

                                </div>
                                <div class="large-6 medium-6 small-6 columns">

                                    <div class="entry-email form-entry">
                                        <label><?php echo $Language->get('entry_email'); ?></label>
                                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" required="required" placeholder="Email" />
                                        <?php if ($error_email) { ?><span class="error" id="error_email"><?php echo $error_email; ?></span><?php } ?>
                                    </div>

                                </div>
                            </div>

                            <div class="entry-newsleter form-entry">
                                <label for="newsletter"><?php echo $Language->get('entry_newsletter'); ?></label>
                                <input type="checkbox" name="newsletter" id="newsletter" value="1" checked="checked"/>
                            </div>

                            <div class="entry-comment form-entry">
                                <label><?php echo $Language->get('entry_enquiry'); ?></label>
                                <textarea name="enquiry" id="enquiry" required="required" placeholder="Ingresa tus comentarios aqu&iacute;..."><?php echo $enquiry; ?></textarea>
                                <?php if ($error_enquiry) { ?><span class="error" id="error_enquiry"><?php echo $error_enquiry; ?></span><?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>