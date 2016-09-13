<div class="entry-confirm form-entry">
    <label><?php echo $Language->get('entry_confirm'); ?></label>
    <input data-label="<?php echo $Language->get('entry_confirm'); ?>" type="password" name="confirm" id="confirm" value="" autocomplete="off" title="Vuelva a escribir la contrase&ntilde;a"/>
    <?php if ($error_confirm) { ?><span class="error" id="error_confirm"><?php echo $error_confirm; ?></span><?php } ?>
</div>