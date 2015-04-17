<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>

    <h1>Comentarios</h1>

    <?php if ($reviews) { ?>
        <ul id="reviews" class="reviews">
            <?php foreach ($reviews as $value) { ?>
            <li id="pid_<?php echo $value['review_id']; ?>" class="review-item row">
                <div class="large-8 medium-8 small-12 columns">
                    <a class="review-product" href="<?php echo $value['product_href']; ?>" title="Ver Producto">
                        <?php echo $value['product']; ?>
                    </a>
                </div>
                <div class="large-4 medium-4 small-12 columns"></div>
                    <a class="review-date"><?php echo $value['date_added']; ?></a>
                <div class="large-12 medium-12 small-12 columns">
                    <p class="review-body"><?php echo $value['text']; ?></p>
                </div>
                <div class="review-actions large-12 medium-12 small-12 columns">
                    <a class='action-choice' href="javascript:void(0);" onclick="revealChoices(this,'<?php echo $value['product_id']; ?>','<?php echo $value['review_id']; ?>');" title="Eliminar">Eliminar</a>
                    <a class="read-more" href="<?php echo $value['product_href']; ?>" title="Ver Producto">
                        Leer todos los comentarios
                    </a>
                </div>
            </li>
        <?php } ?>
        </ul>
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    <?php } else { ?>
        <div class="no-info lar">No tiene nin&uacute;n mensaje</div>
    <?php } ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
function filterProducts() {
     var url = '';
    
    if ($('#filter_subject').val()){
        url += '&keyword=' + $('#filter_subject').val();
    }
    
    if ($('#filter_sort').val()){
        url += '&sort=' + $('#filter_sort').val();
    }
    
    if ($('#filter_status').val()){
        url += '&status=' + $('#filter_status').val();
    }
    
    if ($('#filter_limit').val()){
        url += '&limit=' + $('#filter_limit').val();
    }
    
    window.location.href = '<?php echo $Url::createUrl("account/review"); ?>' + url;
    
    return false;
}
$('#filter').on('click',function(e){
    filterProducts();
    return false;
});
$('#filter_customer_product').on('keydown',function(e) {
    if (e.keyCode == 13) {
        filterProducts();
    }
});
</script>
<script>
function revealChoices(element, productId, reviewId) {
    var confirm = [
        "<span class='confirm'>¿Seguro?",
            "<a href='javascript:void(0)' data-choice='accept' onClick='actionDeleteReview(this, " + productId + ", " + reviewId + ")'" + ">Si</a>",
            "<a href='javascript:void(0)' data-choice='cancel' onClick='actionDeleteReview(this, " + productId + ", " + reviewId + ")'" + ">No</a>",
        "</span>"
    ].join("");
    element.outerHTML = confirm;
}
function actionDeleteReview(element, productId, reviewId) {
    var choice = element.dataset.choice
      , parent = element.parentElement
      , reviews = document.getElementById("reviews")
      , reviewItem = document.getElementById("pid_" + reviewId);

    if (choice === 'accept') {
        reviews.removeChild(reviewItem);
        $.post('<?php echo $Url::createUrl("store/product/deleteReview"); ?>&product_id='+ productId +'&review_id='+ reviewId,
        {
            'product_id': productId,
            'review_id':reviewId
        });
    } else {
        parent.outerHTML = "<a class='action-choice' href='javascript:void(0)' onclick='revealChoices(this, " + productId + ", " + reviewId + ")'>Eliminar</a>";
    }
}
</script>
<?php echo $footer; ?>