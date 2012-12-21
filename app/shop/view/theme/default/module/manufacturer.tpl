<div class="box manufacturerModule">
    <div class="header"><?php echo $heading_title; ?></div>
    <div class="content">
        <select onchange="location = this.value">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($manufacturers as $manufacturer) { ?>
                <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
                    <option value="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                <?php } else { ?>
                    <option value="<?php echo str_replace('&', '&amp;', $manufacturer['href']); ?>"><?php echo $manufacturer['name']; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>
