<!-- replies -->

<?php if ($review['replies']) { ?>
<ul class="replies">
    <?php foreach ($review['replies'] as $reply) { ?>
    <li id="reply_<?php echo $review['review_id']; ?>_<?php echo $reply['review_id']; ?>" class="reply_<?php echo $review['review_id']; ?>">
        <div class="reply-heading reviewer-info large-12 medium-12 small-12 columns">
            <span class="name"><?php echo $reply['author']; ?></span>
            <time class="date"><?php echo date('d-m-Y h:i A',strtotime($reply['date_added'])); ?></time>
        </div>
        <div class="reply-body review-content large-12 medium-12 small-12 columns">
            <p class="review-body"><?php echo $reply['text']; ?></p>
        </div>
    </li>
    <?php } ?>
</ul>
<?php } ?>
<!-- /replies -->