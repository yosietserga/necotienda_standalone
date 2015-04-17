<div class="entry-password form-entry">
    <label><?php echo $Language->get('entry_password'); ?></label>
    <input type="password" name="password" id="password" value="" autocomplete="off" title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares" required="required" showquick="off" />
    <?php if ($error_password) { ?><span class="error" id="error_password"><?php echo $error_password; ?></span><?php } ?>
</div>