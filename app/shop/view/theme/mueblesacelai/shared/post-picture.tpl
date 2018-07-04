<!-- post-picture -->
<figure class="picture">
    <a href="<?php echo $Url::createUrl('content/post', array('post_id'=>$post['post_id'])); ?>" class="thumb" title="<?php echo $post['name']; ?>">
        <img src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>"/>
    </a>
</figure>
<!--/post-picture-->