<?php echo $header; ?>
<?php echo $navigation; ?>

<section id="maincontent" class="row" itemscope itemtype="http://schema.org/Product">
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl");?>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

<!-- single-product -->

<div class="single-product" data-id-product="<?php echo $product_id;?>">
<div class="row">
    <!-- product-images -->
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/view-start.tpl"); ?>

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/gallery-start.tpl"); ?>

        <?php if (count($images) > 0) { ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/preview.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/gallery-controls.tpl"); ?>
        <?php } else { ?>
            <img class="view" id="mainProduct" style="width: 100%; height:auto;"
                 src="<?php echo HTTP_IMAGE . '/no_image.jpg'; ?>" 
                 data-zoom-image="<?php echo HTTP_IMAGE . '/no_image.jpg'; ?>"/>
        <?php }?>

            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/gallery-end.tpl"); ?>

            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/view-end.tpl"); ?>
    <!-- /product-images -->

    <!-- product-info -->
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/info-start.tpl"); ?>
            <!-- /product-related-data -->

            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-heading.tpl");?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/share-button.tpl"); ?>

            <?php if ($review_status) { ?>
                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" class="property average nt-editable" id="productAverage">
                    <span class="rating-text" itemprop="ratingValue"><?php echo (float)$average; ?></span>
                    <span class="rating-text" itemprop="reviewCount"><?php echo count($revews); ?></span>
                    <span class="rating-text">Rating</span>
                    <img class="rating-stars" src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$average . '.png'; ?>" alt="<?php echo $Language->get('text_stars'); ?>" />
                </div>
            <?php } ?>

            <div itemprop="model" class="property model nt-editable" id="productModel"><?php echo $Language->get('text_model'); ?><span><?php echo $model; ?></span></div>
            <div itemprop="description" itemprop="description" class="overview nt-editable" id="productOverview"><p><?php echo $overview; ?></p></div>
            <div itemprop="availability" href="http://schema.org/InStock" class="property model nt-editable" id="productAvailability">
                <?php echo $Language->get('text_availability'); ?><span><?php echo $stock; ?></span>
            </div>

            <?php if ($Config->get('config_store_mode')=== 'store') { ?>
                <div class="offers" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <?php if ($display_price) { ?>
                        <?php if (!$special) { ?>
                            <span itemprop="price" class="price nt-editable" id="productPrice"><?php echo $price; ?></span>
                        <?php } else { ?>
                            <span itemprop="price" class="new_price nt-editable" id="productNewPrice"><?php echo $special; ?></span>
                            <span itemprop="price" class="old_price nt-editable" id="productOldPrice"><?php echo $price; ?></span>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <!-- /product-related-data -->

            <!-- product links -->
            <?php if ($tags || $manufacturer || $categories) { ?>
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
            <!-- /product links -->

            <!-- product-modify-actions -->
            <?php if ($Config->get('config_store_mode')=='store') { ?>
                <!-- /product-modify-actions -->

                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="productForm">
                    <!-- product-options -->
                    <?php if ($options) { ?>
                        <div class="options nt-editable" id="productOptions">
                            <!--<span><?php echo $Language->get('text_options'); ?></span>-->
                            <ul>
                                <?php foreach ($options as $option) { ?>
                                    <li>
                                        <label for="option[<?php echo $option['option_id']; ?>]" class="label"><?php echo $option['name']; ?>:</label>
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
                    <!-- /prdduct-options -->

                    <!-- product-quantity -->
                    <div class="quantity nt-editable" id="productQty">
                        <input type="text" id="quantity" name="quantity" value="<?php echo $minimum; ?>" />
                        <?php if ($minimum> 1) { ?><small><?php echo $Language->get('text_minimum'); ?></small><?php } ?>
                        <a href="javascript:;"  class="arrow-up">
                            <i data-action-count="inc" class="icon">
                                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/plus.tpl"); ?>
                            </i>
                        </a>
                        <a href="javascript:;"  class="arrow-down"  >
                            <i data-action-count="dec" class="icon">
                                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/minus.tpl"); ?>
                            </i>
                        </a>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                    <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />

                    <?php if ($tags || $manufacturer || $categories) { ?>
                    <ul class="tags nt-editable" id="productTags">
                        <?php if ($manufacturer) { ?>
                        <li><a class="manufacturer nt-editable" id="productManufacturer" title="<?php echo $manufacturer; ?>" href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>" itemprop="brand"><?php echo $manufacturer; ?></a></li>
                        <?php } ?>
                        <?php foreach ($categories as $tag) { ?>
                        <li><a class="category nt-editable" id="productCategory<?php echo $tag['category_id']; ?>" title="<?php echo $tag['name']; ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl('store/category',array('path'=>$tag['category_id']))); ?>"><?php echo $tag['name']; ?></a></li>
                        <?php } ?>
                        <?php foreach ($tags as $tag) { ?>
                        <li><a title="<?php echo $tag['tag']; ?>" href="<?php echo str_replace('&', '&amp;', $tag['href']); ?>"><?php echo $tag['tag']; ?></a></li>
                        <?php } ?>
                    </ul>
                    <?php } ?>

                    <!--/product-quantity -->
                    <div class="group group--btn" role="group">
                        <!--
                    <div class="btn btn-detail" data-action="contact">
                        <a class="btn btn-add btn--primary" title="Contactar" id="contact" onclick="productContact(<?php echo str_replace('"','\"',json_encode(array('seller_id'=>$product_info['owner_id'], 'buyer_name'=>$this->customer->getFirstName() .' '. $this->customer->getLastName(), 'product_id'=>$product_id))); ?>)">Contactar</a>
                    </div>
                    -->
                    <div class="btn btn-add btn--secondary" data-action="addToCart" role="button" aria-label="AddToCart">
                        <a title="<?php echo $Language->get('button_add_to_cart'); ?>" onclick="addToCart('<?php echo $Url::createUrl("checkout/cart/json") .'&product_id='. $product_id; ?>')" id="add_to_cart"><?php echo $Language->get('button_add_to_cart'); ?></a>
                    </div>
                </div>
            </form>
        <?php } ?>
        <!--
        <?php if ($google_client_id) { ?><a class="socialSmallButton googleButton" href="<?php echo $Url::createUrl("api/google",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_google_promote'); ?></a><?php } ?>

        <?php if ($live_client_id) { ?><a class="socialSmallButton liveButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_live_promote'); ?></a><?php } ?>

        <?php if ($facebook_app_id) { ?><a class="socialSmallButton facebookButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_facebook_promote'); ?></a><?php } ?>

        <?php if ($twitter_oauth_token_secret) { ?><a class="socialSmallButton twitterButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_twitter_promote'); ?></a><?php } ?>
        -->
        </div>
        <!-- /product-info -->
    </div>
</div>
<!-- /single-product -->

<!-- engagement-actions -->
<div class="engagement-actions break">
    <div class="row">
        <div class="product-tabs large-12 medium-12 small-12 columns nt-editable" id="productTabs">
            <ul class="tabs nt-editable" id="pTabs">
                <li class="tab" id="description"><span class="tab-item"><?php echo $Language->get('Descripción'); ?></span></li>
                <?php if ($attributes) { ?><li class="tab" id="attributes"><span class="tab-item"><?php echo $Language->get('Especificaciones'); ?></span></li><?php } ?>
                <li class="tab" id="comments"><span class="tab-item"><?php echo $Language->get('Comentarios'); ?></span></li>
                <li class="tab" id="facebook_comments"><span class="tab-item"><?php echo $Language->get('Facebook'); ?></span></li>
            </ul>

            <!-- product description -->
            <div id="_description">
                <div itemprop="description" class="product-description nt-editable" id="productDescription"><?php echo $description;?></div>
            </div>
            <!-- product description -->

            <!-- product attributes -->
            <?php if ($attributes) { ?>
            <div id="_attributes">
                <div itemprop="attributes" class="product-attributes nt-editable" id="productAttributes">
                    <?php foreach ($attributes as $key => $attr) { ?>
                    <h3><?php echo $attr['title']; ?></h3>
                        <?php foreach ($attr['items'] as $k => $attribute) { ?>
                        <div class="row">
                            <div class="small-6 medium-6 large-6 columns"><?php echo $attribute['label']; ?></div>
                            <div class="small-6 medium-6 large-6 columns"><?php echo $attribute['value']; ?></div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <!-- product attributes -->

            <!-- necotienda comments -->
            <div id="_comments" data-component="comments">
                <div id="review" class="product-review nt-editable" data-component="comment"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
                <div id="comment" class="product-comment nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
            </div>
            <!-- /necotienda comments -->

            <!-- facebook comments -->
            <div id="_facebook_comments">
                <h2>Comentarios de Facebook</h2>
                <div class="fb-comments" data-href="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>" data-num-posts="2" data-width="700">
            </div>
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
            <!-- /facebook comments -->

        </div>
    </div>
</div>
<!-- /engagement-actions -->

<div class="clearfix"></div>

<?php if ($related) { ?>
    <div id="productRelated">
        <div class="heading widget-heading feature-heading heading-dropdown heading-carousele">
            <div class="heading-title">
                <h3>
                    <i class="heading-icon icon icon-star">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/star-full.tpl"); ?>
                    </i>
                    Productos Relacionados
                </h3>
            </div>
        </div>
        <div data-section="realated" data-widget="slick" class="nt-editable">
            <?php $products = $related; ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
        </div>
    </div>
<?php } ?>

<!-- widgets -->
<?php if($widgets) { ?>
   <ul class="widgets">
      <?php foreach ($widgets as $widget) { ?>
         {%<?php echo $widget; ?>%}
      <?php } ?>
   </ul>
<?php } ?> 
<!-- /widgets -->

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>


<script data-script="tabs">
    (function () {
        window.deferjQuery(function () {
            var $tabs = $('.tab');
            $('#review').load('<?php echo $Url::createUrl("store/product/review",array("product_id"=>$product_id)); ?>');
            $('#comment').load('<?php echo $Url::createUrl("store/product/comment",array("product_id"=>$product_id)); ?>');

            $tabs.each(function(){
                $(this).removeClass('active');
                $('#_' + this.id).hide();
            });
            $tabs.on('click',function() {
                $tabs.each(function(){
                    $(this).removeClass('active');
                    $('#_' + this.id).hide();
                });
                $(this).addClass('active');
                $('#_' + this.id).show();
            });

            $("#description").addClass('active');
            $('#_description').show();
        });
    })();
</script>

<script data-script="productGallery">
    (function () {
        var productGalleryNavPrev = '<button type="button" class="slick-prev product-gallery-control">' + '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-left.tpl"); ?>' + '</button>';
        var productGalleryNavNext = '<button type="button" class="slick-next product-gallery-control">' + '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-right.tpl"); ?>' + '</button>';
        window.deferPlugin('slick', function () {
            $("#mainProductGallery").slick({
                infinite: true,
                prevArrow: productGalleryNavPrev,
                nextArrow: productGalleryNavNext,
            });
        });
    })();
</script>

<script data-script="faceBookGraph">
    (function () {
        window.deferjQuery(function () {
            var $lastMeta = $("meta").last();
            var openGraphMetaData = [
                '<meta property="og:title" content="<?php echo $heading_title; ?>"/>',
                '<meta property="og:type" content="product"/>',
                '<meta property="og:url" content="' + window.location + '"/>',
                '<meta property="og:image" content="<?php echo $imagesCopy[0]['preview']; ?>">',
                '<meta property="product:original_price:amount"   content="<?php echo $price; ?>" />',
                '<meta property="product:price:amount"   content="<?php echo $price; ?>" />',
                '<meta property="product:price:currency" content="' + $("[data-currency]").attr("data-currency") + '" />',
            ];
            openGraphMetaData.forEach(function (tag) {
                $(tag).insertAfter($lastMeta);
            });
        });
    })();
</script>

<script data-script="productPreview">
    (function () {
        var config = {
            gallery: "mainProductGallery",
            cursor: 'crosshair' ,
            responsive: true,
            zoomType: 'window',
            zoomWindowOffetx: 16,
            zoomLevel: 1,
            lensSize: 100,
            galleryActiveClass: 'elevate-active',
            imageCrossfade: true ,
            zoomWindowFadeIn: 450,
            zoomWindowFadeOut: 450,
            lensFadeIn: 450,
            lensFadeOut: 450,
            borderSize: 1,
            loadingIcon: false
        };

        window.deferPlugin('elevateZoom', function () {
            var $el = $("#mainProduct");
            $el.elevateZoom(config);
            $el.on("click", function(e) {
                e.stopPropagation();
                $.fancybox($el.data('elevateZoom').getGalleryList());
                return false;
            });
        });
    })();
</script>

<script data-script="productQuantity">
    (function () {
        var orderQuantityAction = function (e, input) {
            var target = e.target;
            var value = ~~input.val();
            if (target.dataset.actionCount === "inc") {
                value++;
            } else if (target.dataset.actionCount === "dec") {
                value--;
            }
            input.val(Math.max(0, value));
        };
        window.deferjQuery(function () {
            $("#productQty").click(function (e) {
                e.stopPropagation();
                orderQuantityAction(e, $("#quantity"));
                return false;
            });
            $('#productRelated').find("ul").carouFredSel();
        });

    })();
</script>

<?php echo $footer; ?>