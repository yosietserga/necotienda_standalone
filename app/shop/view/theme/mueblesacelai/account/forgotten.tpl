<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent" class="row">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

            <form class="simple-form" action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten">
                <p><?php echo $Language->get('text_email'); ?></p>
                <div class="email-entry form-entry">
                    <label for="email"><?php echo $Language->get('text_your_email'); ?></label>
                    <input type="email" name="email" placeholder="Ingrese su email. E.j: miemail@xxx.com">
                </div>
                <div class="group group--btn">
                    <div class="btn btn--primary">
                        <a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'"><?php echo $Language->get('button_back'); ?></a>
                    </div>
                    <div class="btn btn--primary">
                        <a onclick="$('#forgotten').submit();" class="button"><?php echo $Language->get('button_continue'); ?></a>
                    </div>
                </div>
            </form>
            
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    </section>
</div>
<?php echo $footer; ?>