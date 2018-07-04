<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

     <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <div class="simple-form break">
        <div class="form-entry">
            <input type="text" name="filter_order" id="filter_order" value="" placeholder="Buscar Pedido..." />
        </div>
        <?php echo $text_sort; ?>
        <div class="btn btn-filter btn--primary" data-action="filter" role="button" aria-label="Sort">
            <a href="#" id="filter"><?php echo $Language->get('text_filter');?></a>
        </div>
    </div>

    <ul id="paymentMethods" class="nt-editable payment-methods">
        <?php foreach ($payment_methods as $payment_method) { ?>
            <li data-action="payment">{%<?php echo $payment_method['id']; ?>%}</li>
        <?php } ?>
    </ul>
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/payment-methods.tpl"); ?>
<?php echo $footer; ?>