<div class="last-name-entry form-entry">
    <label><?php echo $Language->get('entry_lastname'); ?></label>
    <input type="lastname" id="lastname" name="lastname" value="<?php echo $lastname; ?>" title="Ingrese sus apellidos" required="required" placeholder="Ingrese su apellido(s)" />
    <?php if ($error_lastname) { ?><span class="error" id="error_lastname"><?php echo $error_lastname; ?></span><?php } ?>
</div>