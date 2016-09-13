<div class="review-actions large-12 medium-12 small-12 columns">
    <div class="crud-actions">
        <a class="review-reply" data-action="addReply" data-id-product="<?php echo $review['product_id']; ?>" data-id-review="<?php echo $review['review_id']; ?>">
            Replicar
        </a>
        <?php if ($review['isOwner']) { ?>
        <a class="review-delete" data-action="deleteReview" data-id-product="<?php echo $review['product_id']; ?>" data-id-review="<?php echo $review['review_id']; ?>">
            Eliminar
        </a>
        <?php } ?>
    </div>
    <div class="engagement-actions">
        <a class="review-like" data-action="likeReview" data-id-product="<?php echo $review['product_id']; ?>" data-id-review="<?php echo $review['review_id']; ?>">
            Me gusta
        </a>
        <a class="review-dislike" data-action="dislikeReview" data-id-product="<?php echo $review['product_id']; ?>" data-id-review="<?php echo $review['review_id']; ?>">
            No me gusta
        </a>
        <a class="data-likes">
            <i class="icon icon-thumb-up">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/like.tpl"); ?>
            </i>
            <ins data-count="likes"><?php echo (int)$review['likes']; ?></ins>
        </a>
        <a class="data-dislikes">
            <i class="icon icon-thumb-down">
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/like.tpl"); ?>
            </i>
            <ins data-count="dislikes"><?php echo (int)$review['dislikes']; ?></ins>
        </a>
    </div>
</div>