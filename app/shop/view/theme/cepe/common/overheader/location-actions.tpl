
<!-- location actions -->
<?php if (count($languages) > 1 || count($currencies) > 1) { ?>
    <li class="location overheader-action large-4 medium-3 small-3 columns nt-editable" data-action="overheader">
        <div data-show="conf">
        </div>
        <strong class="location-heading overheader-heading">
            <i class="icon overheader-icon icon-compass">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/compass.tpl"); ?>
            </i>
            <!--<small class="show-for-large-up">
                <?php echo $Language->get('text_localization'); ?>
            </small>-->
            <!--<i class="icon overheader-icon icon-triangle-down overheader-guide hide-for-small-only">
                <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/triangle-down.tpl"); ?>
            </i>-->
        </strong>
        <div class=" location-lists menu">
            <?php if (count($currencies) > 1) { ?>
                <div class="currencies-list">
                    <span><?php echo $Language->get('text_currencies'); ?>:</span>
                    <?php foreach ($currencies as $currency) { ?>
                        <?php if ($currency['code'] === $currency_code) { ?>
                            <span><?php echo $currency['code']; ?></span>
                        <?php } ?>
                    <?php } ?>
                    <ul class="list">
                        <?php foreach ($currencies as $currency) { ?>
                            <li>
                                <a href="<?php echo $current_url . '&cc=' . $currency["code"];?>">
                                    <?php echo $currency['code']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <?php if (count($languages) > 1) { ?>
                <div class="languages-list">
                    <span><?php echo $Language->get('text_language'); ?>:</span>
                    <?php foreach ($languages as $language) { ?>
                        <?php if ($language['code'] === $language_code) { ?>
                            <span><?php echo $language['name']; ?></span>
                        <?php } ?>
                    <?php } ?>
                    <ul class="list">
                        <?php foreach ($languages as $language) { ?>
                            <li>
                                <a href="<?php echo $current_url . '&hl=' . $language["code"];?>">
                                    <img src="<?php echo $language['image']; ?>" alt="<?php echo $language['name']; ?>"><span><?php echo $language['name']; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </li>
<?php } ?>