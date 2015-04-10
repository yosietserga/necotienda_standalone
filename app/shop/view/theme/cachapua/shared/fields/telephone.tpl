<div class="entry-telephone form-entry">
    <label><?php echo $Language->get('entry_telephone'); ?></label>
    <input type="phone" id="telephone" name="telephone" value="<?php echo $telephone; ?>" title="Ingrese su n&uacute;mero de tel&eacute;fono" required="required" placeholder="Ingrese su teléfono. E.j: 0412.777.77.77" />
    <?php if ($error_telephone) { ?><span class="error" id="error_telephone"><?php echo $error_telephone; ?></span><?php } ?>
</div>