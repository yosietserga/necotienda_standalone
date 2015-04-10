<?php if ($product['rating']) { ?>
    <div class="rating">
        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
    </div>
<?php }else { ?>
    <div class="rating" style="min-height: 1.063em; width: 100%;">
    </div>
<?php }?>