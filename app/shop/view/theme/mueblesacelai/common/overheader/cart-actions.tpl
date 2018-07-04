<!-- cart-actions -->
<div class="cart large-3 columns nt-menu nt-editable show-for-large-up">
        <div data-request="cart" data-show="conf" style="cursor: pointer;"></div>
        <strong>
            <i class="icon icon-cart">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/cart.tpl"); ?>
            </i>
            <span class="added-count"><em>
                <?php echo count($this->cart->getProducts());?></em>
            </span>
            <!--<small class="show-for-large-up">
                <?php echo $Language->get('text_cart'); ?>
            </small>-->
            <!--<i class="icon overheader-icon icon-triangle-down overheader-guide hide-for-small-only">
                <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/triangle-down.tpl"); ?>
            </i>-->
        </strong>
        <div id="cartPanel" class="cart-panel menu nt-menu nt-menu-down nt-editable" data-component="cart-overview" data-resource='<?php include(DIR_TEMPLATE. $this->config->get('config_template') . '/shared/icons/loader.tpl'); ?>'>
        <ul></ul>
    </div>
</div>
<!--/cart-actions -->