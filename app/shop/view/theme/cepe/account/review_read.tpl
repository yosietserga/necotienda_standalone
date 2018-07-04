<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <div class="review">
        <span class="review-author">
            <?php echo $review['author']; ?>
            <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" />
            <small><?php echo date('d-m-Y h:i A',strtotime($review['date_added'])); ?></small>
        </span>

        <div class="review-content"><?php echo $review['text']; ?></div>
        <?php if ($review['pid']) { ?>
            <a href="<?php echo $Url::createUrl("store/product",array('product_id'=>$review['product_id'])); ?>">
                <img src="<?php echo $review['thumb']; ?>" alt="<?php echo $review['name'];?>" />
                <?php echo $review['name']; ?>
            </a>
        <?php } ?>
    </div>
    <?php if ($replies) { ?>
     <div class="replies">
        <h2><?php echo $Language->get("text_replies"); ?></h2>
        <ul class="replies">
            <?php foreach ($replies as $reply) { ?>
            <li id="reply_<?php echo $review['review_id']; ?>_<?php echo $reply['review_id']; ?>" class="reply_<?php echo $review['review_id']; ?> row">
                <div class="large-3 medium-3 small-12 columns">
                    <b><?php echo $reply['author']; ?></b>
                    <small><?php echo date('d-m-Y h:i A',strtotime($reply['date_added'])); ?></small>
                </div>
                <div class="large-9 medium-9 small-12 columns">
                    <?php echo $reply['text']; ?>
                </div>
            </li>
            <?php } ?>
        </ul>
     </div>
    <?php } ?>

    <div class="review-actions">
        <a class="review-delete" onclick="deleteReview(this,'<?php echo $review['product_id']; ?>','<?php echo $review['review_id']; ?>')">Eliminar</a>
        <a class="dislikes"><?php echo (int)$review['dislikes']; ?></a>
        <a class="review-dislike" title="<?php echo $Language->get('text_dislike'); ?>"></a>
        <a class="likes"><?php echo (int)$review['likes']; ?></a>
        <a class="review-like" title="<?php echo $Language->get('text_like'); ?>"></a>
    </div>
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
    (function () {
        window.deferjQuery(function () {
            var deleteReview = function deleteReview(e,p,r) {
                if (confirm('<?php echo $Language->get('text_confirm_delete'); ?>')) {
                    $('#review_'+ r).slideUp(function(){
                        $(this).remove();
                    });
                    $.post('<?php echo $Url::createUrl("store/product/deleteReview"); ?>&product_id='+ p +'&review_id='+ r,
                    {
                        'product_id':p,
                        'review_id':r
                    },function(){
                        window.location = '<?php echo $Url::createUrl("account/review"); ?>';
                    });
                }
            };
            window.deleteReview = deleteReview;
        });
    })();
</script>
<?php echo $footer; ?>