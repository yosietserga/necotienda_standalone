<figure class="picture">

    <div class="items">
        <img src="<?php echo $product['images'][0]['preview']; ?>" alt=""/>
    </div>

        
    <?php if (!empty($product["images"]) && (count($product["images"]) > 1)) { ?>
    <div class="thumbs<?php if (count($product["images"]) > 3) { echo ' scrollImg'; } ?>">
    <?php foreach($product["images"] as $image) { ?>
        <img src="<?php echo $image['thumb'];?>" alt="" data-preview="<?php echo $image['preview'];?>" />
    <?php } ?>

    </div>
    <?php } ?>

    <a href="javascript:;" class="quick-view" onclick="return quickView('product', '<?php echo $product['product_id']; ?>', this);">
        <?php echo $Language->get('text_quick_view'); ?>
    </a>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/sticker.tpl"); ?>
</figure>