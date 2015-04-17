<div class="name-entry form-entry">
    <label><?php echo $Language->get('entry_firstname'); ?></label>
    <input type="firstname" id="firstname" name="firstname" value="<?php echo $firstname; ?>" title="Ingrese sus nombres" required="required" placeholder="Ingrese su nombre(s)"/>
    <?php if ($error_firstname) { ?><span class="error" id="error_firstname"><?php echo $error_firstname; ?></span><?php } ?>
</div>