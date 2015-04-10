<!-- catalog  picture -->
<figure class="picture">
    <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" class="thumb" title="<?php echo $product['name']; ?>">
        <img src="<?php echo $product['thumb']; ?>"  alt="<?php echo $product['name']; ?>"/>
    </a>
    <a href="#" class="quick-view" onclick="return quickView('product', '<?php echo $product['product_id']; ?>');"><?php echo $Language->get('text_quick_view'); ?>
    </a>
</figure>
<!--/catalog -picture-->