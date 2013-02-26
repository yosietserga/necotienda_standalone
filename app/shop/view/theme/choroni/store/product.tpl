<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="clear"></div>

<?php if (isset($featured)) { ?>
<section id="featured">
    <div class="container_16">
        <div class="grid_16"><?php echo $showslider; ?></div>
    </div>
</section>
<div class="clear"></div>
<?php } ?>

<section id="maincontent">

<?php if (isset($column_left)) { ?>
    <aside id="column_left"><?php echo $column_left; ?></aside>
<?php } ?>

    <section id="content">
    
        <?php if (isset($column_left) && isset($column_right)) { ?>
        <div class="grid_4">
        <?php } elseif (isset($column_left) || isset($column_right)) { ?>
        <div class="grid_6">
        <?php } else { ?>
        <div class="grid_8">
        <?php } ?>
    
            <div id="images">
                <div id="popup">
                    <img src="<?php echo str_replace('&', '&amp;', $popup); ?>" alt="<?php echo $heading_title; ?>" id="image" />
                </div>
            </div>
        
            <?php if ($images) { ?>
            <div id="imageScroller">
            
                <ul id="productCarousel" class="jcarousel-skin-tango">
                <?php foreach ($images as $k => $image) { ?>
                
                <li><a title="<?php echo $heading_title; ?>">
                        <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                        <input type="hidden" name="img_<?php echo $k; ?>" value="<?php echo str_replace('&', '&amp;', $image['preview']); ?>" class="preview" />
                        <input type="hidden" name="popup_<?php echo $k; ?>" value="<?php echo str_replace('&', '&amp;', $image['popup']); ?>" class="popup" />
                        <a style="display: none;" href="<?php echo str_replace('&', '&amp;', $image['popup']); ?>" rel="product_images">
                            <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                        </a>
                    </a>
                </li>
                
                <?php } ?>
                </ul>
                
            </div>
            <?php }  ?>
            
        </div>
        
        <?php if (isset($column_left) && isset($column_right)) { ?>
        <div class="grid_5">
        <?php } elseif (isset($column_left) || isset($column_right)) { ?>
        <div class="grid_7">
        <?php } else { ?>
        <div class="grid_8">
        <?php } ?>
        
            <h1><?php echo $heading_title; ?></h1>
            
            <div class="property">
                <div class="model"><?php echo $model; ?></div>
            </div>
            
            <?php if ($display_price) { ?>
            <div class="property">
                <?php if (!$special) { ?>
                <p class="price"><?php echo $price; ?></p>
                <?php } else { ?>
                <p class="old_price"><?php echo $price; ?></p>
                <p class="new_price"><?php echo $special; ?></p>
                <?php } ?>
            </div>
            <?php } ?>
            
            <div class="property">
            
                <div class="grid_1" style="margin-right: 25px;">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo str_replace("&","&amp;",$href); ?>" data-count="vertical" data-via="lahoralocavzla" data-related="lahoralocavzla:Confites y Accesorios para Fiestas" data-lang="es">Tweet</a>
                    <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                </div>
                    
                <div class="grid_1">
                    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'es-419'}</script>
                    <g:plusone size="tall" callback="googleMas1" href="<?php echo str_replace("&","&amp;",$href); ?>"></g:plusone>
                </div>
                    
                <div class="grid_1" style="margin-right: 30px;">
                    <div class="fb-like" data-href="<?php echo str_replace("&","&amp;",$href); ?>" data-layout="box_count" data-width="450" data-show-faces="true" data-font="verdana">
                </div>
                    
                </div>
                    <div class="grid_1" style="margin-left: 15px;">
                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode($href); ?>&media=<?php echo rawurlencode($thumb); ?>&description=<?php echo rawurlencode($description); ?>" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                </div>
                
            </div>
            
            <div class="property">
                <div class="availability">
                    <p><b><?php echo $text_availability; ?></b>&nbsp;<?php echo $stock; ?></p>
                </div>
            </div>
            
            <?php if ($manufacturer) { ?>
            <div class="property">
                <div class="manufacturer">
                    <p><b><?php echo $text_manufacturer; ?></b></p>
                    <p><a title="<?php echo $manufacturer; ?>" href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>"><?php echo $manufacturer; ?></a></p>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($review_status) { ?>
            <div class="property">
                <div class="average">
                    <p>
                        <b><?php echo $text_average; ?></b>
                        <?php if ($average) { ?>
                        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" />
                        <?php } else { ?>
                        <?php echo $text_no_rating; ?>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($tags) { ?>
            <div class="property">
                <div class="tags">
                    <p><b><?php echo $text_tags; ?></b></p>
                    <ul>
                    <?php foreach ($tags as $tag) { ?>
                    <li><a title="<?php echo $tag['tag']; ?>" href="<?php echo str_replace('&', '&amp;', $tag['href']); ?>"><?php echo $tag['tag']; ?></a></li> 
                    <?php } ?>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="product">
            
                <div class="property">
                    <div class="quantity">
                        <b><?php echo $text_qty; ?></b>
                        <input type="text" id="quantity" name="quantity" size="3" value="<?php echo $minimum; ?>" />
                        <?php if ($minimum> 1) { ?><br /><small><?php echo $text_minimum; ?></small><?php } ?>
                        <a class="arrow-down">&nbsp;</a>
                        <a class="arrow-up">&nbsp;</a>
                        <a title="<?php echo $button_add_to_cart; ?>" onclick="$('#product').submit();" id="add_to_cart" class="button" style="float: none;margin-left:40px"><?php echo $button_add_to_cart; ?></a>
                    </div>
                </div>
            
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
                
                <?php if ($display_price) { ?>
                <div class="property">
                    <div class="options">
                    <?php if ($options) { ?>
                        <p><b><?php echo $text_options; ?></b></p>
                        <ul>
                        <?php foreach ($options as $option) { ?>
                            <li>
                                <div class="label"><?php echo $option['name']; ?>:</div>
                                <select name="option[<?php echo $option['option_id']; ?>]">
                                <?php foreach ($option['option_value'] as $option_value) { ?>
                                    <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                    <?php if ($option_value['price']) { ?>
                                    <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                                    <?php } ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </li>                
                        <?php } ?>
                        </ul>
                    <?php } ?>
                    </div>
                </div>
                <?php } ?>
        
                
            </form>
            
            <?php if ($discounts) { ?>
            <div class="property">
                <div class="discount">
                    <p><b><?php echo $text_discount; ?></b></p>
                    <p><b><?php echo $text_order_quantity; ?></b></p>
                    <p><b><?php echo $text_price_per_item; ?></b></p>
                    <?php foreach ($discounts as $discount) { ?>
                        <p>
                            <?php echo $discount['quantity']; ?>
                            <?php echo $discount['price']; ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            
        </div>
        
        <?php if (isset($column_left) && isset($column_right)) { ?>
        <div class="grid_10">
        <?php } elseif (isset($column_left) || isset($column_right)) { ?>
        <div class="grid_12">
        <?php } else { ?>
        <div class="grid_16">
        <?php } ?>
        
            <ul class="tabs">
                <li class="tab" id="description">Descripci&oacute;n</li>
                <li class="tab" id="attributes">Especificaci&oacute;n T&eacute;nica</li>
                <li class="tab" id="comments">Comentarios</li>
                <li class="tab" id="relateds">Productos Relacionados</li>
                <li class="tab" id="facebook">Facebook</li>
            </ul>
            
            <div class="clear"></div>
            
            <div id="_description">
                <div class="product_description"><?php echo $description; ?></div>
            </div>
            
            <div id="_attributes">
                <div class="product_attributes"><?php echo $attributes; ?></div>
            </div>
            
            <div id="_comments">
                <div id="review" class="content"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' /></div>
                <div class="clear"></div>
                <div id="comment" class="box" style="border: none;"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' /></div>
            </div>
            
            <div id="_facebook">
                <h2>Comentarios de Facebook</h2>
                <div class="fb-comments" data-href="<?php echo str_replace("&","&amp",$href); ?>" data-num-posts="2" data-width="700"></div>
            </div>
            
            <div id="_relateds">
                <h2>Estos productos tambi&eacute;n te interesan</h2>
                <div id="related" class="box"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' /></div>
            </div>
            
        </div>
    
    </section>
    
<?php if (isset($column_right)) { ?>
    <aside id="column_right"><?php echo $column_right; ?></aside>
<?php } ?>

</section>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=223173687752863";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="fb-root"></div>

<script type="text/javascript" src="<?php echo HTTP_JS; ?>vendor/jquery.jcarousel.min.js"></script>
<script type="text/javascript">
$(function(){
    
    $('#images').preloader();
    $('#imageScroller').preloader();
    
    $('.tab').each(function(){
        $(this).removeClass('active'); 
        $('#_' + this.id).hide(); 
    });
    
    $("#description").addClass('active');
    $('#_description').show(); 
    
    $('.tab').on('click',function() {
        $('.tab').each(function(){
           $(this).removeClass('active'); 
           $('#_' + this.id).hide(); 
        });
        $(this).addClass('active');
        $('#_' + this.id).show(); 
    });
    
    $('#review .pagination a').live('click', function() {
    	$('#review').slideUp('slow').load(this.href).slideDown('slow');
    	return false;
    });
    
    $("a.arrow-up").click(function() {
        var e = $('#quantity');
        var v = $(e).val();
        v++;
        $(e).val(v);
    });
    
    $("a.arrow-down").click(function() {
        var e = $('#quantity');
        var v = $(e).val();
        v--;
        if (v <= 1) {
            v = 1;
        }
        $(e).val(v);
    });
    
    $('#productCarousel').jcarousel({
        wrap: 'circular'
    });
    
    $('#imageScroller div a').click(function(){
        var imgSrc = $(this).find('input.preview').attr('value');
        var hrefSrc = $(this).find('input.popup').attr('value');
        $('#image').attr('src',imgSrc);
        $('#popup').attr('href',hrefSrc);
    });
    
    /* TODO: utilizar clase URL y REWRITE */
    $('#review').load('index.php?r=store/product/review&product_id=<?php echo $product_id; ?>');
    $('#related').load('index.php?r=store/product/related&product_id=<?php echo $product_id; ?>');
    $('#comment').load('index.php?r=store/product/comment&product_id=<?php echo $product_id; ?>');
    
    $("a[rel=product_images]").fancybox(
        {
            'transitionIn'		: 'elastic',
            'transitionOut'		: 'elastic',
            'titlePosition' 	: 'over',
            'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) 
            {
                return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
  		}
    );
});
</script>
<?php echo $footer; ?> 