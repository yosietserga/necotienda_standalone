<?php if (!$isLogged) { ?>
    <li class="review_item">Conéctate (Log in) para dejar tu comentario.</li>
<?php } ?>
<ul data-component="commentsList">
<?php if (!empty($reviews)) { ?>
    <?php foreach ($reviews as $review) { ?>
    <li id="review_<?php echo $review['review_id']; ?>" class="row review_item" data-component="comment" data-id-comment="<?php echo $review['review_id']; ?>">
        <div class="review-block" data-component="commentItem">
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/review/info.tpl");
                  include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/review/replies.tpl"); ?>

            <?php if ($isLogged) { ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/review/actions.tpl"); ?>
            <?php } ?>
        </div>
    </li>
    <?php } ?>
<?php } else { ?>
    <li id="noComments" class="review_item"><?php echo $Language->get('text_no_reviews'); ?></li>
<?php } ?>
</ul>
<?php if (!empty($reviews)) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/comments.tpl"); ?>

<script>
    CommentBox.init($('*[data-component="comments"]'), $('*[data-id-product]').attr('data-id-product'));
</script>
