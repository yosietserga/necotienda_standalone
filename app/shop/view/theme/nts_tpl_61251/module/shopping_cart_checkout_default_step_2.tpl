<?php if (!$isLogged) { ?>
<!-- address info -->
<section id="necoWizardStep_2" data-wizard="step">
    <div class="recipe-info info-form">
        <fieldset>
            <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                <div class="heading-title">
                    <h3>
                        <i class="heading-icon icon icon-credit-card">
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/credit-card.tpl"); ?>
                        </i>
                        <?php echo $Language->get('legend_recipe_form'); ?>
                    </h3>
                </div>
            </div>
            <?php if ($isLogged) { ?>
            <a href="index.php?r=account/account" title="<?php echo $Language->get('text_update'); ?>"></a>
            <?php } ?>

            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/email.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/referenceby.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/location.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/city.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/street.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/postcode.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/payment/address.tpl"); ?>

        </fieldset>
    </div>
</section>
<!-- /address-info -->
<?php } ?>