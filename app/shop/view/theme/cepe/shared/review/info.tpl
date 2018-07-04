<!-- review-info -->

<div class="reviewer-info large-12 medium-12 small-12 columns">
    <span class="name" rel="author"><?php echo $review['author']; ?></span>
    <time class="date" datetime="<?php echo $review['date_added']; ?>">
        <?php echo $review['date_added']; ?>
    </time>
    <img class="rating" src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" />
</div>

<div class="review-content large-12 medium-12 small-12 columns">
    <p class="review-body"><?php echo $review['text']; ?></p>
</div>
<!-- /review-info -->