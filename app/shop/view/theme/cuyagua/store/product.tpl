<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row" itemscope itemtype="http://schema.org/Product">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

    <!-- single-product -->
    <div class="single-product">
        <div class="row">

            <!-- product-images -->
            <div class="large-5 medium-5 small-12 columns">
                <div class="nt-editable" id="images">
                    <div id="product-popup">
                        <div class="nt-editable product-gallery" id="productImages">
                            <?php if (count($images) > 0) { ?>
                                <?php $imagesCopy = array_slice($images, 0);?>
                                <img class="view" id="mainProduct" src="<?php echo $imagesCopy[0]['preview']; ?>" alt="<?php echo $heading_title; ?>" data-zoom-image="<?php echo $imagesCopy[0]['popup']; ?>"/>

                                <div id="mainProductGallery">
                                    <?php foreach ($images as $k => $image) { ?>
                                        <a class="thumb" href="#" data-image="<?php echo $image['preview']; ?>" data-zoom-image="<?php echo $image['popup']; ?>">
                                             <img id="<?php echo "thumb{$k}"; ?>" src="<?php echo $image['thumb']; ?>" />
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } else {?>
                                <img class="view" id="mainProduct" style="width: 100%; height:auto;" src="<?php echo HTTP_IMAGE . '/no_image.jpg'; ?>" data-zoom-image="<?php echo HTTP_IMAGE . '/no_image.jpg'; ?>"/>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product-images -->

            <!-- product-info -->
            <div class="single-product-info large-7 medium-7 small-12 columns">
                <?php if ($sticker) { echo $sticker; } ?>

                <!-- /product-related-data -->
                <h1 itemprop="name" class="property name nt-editable" id="productName"><?php echo $heading_title; ?></h1>

                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/share-button.tpl"); ?>

                <?php if ($review_status) { ?>
                <div itemprop="aggregateRating"itemscope itemtype="http://schema.org/AggregateRating" class="property average nt-editable" id="productAverage">
                    <span class="rating-text">Rating</span>
                    <img class="rating-stars" src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$average . '.png'; ?>" alt="<?php echo $Language->get('text_stars'); ?>" />
                </div>
                <?php } ?>

                <div itemprop="model" class="property model nt-editable" id="productModel">Modelo<span><?php echo $model; ?></span></div>
                <div itemprop="description" class="overview nt-editable" id="productDescription"><p><?php echo trim(strip_tags(substr($description, 0, 400))) . " ... "; ?></p></div>
                <!--<div itemprop="availability" href="http://schema.org/InStock" class="property availability nt-editable" id="productAvailability">
                    <span><?php echo $Language->get('text_availability'); ?><small><?php echo $stock . " item(s)"; ?></small></span>
                </div>-->

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
                <!-- /product-related-data -->

            <!--<?php if ($tags || $manufacturer || $categories) { ?>
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
                <?php } ?>-->

                <!-- product-modify-actions -->
                <?php if ($Config->get('config_store_mode')=='store') { ?>
                <!-- /product-modify-actions -->

                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="productForm">
                    <!--
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
                    <?php } ?>-->

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
                    <div class="property quantity nt-editable" id="productQty">
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
                    <!--/product-quantity -->

                    <script type="text/javascript">
                    <?php
                    echo 'var data = '. json_encode(array(
                        'seller_id'=>$product_info['owner_id'],
                        'buyer_name'=>$this->customer->getFirstName() .' '. $this->customer->getLastName(),
                        'product_id'=>$product_id
                    )) .';';
                    echo($contactData);
                    ?>
                    </script>
                        <div class="actions">
                            <div class="action-button action-see" data-action="contact">
                                <a title="Contactar" id="contact" onclick="productContact('<?php echo ($this->customer->isLogged()); ?>','<?php echo HTTP_HOME; ?>','<?php echo ($this->session->get('token')); ?>',data)">Contactar</a>
                            </div>
                            <div class="action-button action-add" data-action="add-product">
                                <a title="<?php echo $Language->get('button_add_to_cart'); ?>" onclick="addToCart('<?php echo $Url::createUrl("checkout/cart/json") .'&product_id='. $product_id; ?>')" id="add_to_cart"><?php echo $Language->get('button_add_to_cart'); ?></a>
                            </div>
                        </div>
                    </form>
                    <?php } ?>

                    <!-- third-party-actions -->
                    <?php if ($google_client_id) { ?><a class="socialSmallButton googleButton" href="<?php echo $Url::createUrl("api/google",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_google_promote'); ?></a><?php } ?>

                    <?php if ($live_client_id) { ?><a class="socialSmallButton liveButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_live_promote'); ?></a><?php } ?>

                    <?php if ($facebook_app_id) { ?><a class="socialSmallButton facebookButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_facebook_promote'); ?></a><?php } ?>

                    <?php if ($twitter_oauth_token_secret) { ?><a class="socialSmallButton twitterButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'promoteproduct','product_id'=>$product_id)); ?>"><?php echo $Language->get('text_twitter_promote'); ?></a><?php } ?>
                    <!-- /third-party-actions -->
            </div>
            <!-- /product-info -->
        </div>
    </div>
        <!-- /single-product -->

       <!-- related-actions -->
        <?php if ($related) { ?>
            <div class="large-12 columns nt-editable" id="productRelated">
                <h2>Productos Relacionados</h2>
                <div id="related" class="box nt-editable"></div>
            </div>
        <?php } ?>
        <!-- /related-actions -->

        <!-- engagement-actions -->
        <div class="engagement-actions break">
            <div class="row">
                <div class="product-tabs large-12 medium-12 small-12 columns nt-editable" id="productTabs">
                    <ul class="tabs nt-editable" id="pTabs">
                        <li class="tab" id="description"><span class="tab-item">Descripción</span></li>
                        <li class="tab" id="comments"><span class="tab-item">Comentarios</span></li>
                        <!--<li class="tab" id="facebook"><span class="tab-item">Facebook</span></li>-->
                    </ul>

                    <div id="_description">
                        <div itemprop="description" class="product-description nt-editable" id="productDescription"><?php echo $description;?></div>
                    </div>

                    <div id="_comments">
                        <div id="review" class="product-review nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
                        <div id="comment" class="product-comment nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
                    </div>

                    <!--<div id="_facebook">
                        <h3>Comentarios de Facebook</h3>
                        <div class="fb-comments" data-href="<?php echo str_replace("&","&amp",$Url::createUrl("store/product",array('product_id'=>$product_id))); ?>" data-num-posts="2" data-width="700"></div>
                    </div>-->
                </div>
            </div>
        </div>
        <!-- /engagement-actions -->

        <!-- widgets -->
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
        <!-- /widgets -->

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>

<!-- facebook-footer -->
<!--<div id="fb-root"></div>-->
<!-- facebook-footer -->

<script src="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/rrssb/js/rrssb.min.js'; ?>"></script>
<script src="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/elevatezoom/jquery.elevateZoom-3.0.8.min.js'; ?>"></script>

<!--<script defer>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=223173687752863";
      js.async = true;
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>-->

<script defer>
    (function(){
        var orderQuantityAction;
        var initElevate;

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

        orderQuantityAction = function (e, input) {
            var target = e.target;
            var value = ~~input.val();
            if (target.dataset.actionCount === "inc") {
                value++;
            } else if (target.dataset.actionCount === "dec") {
                value--;
            }
            input.val(Math.max(0, value));
        };

        $("#productQty").click(function (e) {
            e.stopPropagation();
            orderQuantityAction(e, $("#quantity"));
        });


        $('#review').load('<?php echo $Url::createUrl("store/product/review",array("product_id"=>$product_id)); ?>');
        $('#comment').load('<?php echo $Url::createUrl("store/product/comment",array("product_id"=>$product_id)); ?>');

        /**
         * Init the elevata pluging
         * @param {string} id - id of the target element.
         * @param {string} galleryid - id of the product picture gallery.
         */

        initElevate = function (id, galleryId) {
            id = "#" + id;

            $(id).elevateZoom({
                 gallery: galleryId
                , cursor: 'crosshair'
                , responsive: true
                , zoomType: 'window'
                , zoomWindowOffetx: 16
                , zoomLevel: 1
                , lensSize: 100
                , galleryActiveClass: 'elevate-active'
                , imageCrossfade: true
                , zoomWindowFadeIn: 300
                , zoomWindowFadeOut: 300
                , lensFadeIn: 300
                , lensFadeOut: 300
                , borderSize: 1
                , loadingIcon: false});

            $(id).on("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $.fancybox($(id).data('elevateZoom').getGalleryList());
                return false; });
        };
        initElevate("mainProduct", "mainProductGallery");
    })();
</script>
<?php echo $footer; ?>