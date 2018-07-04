<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row"> 
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?> 
    <form class="simple-form break" action="<?php echo $action; ?>" method="post" id="messageForm">
        <div class="form-entry">
            <label for="to"><?php echo $entry_to; ?></label>
            <input type="text" id="addresses" name="addresses" value="<?php echo $to; ?>" required="required" title="Ingresa los nombres de los remitentes" style="width:400px" />
            <input type="hidden" id="to" name="to" value="<?php echo $addresses; ?>" />
            <?php if ($error_to) { ?><span class="error" id="error_to"><?php echo $error_to; ?></span><?php } ?>
        </div>

        <div class="form-entry">
            <label for="subject"><?php echo $entry_subject; ?></label>
            <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>" required="required" title="Ingresa el asunto del mensaje" style="width:400px" />
            <?php if ($error_subject) { ?><span class="error" id="error_subject"><?php echo $error_subject; ?></span><?php } ?>
        </div>

        <div class="form-entry">
            <label for="message"><?php echo $entry_message; ?></label>
            <textarea id="message" name="message" required="required"><?php echo $message; ?></textarea>
            <?php if ($error_message) { ?><span class="error" id="error_message"><?php echo $error_message; ?></span><?php } ?>
        </div>
        <div class="necoform-actions" data-actions="necoform"></div>
    </form>
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>