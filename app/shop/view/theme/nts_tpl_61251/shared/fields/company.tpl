<div class="entry-company form-entry">
    <label><?php echo $Language->get('entry_company'); ?></label>
    <input data-label="<?php echo $Language->get('entry_company');?>" type="text" id="company" name="company" value="<?php echo $company; ?>" title="Ingrese su nombre y apellido si es persona natural sino ingrese el nombre de su organizaci&oacute;n" required="required" placeholder="Ingrese su razón social"/>
    <?php if ($error_company) { ?><span class="error" id="error_company"><?php echo $error_company; ?></span><?php } ?>
</div>