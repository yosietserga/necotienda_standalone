<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>

    <div class="sort simple-form">
        <input type="text" name="filter_order" id="filter_order" value="" placeholder="Buscar Pedido..." />
        <?php echo $text_sort; ?>
        <a href="#" id="filter" class="action-button">Filtrar</a>
    </div>

    <ul id="paymentMethods" class="nt-editable payment-methods">
        <?php foreach ($payment_methods as $payment_method) { ?>
            <li>{%<?php echo $payment_method['id']; ?>%}</li>
        <?php } ?>
    </ul>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>