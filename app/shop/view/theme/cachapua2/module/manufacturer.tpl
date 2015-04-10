<li class="nt-editable manufacturer-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-cogs fa-2x"></i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        <div class="simple-form">
            <div class="form-entry">
                <select onchange="location = this.value">
                    <option value=""><?php echo $Language->get('text_select'); ?></option>
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
    </div>
</li>
