<div class="entry-rif form-entry">
    <label><?php echo $Language->get('entry_rif'); ?></label>
    <div class="row collapse">
        <div class="large-2 medium-2 small-2 columns">
            <select name="riftype" title="Selecciona el tipo de documentaci&oacute;n">
                <option value="V" <?php if (strtolower($rif_type) == 'v') echo 'selected="selected"'; ?>>V</option>
                <option value="J" <?php if (strtolower($rif_type) == 'j') echo 'selected="selected"'; ?>>J</option>
                <option value="E" <?php if (strtolower($rif_type) == 'e') echo 'selected="selected"'; ?>>E</option>
                <option value="G" <?php if (strtolower($rif_type) == 'g') echo 'selected="selected"'; ?>>G</option>
            </select>
        </div>
        <div class="large-10 medium-10 small-10 columns">
            <input type="rif" id="rif" name="rif" value="<?php echo $rif; ?>" title="Por favor ingrese su RIF. Si es persona natural y a&uacute;n no posee uno, ingrese su n&uacute;mero de c&eacute;dula con un n&uacute;mero cero al final" required="required" placeholder="Ingrese su rif o cedula de indentidad"/>
        </div>
    </div>
    <?php if ($error_rif) { ?><span class="error" id="error_rif"><?php echo $error_rif; ?></span><?php } ?>
</div>

