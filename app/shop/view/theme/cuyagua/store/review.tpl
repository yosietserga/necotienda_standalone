<ul>
<?php if (!empty($reviews)) { ?>
    <?php foreach ($reviews as $review) { ?>
    <li id="review_<?php echo $review['review_id']; ?>" class="row review-item">
        <div class="reviewer-info large-6 medium-12 small-12 columns">
            <span class="name" rel="author"><?php echo $review['author']; ?></span>
            <time class="date" datetime="<?php echo $review['date_added']; ?>"><?php echo $review['date_added']; ?></time>
            <img class="rating" src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['stars']; ?>" />
        </div>
        <div class="review-content large-8 medium-12 small-12 columns">
            <p class="review-body"><?php echo $review['text']; ?></p>
        </div>
        <ul class="replies">
        <?php if ($review['replies']) { ?>
            <?php foreach ($review['replies'] as $reply) { ?>
            <li id="reply_<?php echo $review['review_id']; ?>_<?php echo $reply['review_id']; ?>" class="reply_<?php echo $review['review_id']; ?>">
                <div class="reply-heading large-12 medium-12 small-12 columns">
                    <span><?php echo $reply['author']; ?></span>
                    <small><?php echo date('d-m-Y h:i A',strtotime($reply['date_added'])); ?></small>
                </div>
                <div class="reply-body large-12 medium-12 small-12 columns">
                    <?php echo $reply['text']; ?>
                </div>
            </li>
            <?php } ?>
        <?php } ?>
        </ul>
        <?php if ($isLogged) { ?>
        <div class="review-actions large-12 medium-12 small-12 columns">
            <a class="review-reply" onclick="addReply(this,'<?php echo $review['product_id']; ?>','<?php echo $review['review_id']; ?>')">Replicar</a>
            <?php if ($review['isOwner']) { ?><a class="review-delete" onclick="deleteReview(this,'<?php echo $review['product_id']; ?>','<?php echo $review['review_id']; ?>')">Eliminar</a><?php } ?>
            <a class="review-like" onclick="likeReview(this,'<?php echo $review['product_id']; ?>','<?php echo $review['review_id']; ?>')" title="<?php echo $Language->get('text_like'); ?>"></a>
            <a class="review-dislike" onclick="dislikeReview(this,'<?php echo $review['product_id']; ?>','<?php echo $review['review_id']; ?>')" title="<?php echo $Language->get('text_dislike'); ?>"></a>
            <a class="data-likes"><i class="fa fa-thumbs-up"></i><?php echo (int)$review['likes']; ?></a>
            <a class="data-dislikes"><i class="fa fa-thumbs-down"></i><?php echo (int)$review['dislikes']; ?></a>
        </div>
        <?php } ?>
    </li>
    <?php } ?>
<?php } else { ?>
    <li id="noComments" class="review_item"><?php echo $Language->get('text_no_reviews'); ?></li>
<?php } ?>
</ul>
<?php if (!empty($reviews)) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
<script type="text/javascript">
function addReply(e,p,r) {
    $('textarea[name=replyText]').remove();
    $('input[name=replySubmit]').remove();
    
    var textarea = $(document.createElement('textarea')).attr({
        'name':'replyText',
        'id':'replyText',
        'placeholder':'Agrega tu comentario'
    }).css({
        'height':'40px'
    })
    .focus(function(e) {
        $(textarea).removeClass('neco-input-error');
        $(this).animate({
            'width':'90%',
            'height':'100px',
        });
    }).blur(function(e) {
        if ($(this).val().length == 0) {
            $(this).slideUp(function(){
                $('textarea[name=replyText]').remove();
                $('input[name=replySubmit]').remove();
            });
        }
    });
    
    var button = $(document.createElement('input')).attr({
        'name':'replySubmit',
        'id':'replySubmit',
        'type':'button'
    })
    .val('<?php echo $Language->get('button_continue'); ?>')
    .after('<div class="clear"></div>')
    .on('click',function(e) {
        $(this).hide();
        if ($('#replyText').val().length > 0) {
            $('#replyText').before('<div class="message success"><img src="<?php echo HTTP_IMAGE; ?>loading_1.gif" alt="<?php echo addslashes($Language->get('text_wait')); ?>"><?php echo $Language->get('text_wait'); ?></div>');
            $.post('<?php echo $Url::createUrl("store/product/reply"); ?>&product_id='+ p +'&review_id='+ r,
            {
                'product_id':p,
                'review_id':r,
                'text':encodeURIComponent($('#replyText').val())
            },
            function(response){
                $('.message').remove();
                data = $.parseJSON(response);
                if (typeof data.success != 'undefined') {
                    if (typeof data.show != 'undefined') {
                        $('#replyText').before('<div class="message success">Ha replicado con &eacute;xito</div>');
                        html = '<li>';
                        html += '<div class="grid_2">';
                        html += '<b>'+ data.author +'</b>';
                        html += '<small>'+ data.date_added +'</small>';
                        html += '</div>';
                        html += '<div class="grid_10">'+ data.text +'</div>';
                        html += '<div class="clear"></div>';
                        html += '</li>';
                        $('#review_'+ r +' .replies').append(html);
                    } else {
                        $('#replyText').before('<div class="message success">Ha replicado con &eacute;xito, estamos verificando el contenido para publicarlo</div>');                
                    }
                } else {
                    $('#replyText').before('<div class="message warning">No se pudo agregar la r&eacute;plica. Por favor intente m&aacute;s tarde.</div>');
                }
                $('textarea[name=replyText]').remove();
                $('input[name=replySubmit]').remove();
            });
        } else {
            $(this).show();
            $('#replyText').addClass('neco-input-error');
        }
    });
    
    if ($('textarea[name=replyText]').length==0) {
        $(e).before(textarea);
        $(e).before(button);
    }
}
function deleteReview(e,p,r) {
    if (confirm('<?php echo $Language->get('text_confirm_delete'); ?>')) {
        $('#review_'+ r).slideUp(function(){
            $(this).remove();
        });
        $.post('<?php echo $Url::createUrl("store/product/deleteReview"); ?>&product_id='+ p +'&review_id='+ r,
            {
                'product_id':p,
                'review_id':r
            });
    }
}
function likeReview(e,p,r) {
    $.post('<?php echo $Url::createUrl("store/product/likeReview"); ?>&product_id='+ p +'&review_id='+ r,
    {
        'product_id':p,
        'review_id':r
    }, function(response) {
        var data = $.parseJSON(response);
        if (typeof data.success != 'undefined') {
            likes = $('#review_'+ r).find('.likes').html( data.likes );
            dislikes = $('#review_'+ r).find('.dislikes').html( data.dislikes );
        }
    });
}
function dislikeReview(e,p,r) {
    $.post('<?php echo $Url::createUrl("store/product/dislikeReview"); ?>&product_id='+ p +'&review_id='+ r,
    {
        'product_id':p,
        'review_id':r
    }, function(response) {
        var data = $.parseJSON(response);
        if (typeof data.success != 'undefined') {
            likes = $('#review_'+ r).find('.likes').html( data.likes );
            dislikes = $('#review_'+ r).find('.dislikes').html( data.dislikes );
        }
    });
}
</script>