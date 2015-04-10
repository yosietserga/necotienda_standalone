<div class="entry-address form-entry">
    <label for="country_id"><?php echo $Language->get('entry_country'); ?></label>
    <select name="country_id" id="country_id" title="Selecciona el pa&iaacute;s dodne reside" onchange="$('select[name=\'zone_id\']').load('index.php?r=account/register/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');">
        <option value="false">Por Favor Seleccione</option>
        <?php foreach ($countries as $country) { ?>
            <option value="<?php echo $country['country_id']; ?>"<?php if ($country['country_id'] == $country_id) { ?> selected="selected"<?php } ?>><?php echo $country['name']; ?></option>
        <?php } ?>
    </select>
</div>