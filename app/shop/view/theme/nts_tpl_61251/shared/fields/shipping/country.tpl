<div class="property form-entry">
    <label for="shipping_country_id"><?php echo $Language->get('entry_country'); ?></label>
    <select name="shipping_country_id" id="shipping_country_id" title="<?php echo $Language->get('help_country'); ?>" onchange="$('select[name=\'shipping_zone_id\']').load('index.php?r=account/register/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');">
        <option value="false">-- Por Favor Seleccione --</option>
        <?php foreach ($countries as $country) { ?>
            <?php if ($country['country_id'] == $shipping_country_id) { ?>
                <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
            <?php } else { ?>
                <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
            <?php } ?>
        <?php } ?>
    </select>
</div>