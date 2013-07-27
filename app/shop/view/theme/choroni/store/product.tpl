<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <section id="content">
        <div class="grid_16">
            <ul id="breadcrumbs" class="nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
            </ul>
        </div>
        
        <div class="clear"></div><br /><br />
        
        <div class="grid_7" style="padding: 0px 40px;">
            <div class="nt-editable" id="images">
                <div id="popup">
                    <ul class="nt-editable" id="productImages">
                    <?php foreach ($images as $k => $image) { ?>
                    <li>
                        <img class="etalage_thumb_image" src="<?php echo $image['preview']; ?>" alt="<?php echo $heading_title; ?>" />
                        <img class="etalage_source_image" src="<?php echo $image['popup']; ?>" alt="<?php echo $heading_title; ?>" />
                    </li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="clear"></div>
            
            <div class="property nt-editable" id="productSocial" style="display: none;">
                
            </div>
            
        </div>
        
        <div class="grid_7">
        
            <h1 class="nt-editable" id="productName"><?php echo $heading_title; ?></h1>
            
            <div class="clear"></div>
            
            <div class="property model nt-editable" id="productModel"><?php echo $model; ?></div>
            
            <div class="clear"></div>
            
            <?php if ($review_status) { ?>
            <div class="property average nt-editable" id="productAverage">
                <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$average . '.png'; ?>" alt="<?php echo $Language->get('text_stars'); ?>" />
            </div>
            <?php } ?>
            
            <div class="clear"></div>
            
            <?php if ($sticker) { echo $sticker; } ?>
            
            <div class="clear"></div>
            
            <?php if ($display_price) { ?>
                <?php if (!$special) { ?>
            <p class="price nt-editable" id="productPrice"><?php echo $price; ?></p>
                <?php } else { ?>
            <p class="new_price nt-editable" id="productNewPrice"><?php echo $special; ?></p>
            <p class="old_price nt-editable" id="productOldPrice"><?php echo $price; ?></p>
                <?php } ?>
            <?php } ?>
            
            <div class="clear"></div>
            
            <div class="property availability nt-editable" id="productAvailability">
                <p><b><?php echo $Language->get('text_availability'); ?></b>&nbsp;<?php echo $stock; ?></p>
            </div>
            
            <div class="clear"></div>
            
            <?php if ($tags) { ?>
            <ul class="tags nt-editable" id="productTags">
            <?php if ($manufacturer) { ?>
                <li><a class="manufacturer nt-editable" id="productManufacturer" title="<?php echo $manufacturer; ?>" href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>"><?php echo $manufacturer; ?></a></li>
            <?php } ?>
            <?php foreach ($categories as $tag) { ?>
                <li><a class="category nt-editable" id="productCategory<?php echo $tag['category_id']; ?>" title="<?php echo $tag['name']; ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl('store/category',array('path'=>$tag['category_id']))); ?>"><?php echo $tag['name']; ?></a></li> 
            <?php } ?>
            <?php foreach ($tags as $tag) { ?>
                <li><a title="<?php echo $tag['tag']; ?>" href="<?php echo str_replace('&', '&amp;', $tag['href']); ?>"><?php echo $tag['tag']; ?></a></li> 
            <?php } ?>
            </ul>
            <?php } ?>
            
            <div class="clear"></div><br /><hr /><br />
            
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="product">
                
                <?php if ($discounts) { ?>
                <div class="property discount nt-editable" id="productDiscount">
                    <p><b><?php echo $Language->get('text_discount'); ?></b></p>
                    <table>
                        <tr>
                            <th><?php echo $Language->get('text_order_quantity'); ?></th>
                            <th><?php echo $Language->get('text_price_per_item'); ?></th>
                        </tr>
                    <?php foreach ($discounts as $discount) { ?>
                        <tr>
                            <td><?php echo $discount['quantity']; ?></td>
                            <td><?php echo $discount['price']; ?></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
                <?php } ?>
        
                <div class="clear"></div>
            
                <?php if ($options) { ?>
                <div class="property options nt-editable" id="productOptions">
                    <p><b><?php echo $Language->get('text_options'); ?></b></p>
                     <div class="clear"></div>
                    <ul>
                    <?php foreach ($options as $option) { ?>
                        <li>
                            <div class="label"><?php echo $option['name']; ?>:</div>
                            <select name="option[<?php echo $option['option_id']; ?>]">
                            <?php foreach ($option['option_value'] as $option_value) { ?>
                                <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                <?php if ($option_value['price'] && $display_price) { ?>(<?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>)<?php } ?>
                                </option>
                            <?php } ?>
                            </select>
                        </li>                    
                    <?php } ?>
                    </ul>
                </div>
                <?php } ?>
                
                <div class="clear"></div><br />
                
                <div class="property quantity nt-editable" id="productQty">
                    <b><?php echo $Language->get('text_qty'); ?></b>
                    <input type="text" id="quantity" name="quantity" size="3" value="<?php echo $minimum; ?>" />
                    <?php if ($minimum> 1) { ?><br /><small><?php echo $Language->get('text_minimum'); ?></small><?php } ?>
                    <a class="arrow-down" style="position:absolute;margin-top: 5px;margin-right: 5px;"></a>
                    <a class="arrow-up" style="position:absolute;margin-top: 5px;margin-left:20px"></a>
                    <a title="<?php echo $Language->get('button_add_to_cart'); ?>" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="$('#product').submit();"<?php } else { ?>onclick="addToCart('<?php echo $product_id; ?>',$('#quantity').val())"<?php } ?> id="add_to_cart" class="button" style="float: none;margin-left:40px"><?php echo $Language->get('button_add_to_cart'); ?></a>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
            
            </form>
            
        </div>
        
        <div class="clear"></div>
        <?php if ($related) { ?>
        <div class="grid_16 nt-editable" id="productRelated">
            <div id="related" class="box nt-editable"></div>
        </div>
        <?php } ?>
        <div class="clear"></div>
        
        <div class="grid_16 product_tabs nt-editable" id="productTabs">
            <ul class="tabs nt-editable" id="pTabs">
                <li class="tab" id="description">Descripci&oacute;n</li>
                <li class="tab" id="comments">Preguntas</li>
                <li class="tab" id="facebook">Facebook</li>
            </ul>
        
            <div class="clear"></div>
            
            <div id="_description">
                <div class="product_description nt-editable" id="productDescription"><?php echo $description; ?></div>
            </div>
            
            <div id="_comments">
                <div id="comment" class="box nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
                <div class="clear"></div>
                <div id="review" class="content nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
            </div>
            
            <div id="_facebook">
                <h2>Comentarios de Facebook</h2>
                <div class="fb-comments" data-href="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>" data-num-posts="2" data-width="700"></div>
            </div>
            
            <div class="clear"></div>
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            <div class="clear"></div>
            
        </div>
    </section>
    
</section>

<script type="text/javascript" src="<?php echo HTTP_JS; ?>necojs/neco.carousel.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>vendor/jquery.etalage.js"></script>
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=223173687752863";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<script>
$(function(){
    <?php if ($related) { ?>
    $("#related").ntCarousel({
        url:'<?php echo $Url::createUrl("store/product/relatedJson",array("product_id"=>$product_id)); ?>',
        image: {
          width:80,
          height:80  
        },
        loading: {
          image: '<?php echo HTTP_IMAGE; ?>loader.gif'
        },
        options: {
            scroll: 1
        }
    });
    <?php } ?>
    
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
    
    $('#review').load('<?php echo $Url::createUrl("store/product/review",array("product_id"=>$product_id)); ?>');
    
    $('#comment').load('<?php echo $Url::createUrl("store/product/comment",array("product_id"=>$product_id)); ?>');
    
    $('#productImages').etalage({
        thumb_image_width: <?php echo (int)$config_image_thumb_width; ?>,
        thumb_image_height: <?php echo (int)$config_image_thumb_height; ?>,
        source_image_width: <?php echo (int)$config_image_popup_width; ?>,
        source_image_height: <?php echo (int)$config_image_popup_height; ?>,
        zoom_area_width: 400,
        zoom_area_height: 400,
        magnifier_invert: false,
        hide_cursor: true,
        speed: 400
    });
});
</script>
<script>
$(window).load(function(){
    var html = '';
    
    html += '<div class="grid_1" style="margin-right: 25px;">';
    html += '<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>" data-count="vertical" data-via="lahoralocavzla" data-related="lahoralocavzla:Confites y Accesorios para Fiestas" data-lang="es">Tweet</a>';
    html += '<script type="text\/javascript" src="\/\/platform.twitter.com\/widgets.js"><\/script>';
    html += '</div>';
    
    html += '<div class="grid_1">';
    html += '<script type="text\/javascript" src="https:\/\/apis.google.com\/js\/plusone.js">{lang: \'es-419\'}<\/script>';
    html += '<g:plusone size="tall" callback="googleMas1" href="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>"></g:plusone>';
    html += '</div>';
    
    html += '<div class="grid_1" style="margin-right: 30px;">';
    html += '<div class="fb-like" data-href="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>" data-layout="box_count" data-width="450" data-show-faces="true" data-font="verdana"></div>';
    html += '</div>';
    
    html += '<div class="grid_1" style="margin-left: 15px;">';
    html += '<a href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode(str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id)))); ?>&media=<?php echo rawurlencode($thumb); ?>&description=<?php echo rawurlencode($description); ?>" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
    html += '</div>';
    
    $('#productSocial').append(html);
});
</script>
<?php echo $footer; ?>