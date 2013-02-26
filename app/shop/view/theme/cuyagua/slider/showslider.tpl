<?php if (count($sliders)) { ?>
<div class="slider-wrapper theme-default">
    <div id="slider" class="nivoSlider">
        <?php foreach ($sliders as $slider) { ?>
            <?php if (empty($slider->image)) continue; ?>
            <?php if (!empty($slider->link)) { ?><a href="<?php echo $slider->link; ?>" title="<?php echo $slider->title; ?>"><?php } ?>
            <img src="<?php echo HTTP_IMAGE . $slider->image; ?>" data-thumb="<?php echo $slider->thumb; ?>" alt="<?php echo $slider->title; ?>"<?php if (!empty($slider->link)) { ?> title="<?php echo $slider->title; ?>"<?php } ?> />
            <?php if (!empty($slider->link)) { ?></a><?php } ?>
        <?php } ?>
    </div> 
</div>
<script>
$(window).load(function() {
    $("#slider").nivoSlider({
        effect:'random', 
        slices:12,
        animSpeed:600,
        pauseTime:6000,
        startSlide:0, 
        directionNav:false, 
        directionNavHide:true, 
        controlNav:true, 
        controlNavThumbs:true, 
        controlNavThumbsFromRel:false,
        controlNavThumbsSearch: '.jpg', 
        controlNavThumbsReplace: '_thumb.jpg',
        keyboardNav:true, 
        pauseOnHover:true, 
        manualAdvance:false, 
        captionOpacity:0.8, 
        beforeChange: function(){},
        afterChange: function(){},
        slideshowEnd: function(){} 
    });
});
</script>
<?php } ?>
