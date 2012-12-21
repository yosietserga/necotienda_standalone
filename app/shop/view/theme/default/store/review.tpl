<?php if ($reviews) { ?>
    <?php foreach ($reviews as $review) { ?>
        <div class="content">
            <b><?php echo $review['author']; ?></b> | 
            <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" />
            <?php echo $review['date_added']; ?>
            <?php echo $review['text']; ?>
        </div>
    <?php } ?>
    <div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
    <div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>
