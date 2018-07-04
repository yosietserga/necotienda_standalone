    <?php $imagesCopy = array_slice($images, 0);?>
    <?php if ($column_left && $column_right) { ?>
        <div class="product-preview large-10 medium-10 small-12 columns" style="float:right">
            <img itemprop="image" class="view" id="mainProduct" src="<?php echo $imagesCopy[0]['preview']; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $imagesCopy[0]['popup']; ?>"/>
        </div>
    <?php } else if ($column_left || $column_right) { ?>
        <img itemprop="image" class="product-preview view" id="mainProduct" src="<?php echo $imagesCopy[0]['preview']; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $imagesCopy[0]['popup']; ?>"/>
    <?php } else { ?>
        <img itemprop="image" class="product-preview view" id="mainProduct" src="<?php echo $imagesCopy[0]['preview']; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $imagesCopy[0]['popup']; ?>"/>
    <?php } ?>
