<?php if (!$posts) { ?>
<div class="content"><?php echo $Language->get('text_error'); ?></div>
<?php } else { ?>
<div class="content">
    <?php if ($sorts) { ?>
    <div class="sort">
        <select name="sort" <?php echo (array_key_exists('ajax',$sorts[0])) ? "onchange='sort(this,this.value)' " : "onchange='window.location = this.value'"; ?>>
        <?php foreach ($sorts as $sorted) { ?>
        <?php if (($sort . '-' . $order) == $sorted['value']) { ?>
        <option value="<?php echo $sorted['href']; ?>" selected="selected"><?php echo $sorted['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorted['href']; ?>"><?php echo $sorted['text']; ?></option>
        <?php } ?>
        <?php } ?>
        </select>
    </div>
    <?php } ?>

    <div class="list_view">
        <?php foreach($posts as $post) { ?>
        <article>
            <div class="grid_12">
                <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>" style="text-decoration: none !important;">
                <hgroup><h1><?php echo $post['title']; ?></h1></hgroup>
                </a>

                <?php if (!empty($post['meta_description'])) { ?>
                <p><?php echo strip_tags($post['meta_description']); ?></p>
                <?php } else { echo substr($post['description'],0,250); } ?>
                <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>"><?php echo $Language->get('text_see_more'); ?></a>
            </div>
            <div class="grid_12">
                <ul class="post-footer">
                    <li class="post-date" title="<?php echo $Language->get('text_created'); ?>" style="padding:0px;"><?php echo $post['date_added']; ?></li>
                    <li class="post-rating" title="<?php echo $Language->get('text_rating'); ?>" style="padding:0px;padding-right: 20px;"><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" /></li>
                    <li class="post-visits" title="<?php echo $Language->get('text_visits'); ?>"><?php echo (int)$post['visits']; ?></li>
                    <li class="post-follow" title="<?php echo $Language->get('text_followers'); ?>"><?php echo (int)$post['followers']; ?></li>
                    <li class="post-likes" title="<?php echo $Language->get('text_likes'); ?>"><?php echo (int)$post['likes']; ?></li>
                    <li class="post-dislikes" title="<?php echo $Language->get('text_dislikes'); ?>"><?php echo (int)$post['dislikes']; ?></li>
                </ul>
            </div>
        </article>
        <?php } ?>
        <?php if ($pagination) { ?>
        <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>
    </div>
</div>
<?php } ?>