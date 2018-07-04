<!-- post-info -->
<div class="info nt-hoverdir">
    <?php if ($post['rating']) { ?>
    <div class="rating">
        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" />
    </div>
    <?php }else { ?>
    <div class="rating" style="min-height: 1.063em; width: 100%;"></div>
    <?php }?>

    <a href="<?php echo $Url::createUrl('content/post',array('post_id'=>$post['post_id'])); ?>" title="<?php echo $post['name']; ?>" class="name">
        <?php echo $post['name']; ?>
    </a>
    <!--
        <div class="post-date" title="<?php echo $Language->get('text_created'); ?>">
            <span><?php echo $Language->get('text_created'); ?></span>
            <small><?php echo $post['date_added']; ?></small>
        </div>
    -->
    <p class="overview"><?php echo substr($post['overview'],0,100)."... "; ?>&nbsp;<a href="<?php echo $Url::createUrl('content/post',array('post_id'=>$post['post_id'])); ?>" title="<?php echo $post['name']; ?>">Más detalles</a></p>

    <div class="description description"><?php echo $post['description']; ?></div>

    <div class="group group--btn" role="group">
        <div class="btn btn-detail" data-action="see-post">
            <a title="<?php echo $button_see_post; ?>" href="<?php echo $Url::createUrl('content/post',array('post_id'=>$post['post_id'])); ?>"><?php echo $Language->get('Read More'); ?></a>
        </div>
    </div>

    <ul class="glossary-item-footer">
        <li class="post-visits"><?php echo (int)$post['visits']; ?> <?php echo $Language->get('Visits'); ?></li>
        <li class="post-follow"><?php echo (int)$post['followers']; ?> <?php echo $Language->get('Followers'); ?></li>
        <li class="post-likes"><?php echo (int)$post['likes']; ?> <?php echo $Language->get('Likes'); ?></li>
        <li class="post-dislikes"><?php echo (int)$post['dislikes']; ?> <?php echo $Language->get('Dislikes'); ?></li>
    </ul>
</div>
<!-- /post-info -->