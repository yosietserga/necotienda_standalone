<?php echo $header; ?>
<?php echo $navigation; ?>
<!-- cart-chekcout -->

<!-- HACK for the accept and cancel button appearing in all stages of the card page
     This will only make show the buttons oin the billing step -->

<style>
ul:not([data-current-step="billing"]) ~ form .action-accept,
ul:not([data-current-step="billing"]) ~ form .action-cancel {
   display: none !important;
}
</style>
    


<section id="maincontent" class="row">
    <div class="cart-checkout">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
        <div class="checkout-heading large-12 small-12 medium-12 columns">
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <span>
                <?php if ($weight) { ?>
                     <span id="weight"><?php echo $Language->get('text_cart_weight'); ?>&nbsp;<?php echo $weight; ?></span>
                <?php } ?>
            </span>
        </div>
        <div id="contentWrapper" class="large-12 small-12 medium-12 columns break">
            <!-- neco wizard -->
                <ul class="neco-wizard-controls" data-wizard="controls">
                    <li data-wizard="nav" data-wizard-step="basket">
                        <span><?php echo $Language->get('text_basket'); ?></span>
                    </li>

                    <?php if (!$isLogged) { ?>
                    <li data-wizard="nav" data-wizard-step="billing">
                        <span><?php echo $Language->get('text_billing'); ?></span>
                    </li>
                    <?php } ?>

                    <?php if ($shipping_methods || (!$isLogged || ($isLogged && !$shipping_country_id))) { ?>

                    <li data-wizard="nav" data-wizard-step="shipping">
                        <span><?php echo $Language->get('text_shipping'); ?></span>
                    </li>

                    <?php }?>

                    <li data-wizard="nav" data-wizard-step="confirm">
                        <span><?php echo $Language->get('text_confirm'); ?></span>
                    </li>

                    <li data-wizard="nav" data-wizard-step="complete">
                        <span><?php echo $Language->get('text_complete'); ?></span>
                    </li>
                </ul>

                <?php if (!empty($message)) { ?>
                    <div class="message warning"><?php echo $message; ?></div>
                <?php } ?>

                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" id="orderForm" data-wizard="form">
                    <div class="neco-wizard-steps" data-wizard="steps">

                        <!-- recipe-info -->
                        <section data-wizard="step">
                            <div class="cart-detail">
                                <table class="cart-recipe">
                                    <thead>
                                        <tr>
                                            <th><?php echo $Language->get('column_image'); ?></th>
                                            <th><?php echo $Language->get('column_name'); ?></th>
                                            <th><?php echo $Language->get('column_model'); ?></th>
                                            <th><?php echo $Language->get('column_quantity'); ?></th>
                                            <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                <th><?php echo $Language->get('column_price'); ?></th>
                                                <th><?php echo $Language->get('column_total'); ?></th>
                                            <?php } ?>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td><a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>

                                            <td>
                                                <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                                                    <?php echo $product['name']; ?>
                                                </a>
                                                <div>
                                                    <?php foreach ($product['option'] as $option) { ?>
                                                        - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                                                    <?php } ?>
                                                </div>
                                            </td>

                                            <td data-label="<?php echo $Language->get('column_model'); ?>"><?php echo $product['model']; ?></td>

                                            <td data-label="<?php echo $Language->get('column_quantity'); ?>">
                                                <input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" showquick="off" size="3"  onchange="refreshCart(this,'<?php echo $product['key']; ?>')" />

                                                <a class="update-product" onclick="refreshCart(this,'<?php echo $product['key']; ?>')" title="<?php echo $Language->get('text_update'); ?>">
                                                </a>
                                            </td>
                                            <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                <td data-label="<?php echo $Language->get('column_price'); ?>"><?php echo $product['price']; ?></td>
                                                <td data-label="<?php echo $Language->get('column_total'); ?>"><?php echo $product['total']; ?></td>
                                            <?php } ?>
                                            <td>
                                                <a class="delete-product" onclick="deleteCart(this,'<?php echo $product['key']; ?>')" title="<?php echo $Language->get('text_delete'); ?>">
                                                    <i class="cart-icon icon icon-bin">
                                                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/bin.tpl"); ?>
                                                    </i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                                    <table id="totals" class="cart-totals">
                                        <?php foreach ($totals as $total) { ?>
                                            <tr>
                                                <td><?php echo $total['title']; ?></td>
                                                <td><?php echo $total['text']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php } ?>
                            </div>
                        </section>
                        <!-- recipe info -->

                        <?php if (!$isLogged) { ?>

                        <!-- address info -->
                        <section data-wizard="step">
                            <div class="recipe-info info-form">
                                <fieldset>
                                    <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
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

                                    <div class="property form-entry email-entry">
                                        <label for="email"><?php echo $Language->get('text_email'); ?>: </label>
                                        <input type="email" name="email" id="email" placeholder="<?php echo $Language->get('entry_email'); ?>" value="<?php echo isset($email) ? $email : ''; ?>" required="required" title="<?php echo $Language->get('help_email'); ?>" <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                    </div>

                                    <div class="property form-entry name-entry">
                                        <label for="firstname"><?php echo $Language->get('text_firstname'); ?>:</label>
                                        <input type="firstname" placeholder="<?php echo $Language->get('entry_firstname'); ?>" id="firstname" name="firstname" required="required" value="<?php echo isset($firstname) ? $firstname : ''; ?>"  <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                    </div>

                                    <div class="property form-entry lastname-entry">
                                        <label for="lastname"><?php echo $Language->get('text_lastname'); ?>:</label>
                                        <input type="lastname" placeholder="<?php echo $Language->get('entry_lastname'); ?>" id="lastname" name="lastname" required="required" value="<?php echo isset($lastname) ? $lastname : ''; ?>"  <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                    </div>

                                    <div class="property form-entry company-entry company-entry">
                                        <label for="company"><?php echo $Language->get('text_company'); ?>:</label>
                                        <input type="text" placeholder="<?php echo $Language->get('entry_company'); ?>" id="company" name="company" required="required" value="<?php echo isset($company) ? $company : ''; ?>"  <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                    </div>

                                    <div class="property form-entry rif-entry">
                                        <label for="rif"><?php echo $Language->get('text_rif'); ?>:</label>
                                        <div class="row collapse">
                                            <div class="large-2 medium-2 small-2 columns">
                                                <select name="riftype" title="<?php echo $Language->get('help_riftype'); ?>">
                                                    <option value="V" <?php if (strtolower($rif_type) == 'v') echo 'selected="selected"'; ?>>V</option>
                                                    <option value="J" <?php if (strtolower($rif_type) == 'j') echo 'selected="selected"'; ?>>J</option>
                                                    <option value="E" <?php if (strtolower($rif_type) == 'e') echo 'selected="selected"'; ?>>E</option>
                                                    <option value="G" <?php if (strtolower($rif_type) == 'g') echo 'selected="selected"'; ?>>G</option>
                                                </select>
                                            </div>
                                            <div class="large-10 medium-10 small-12 columns">
                                                <input type="text" id="rif" name="rif" placeholder="<?php echo $Language->get('entry_rif'); ?>" value="<?php echo isset($rif) ? $rif : ''; ?>" required="required" maxlength="10" title="<?php echo $Language->get('help_rif'); ?>" quicktip="Ingresa tu n�mero de c�dula si eres una persona natural y no posees RIF. Ingresa solo n�meros" <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="property form-entry phone-entry">
                                        <label for="telephone">T&eacute;lefono:</label>
                                        <input type="phone" id="telephone" name="telephone" placeholder="<?php echo $Language->get('entry_telephone'); ?>" required="required" value="<?php echo isset($telephone) ? $telephone : ''; ?>"  <?php if ($isLogged) echo 'disabled="disabled"'; ?> />
                                    </div>

                                    <div class="property form-entry refenceby-entry"<?php if ($isLogged) echo ' style="display:hidden"'; ?>>
                                        <label for="referencedBy"><?php echo $Language->get('entry_referencedBy'); ?></label>
                                        <input type="text" id="referencedBy" placeholder="<?php echo $Language->get('entry_referencedBy'); ?>" name="referencedBy" value="<?php echo isset($referencedBy) ? $referencedBy : ''; ?>" />
                                    </div>

                                    <div class="property form-entry location-entry">
                                        <div class="row">
                                            <div class="large-6 medium-6 small-12 columns property country-entry">
                                                <label for="payment_country_id"><?php echo $Language->get('entry_country'); ?></label>
                                                <select name="payment_country_id" id="payment_country_id" title="<?php echo $Language->get('help_country'); ?>" onchange="$('select[name=\'payment_zone_id\']').load('index.php?r=account/register/zone&country_id=' + this.value + '&zone_id=<?php echo $payment_zone_id; ?>');">
                                                    <option value="false">-- Por Favor Seleccione --</option>
                                                    <?php foreach ($countries as $country) { ?>
                                                        <?php if ($country['country_id'] == $payment_country_id) { ?>
                                                    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                                        <?php } else { ?>
                                                    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="large-6 medium-6 small-12 columns property zone-entry">
                                                <label for="payment_zone_id"><?php echo $Language->get('entry_zone'); ?></label>
                                                <select name="payment_zone_id" id="payment_zone_id" title="<?php echo $Language->get('help_zone'); ?>">
                                                    <option value="false">-- Seleccione un pa&iacute;s --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="property form-entry">
                                        <label for="payment_city"><?php echo $Language->get('entry_city'); ?></label>
                                        <input type="text" id="payment_city" name="payment_city" placeholder="<?php echo $Language->get('entry_city'); ?>" value="<?php echo $payment_city; ?>" required="required" title="<?php echo $Language->get('help_city'); ?>" />
                                    </div>

                                    <div class="property form-entry">
                                        <label for="payment_street"><?php echo $Language->get('entry_street'); ?></label>
                                        <input type="text" id="payment_street" name="payment_street" placeholder="<?php echo $Language->get('entry_street'); ?>" value="<?php echo $payment_street; ?>" required="required" title="<?php echo $Language->get('help_street'); ?>" />
                                    </div>

                                    <div class="property form-entry">
                                        <label for="payment_postcode"><?php echo $Language->get('entry_postcode'); ?></label>
                                        <input type="text" id="payment_postcode" placeholder="<?php echo $Language->get('entry_postcode'); ?>" name="payment_postcode" value="<?php echo $payment_postcode; ?>" required="required" title="<?php echo $Language->get('help_postcode'); ?>" />
                                    </div>

                                    <div class="property form-entry">
                                        <label for="payment_address_1"><?php echo $Language->get('entry_address_1'); ?></label>
                                        <input type="text" id="payment_address_1" placeholder="<?php echo $Language->get('entry_address_1'); ?>" name="payment_address_1" value="<?php echo $payment_address_1; ?>" required="required" title="<?php echo $Language->get('help_address'); ?>" />
                                    </div>
                                </fieldset>
                                <!--<p>Al continuar con el proceso de compra, usted est&aacute; aceptando los <a href="<?php echo $Url::createUrl('content/page',array('page_id'=>$Config->get('config_checkout_id'))); ?>">t&eacute;rminos legales y las condiciones de uso</a> de este sitio web.</p>-->
                            </div>
                        </section>
                    <?php } ?>
                    <!-- /address-info -->

                    <!--shipping-section -->
                    <?php if ($shipping_methods || (!$isLogged || ($isLogged && !$shipping_country_id))) { ?>
                    <section data-wizard="step">
                        <div class="delivery-form info-form">
                            <?php if (!$isLogged || ($isLogged && !$shipping_country_id)) { ?>
                                <fieldset>
                                    <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                                        <div class="heading-title">
                                            <h3>
                                                <i class="heading-icon icon icon-truck">
                                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/truck.tpl"); ?>
                                                </i>
                                                <?php echo $Language->get('legend_shipping_form'); ?>
                                            </h3>
                                        </div>
                                    </div>
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

                                <div class="property form-entry">
                                    <label for="shipping_zone_id"><?php echo $Language->get('entry_zone'); ?></label>
                                    <select name="shipping_zone_id" id="shipping_zone_id" title="<?php echo $Language->get('help_zone'); ?>">
                                        <option value="false">-- <?php echo $Language->get('select_country_text'); ?> --</option>
                                    </select>
                                </div>

                                <div class="property form-entry">
                                    <label for="shipping_city"><?php echo $Language->get('entry_city'); ?></label>
                                    <input type="text" id="shipping_city" name="shipping_city" value="<?php echo $shipping_city; ?>" required="required" title="<?php echo $Language->get('help_city'); ?>" />
                                </div>

                                <div class="property form-entry">
                                    <label for="shipping_street"><?php echo $Language->get('entry_street'); ?></label>
                                    <input type="text" id="shipping_street" name="shipping_street" value="<?php echo $shipping_street; ?>" required="required" title="<?php echo $Language->get('help_street'); ?>" />
                                </div>

                                <div class="property form-entry">
                                    <label for="shipping_postcode"><?php echo $Language->get('entry_postcode'); ?></label>
                                    <input type="text" id="shipping_postcode" name="shipping_postcode" value="<?php echo $shipping_postcode; ?>" required="required" title="<?php echo $Language->get('help_postcode'); ?>" />
                                </div>

                                <div class="property form-entry">
                                    <label for="shipping_address_1"><?php echo $Language->get('entry_address_1'); ?></label>
                                    <input type="text" id="shipping_address_1" name="shipping_address_1" value="<?php echo $shipping_address_1; ?>" required="required" title="<?php echo $Language->get('help_address'); ?>" />
                                </div>

                                <input type="hidden" name="payment_country_id" id="payment_country_id" value="<?php echo $payment_country_id; ?>" />
                                <input type="hidden" name="payment_zone_id" id="payment_zone_id" value="<?php echo $payment_zone_id; ?>" />
                                <input type="hidden" name="payment_street" id="payment_street" value="<?php echo $payment_street; ?>" />
                                <input type="hidden" name="payment_city" id="payment_city" value="<?php echo $payment_city; ?>" />
                                <input type="hidden" name="payment_postcode" id="payment_postcode" value="<?php echo $payment_postcode; ?>" />
                                <input type="hidden" name="payment_address_1" id="payment_address_1" value="<?php echo $payment_address_1; ?>" />
                            </fieldset>
                            <?php } else { ?>
                                <input type="hidden" name="payment_country_id" id="payment_country_id" value="<?php echo $payment_country_id; ?>" />
                                <input type="hidden" name="payment_zone_id" id="payment_zone_id" value="<?php echo $payment_zone_id; ?>" />
                                <input type="hidden" name="payment_city" id="payment_city" value="<?php echo $payment_city; ?>" />
                                <input type="hidden" name="payment_street" id="payment_street" value="<?php echo $payment_street; ?>" />
                                <input type="hidden" name="payment_postcode" id="payment_postcode" value="<?php echo $payment_postcode; ?>" />
                                <input type="hidden" name="payment_address_1" id="payment_address_1" value="<?php echo $payment_address_1; ?>" />

                                <input type="hidden" name="shipping_country_id" id="shipping_country_id" value="<?php echo $shipping_country_id; ?>" />
                                <input type="hidden" name="shipping_zone_id" id="shipping_zone_id" value="<?php echo $shipping_zone_id; ?>" />
                                <input type="hidden" name="shipping_city" id="shipping_city" value="<?php echo $shipping_city; ?>" />
                                <input type="hidden" name="shipping_street" id="shipping_street" value="<?php echo $shipping_street; ?>" />
                                <input type="hidden" name="shipping_postcode" id="shipping_postcode" value="<?php echo $shipping_postcode; ?>" />
                                <input type="hidden" name="shipping_address_1" id="shipping_address_1" value="<?php echo $shipping_address_1; ?>" />
                            <?php } ?>

                            <?php if ($shipping_methods) { ?>
                            <div class="shipping-methods break">
                                <fieldset>
                                    <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                                        <div class="heading-title">
                                            <h3>
                                                <i class="heading-icon icon icon-envelope">
                                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/envelope.tpl"); ?>
                                                </i>
                                                <?php echo $Language->get('text_shipping_methods'); ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th><?php echo $Language->get('table_head_shipping_select'); ?></th>
                                                <th><?php echo $Language->get('table_head_shipping_method'); ?></th>
                                                <th><?php echo $Language->get('table_head_shipping_price'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($shipping_methods as $shipping_method) { ?>
                                            <?php foreach ($shipping_method['quote'] as $quote) { ?>
                                            <tr>
                                                <td data-label="<?php echo $Language->get('table_head_shipping_select'); ?>">
                                                    <div class="check-action">
                                                        <input data-check="order" type="checkbox" name="shipping_method" value="<?php echo $quote['id']; ?>" />
                                                        <span class="radio-button"></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php echo $quote['title']; ?>
                                                </td>
                                                <td data-label="<?php echo $Language->get('table_head_shipping_price'); ?>">
                                                    <?php echo $quote['text']; ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </fieldset>
                            </div>
                            <?php } ?>
                        </div>
                    </section>
                    <?php } ?>
                    <!--/shipping section-->

                    <!--payment section -->
                    <section data-wizard="step" class="break">
                        <div class="payment-section row">
                            <div class="recipe-data large-6 medium-6 small-12 columns data">
                                <h3 class="payment-heading data-heading"><?php echo $Language->get('text_order_confirm'); ?></h3>
                                <ul class="confirmOrder">
                                    <li>
                                        <span><?php echo $Language->get('text_company'); ?>:</span>
                                        <span id="confirmCompany"><?php echo $company; ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo $Language->get('text_rif'); ?>:</span>
                                        <span id="confirmRif"><?php echo $riff; ?></span>
                                    </li>
                                    <li>
                                        <span><?php echo $Language->get('text_address'); ?>:</span>
                                        <span id="confirmPaymentAddress"><?php echo $payment_address; ?></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="shipping-data large-6 medium-6 small-12 columns data">
                                <h3 class="shipping-heading data-heading"><?php echo $Language->get('text_shipping_address_and_method'); ?></h3>
                                <ul class="confirmOrder">
                                    <?php if ($shipping_methods) { ?>
                                    <li>
                                        <span><?php echo $Language->get('text_payment_shipping_method'); ?>:</span>
                                        <span id="shipping_method"></span>
                                    </li>
                                    <?php } ?>
                                    <li>
                                        <span><?php echo $Language->get('text_payment_address'); ?>:</span>
                                        <span id="confirmShippingAddress"><?php echo $shipping_address; ?></span>
                                    </li>
                                </ul>
                            </div>

                            <div class="cart-summary large-12 medium-6 small-12 columns">
                                <table class="cart-recipe">
                                    <thead>
                                        <tr>
                                            <th><?php echo $Language->get('text_summary_description'); ?></th>
                                            <th><?php echo $Language->get('text_summary_model');?></th>
                                            <th><?php echo $Language->get('text_summary_cant');?></th>
                                            <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                                                <th><?php echo $Language->get('text_summary_price');?></th>
                                                <th><?php echo $Language->get('text_summary_total');?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $product) { ?>
                                            <tr id="confirmItem<?php echo $product['product_id']; ?>">
                                                <td>
                                                    <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                                                        <?php echo $product['name']; ?>
                                                    </a>
                                                    <div>
                                                        <?php foreach ($product['option'] as $option) { ?>- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo $Language->get('text_summary_model'); ?>">
                                                    <?php echo $product['model']; ?>
                                                </td>
                                                <td data-label="<?php echo $Language->get('text_summary_cant'); ?>" id="confirmQty<?php echo $product['product_id']; ?>">
                                                    <?php echo $product['quantity']; ?>
                                                </td>
                                                <?php if ($display_price && $Config->get('config_store_mode') === 'store') { ?>
                                                    <td data-label="<?php echo $Language->get('text_summary_price'); ?>">
                                                        <?php echo $product['price']; ?>
                                                    </td>
                                                    <td data-label="<?php echo $Language->get('text_summary_total'); ?>" id="confirmTotal<?php echo $product['product_id']; ?>">
                                                        <?php echo $product['total']; ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                                <table id="totalsConfirm" class="cart-totals">
                                    <?php foreach ($totals as $total) { ?>
                                        <tr>
                                            <td><?php echo $total['title']; ?></td>
                                            <td><?php echo $total['text']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            <?php } ?>
                            </div>
                            <div class="confirmation-comment large-12 medium-12 small-12 columns">
                                <textarea name="comment" placeholder="Ingresa tus comentarios sobre el pedido aqu&iacute;"></textarea>
                            </div>
                        </div>
                    </section>
                    <!-- payment-section-->

                    <!--  request-section -->
                    <section data-wizard="step">
                        <div style="width:300px;margin: 2.75rem auto;text-align: center;"><img src="<?php echo HTTP_IMAGE; ?>load.gif" alt="Cargando..." /></div>
                    </section>
                    <!--  request-section -->
                </div>
            </form>
            <!-- /neco-wizard -->

        </div>
        <!-- /content-wrapper -->
    </div>

    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

</section>
<!-- cart-checkout -->
<?php echo $footer; ?>