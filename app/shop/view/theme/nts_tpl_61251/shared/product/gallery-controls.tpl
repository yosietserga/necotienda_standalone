<?php if ($column_left && $column_right) { ?>
    <div style="overflow:hidden; max-height: 21.875rem;" data-slick='{ "slidesToShow": 5,
            "slidesToScroll": 1,
            "vertical": true,
            "arrows": true,
            "swipe": true,
            "verticalSwiping": true,
            "responsive": [
                {
                    "breakpoint": 641,
                    "settings": {
                        "slidesToShow": 5,
                        "vertical": false,
                        "swipe": true,
                        "verticalSwiping": false,
                        "arrows": true
                    }
                }
            ]}'
         id="mainProductGallery" class="large-2 medium-2 small-12 columns" style="float:left">
<?php } else if ($column_left || $column_right) { ?>
    <div data-slick='{"slidesToShow": 5, "slidesToScroll": 1}' id="mainProductGallery">
<?php } else { ?>
    <div data-slick='{"slidesToShow": 7, "slidesToScroll": 1}' id="mainProductGallery">
<?php } ?>
    <?php foreach ($images as $k => $image) { ?>
        <div data-item="thumb">
            <a class="thumb" data-item="thumb" href="#" data-image="<?php echo $image['preview']; ?>" data-zoom-image="<?php echo $image['popup']; ?>">
                <img id="<?php echo "thumb{$k}"; ?>" src="<?php echo $image['thumb']; ?>" />
            </a>
        </div>
    <?php } ?>
</div>
