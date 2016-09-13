<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <?php if ($reviews) { ?>
        <ul id="reviews" class="reviews">
            <?php foreach ($reviews as $value) { ?>
            <li id="pid_<?php echo $value['review_id']; ?>" class="review_item collapse-list row">
                <div class="row"> 
                <div class="column">
                    <a class="review-product" href="<?php echo $value['product_href']; ?>" title="Ver Producto">
                        <?php echo $value['product']; ?>
                    </a>
                    <time class="review-date" style="font-size: 0.835rem;font-style:italic;"><?php echo $value['date_added']; ?></time>
                </div>
                <div class="column" style="margin-top: 0.835rem;">
                    <p class="review-body"><?php echo $value['text']; ?></p>
                </div>
                <div class="review-actions column" style="margin-top: 0.835rem;">
                    <a class='action-choice' href="javascript:void(0);" onclick="revealChoices(this,'<?php echo $value['product_id']; ?>','<?php echo $value['review_id']; ?>');" title="Eliminar">Eliminar</a>
                    <a class="read-more" href="<?php echo $value['product_href']; ?>" title="Ver Producto">
                        <?php echo $Language->get('text_read_comments');?>
                    </a>
                </div>
                </div>
            </li>
        <?php } ?>
        </ul>
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    <?php } else { ?>
        <div class="no-info">
            <?php echo $Language->get('text_empty_page');?>
        </div>
    <?php } ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
(function () {
        window.deferjQuery(function () {
            function filterProducts() {
                var url = '';
                var subjectFilter = $('#filter_subject').val();
                var sortFilter = $('#filter_sort').val();
                var statusFilter = $('#filter_status').val();
                var limitFilter = $('#filter_limit').val();

                if (subjectFilter){
                    url += '&keyword=' + subjectFilter;
                }

                if (sortFilter){
                    url += '&sort=' + sortFilter;
                }

                if (statusFilter){
                    url += '&status=' + statusFilter;
                }

                if (limitFilter){
                    url += '&limit=' + limitFilter;
                }
                window.location.href = '<?php echo $Url::createUrl("account/order"); ?>' + url;
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
                return false;
            });
        });
    })();
</script>
<script>
    (function () {
        window.deferjQuery(function () {
            var revealChoices = function (element, productId, reviewId) {
                var confirm = [
                    "<span class='confirm'><strong>¿Seguro?</strong>",
                        "<a href='javascript:void(0)' data-choice='accept' onClick='actionDeleteReview(this, " + productId + ", " + reviewId + ")'" + ">Si</a>",
                        "<a href='javascript:void(0)' data-choice='cancel' onClick='actionDeleteReview(this, " + productId + ", " + reviewId + ")'" + ">No</a>",
                    "</span>"
                ].join("");
                element.outerHTML = confirm;
            };
            var actionDeleteReview = function (element, productId, reviewId) {
                var choice = element.dataset.choice;
                var  parent = element.parentElement;
                var  reviews = document.getElementById("reviews");
                var  reviewItem = document.getElementById("pid_" + reviewId);

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
            };
            window.revealChoices = revealChoices;
            window.actionDeleteReview = actionDeleteReview;
        });
    })();
</script>
<?php echo $footer; ?>