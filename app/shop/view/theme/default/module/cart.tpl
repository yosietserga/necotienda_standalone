<li id="module_cart" class="box cartModule">
    <div class="header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div>
    <div class="content">
    <?php if ($products) { ?>
        <?php foreach ($products as $product) { ?>
        <div class="cartProduct">
            <span class="cartRemove" id="remove_<?php echo $product['key']; ?>">&nbsp;</span>
            <?php echo $product['quantity']; ?>&nbsp;x&nbsp;
            <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>"><?php echo $product['name']; ?></a>
            <?php foreach ($product['option'] as $option) { ?>
                <div class="cartProductOption">- <?php echo $option['name']; ?> <?php echo $option['value']; ?></div>
            <?php } ?>
        </div>
        <?php } ?>
        <br />
        <?php foreach ($totals as $total) { ?>
            <div class="cartModuleTotal"><b><?php echo $total['title']; ?></b></div>
            <div class="cartModuleTotal"><?php echo $total['text']; ?></div>
            <div class="clear"></div>
        <?php } ?>
        <div class="cartLinks">
            <a title="<?php echo $text_view; ?>" href="<?php echo $view; ?>"><?php echo $text_view; ?></a> | 
            <a title="<?php echo $text_checkout; ?>" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a>
        </div>
    <?php } else { ?>
        <div style="text-align: center;"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
</li>