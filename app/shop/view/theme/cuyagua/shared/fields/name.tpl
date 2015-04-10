<div class="name-entry form-entry">
    <label><?php echo $Language->get('entry_firstname'); ?></label>
    <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" title="Ingrese sus nombres" required="required" />
    <?php if ($error_firstname) { ?><span class="error" id="error_firstname"><?php echo $error_firstname; ?></span><?php } ?>
</div>