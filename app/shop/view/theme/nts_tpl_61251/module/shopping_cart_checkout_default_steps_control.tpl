<ul class="neco-wizard-controls" data-wizard="controls">
    <li id="necoWizardControl_1" data-wizard="nav" data-wizard-step="basket">
        <span><?php echo $Language->get('text_basket'); ?></span>
    </li>

    <?php if (!$isLogged) { ?>
    <li id="necoWizardControl_2" data-wizard="nav" data-wizard-step="billing">
        <span><?php echo $Language->get('text_billing'); ?></span>
    </li>
    <?php } ?>

    <?php if ($shipping_methods || (!$isLogged || ($isLogged && !$shipping_country_id))) { ?>

    <li id="necoWizardControl_3" data-wizard="nav" data-wizard-step="shipping">
        <span><?php echo $Language->get('text_shipping'); ?></span>
    </li>

    <?php }?>

    <li id="necoWizardControl_4" data-wizard="nav" data-wizard-step="confirm">
        <span><?php echo $Language->get('text_confirm'); ?></span>
    </li>

    <li id="necoWizardControl_5" data-wizard="nav" data-wizard-step="complete">
        <span><?php echo $Language->get('text_complete'); ?></span>
    </li>
</ul>