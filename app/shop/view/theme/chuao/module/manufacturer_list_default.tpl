<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

<select onchange="location = this.value">
    <option value=""><?php echo $Language->get('text_select'); ?></option>

    <?php foreach ($manufacturers as $manufacturer) { ?>

        <option value="<?php echo $Url::createUrl("store/manufacturer", array("manufacturer_id" => $manufacturer['manufacturer_id'])); ?>"<?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?> selected="selected"<?php } ?>>
            <?php echo $manufacturer['name']; ?>
        </option>

    <?php } ?>
</select>