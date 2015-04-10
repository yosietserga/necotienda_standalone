<div id="msgReview" class="msg-review"></div>
<div class="content comment-content">
    <div>
        <div class="comment-body">
            <textarea name="text" id="text" placeholder="Escribe tu pregunta o comentario aqu&iacute;"></textarea>
        </div>
    </div>
    <div>
        <div class="rating-heading"><?php echo $Language->get('entry_rating'); ?></div>
        <div id="content" class="rating-points">
            <!--<span><?php echo $Language->get('entry_bad'); ?></span>-->
            <a class="star_review" id="1"></a>
            <a class="star_review" id="2"></a>
            <a class="star_review" id="3"></a>
            <a class="star_review" id="4"></a>
            <a class="star_review" id="5"></a>
            <input type="hidden" name="rating" id="review_" value="0" />
            <!--<span><?php echo $Language->get('entry_good'); ?></span>-->
        </div>
    </div>
    <a title="<?php echo $Language->get('button_continue'); ?>" onclick="review();" class="button action-comment"><?php echo $Language->get('button_continue'); ?></a>
</div>

<script>
$(function(){
    $('#text').on('focus',function(e){
        $(this).animate({
            height:'100px'
        });
    }).on('blur',function(e){
        if ($(this).val().length == 0) {
            $(this).animate({
                height:'40px'
            });
        }
    });
    $('#content').hover( '.star_review'
        function() {
            var idThis = $(this).attr('id');
            $('#content .star_review').each (function() {
                var idStar = $(this).attr('id');
                if (idStar <= idThis) {
                    $(this).css({'background-position':'left top'});
                }
            });
        },
        function() {
            $('#content').each ('.star_review', function() {
                $(this).css({'background-position':'right top'});
            });
        }
    );
    $('#content .detail a').click(function() {
        var idThis = $(this).attr('id');
        $('#content input[name=rating]').val(idThis);
        $('#content .detail a').each (function() {
            var idStar = $(this).attr('id');
            if (idStar <= idThis) {
                $(this).removeClass();
                $(this).addClass('star_clicked');
                $(this).css({'background-position':'left center'});
            } else {
                $(this).removeClass();
                $(this).addClass('star_review');
                $(this).css({'background-position':'right center'});
            }
        });
    });
});

function review() {
    if ('<?php echo (bool)$islogged; ?>') {
        if ($('#text').val().length > 0) {
            $('.success, .warning').remove();
 			$('#review_button').hide();
        	$('#msgReview').html('<div class="message warning"><img src="<?php echo HTTP_IMAGE; ?>loading_1.gif" alt="<?php echo addslashes($text_wait); ?>"><?php echo $Language->get('text_wait'); ?></div>');
        	$.post('<?php echo $Url::createUrl('content/'. $object_type .'/write'); ?>&id=<?php echo $id; ?>',
        		{
                    'text': encodeURIComponent($('textarea[name=\'text\']').val()),
                    'rating': encodeURIComponent($('input[name=\'rating\']').val()) || '',
                    'id': '<?php echo (int)$id; ?>'
        		},
        		function(response) {
                    data = $.parseJSON(response);
        			$('#review_button').show();
        			$('#msgReview').html('');
        			if (typeof data.error != 'undefined') {
        				$('#msgReview').html('<div class="message warning">' + data.error + '</div>');
        			}
        			
        			if (typeof data.success != 'undefined') {
        				$('#msgReview').html('<div class="message success">' + data.success + '</div>');
        				$('#text').val('').animate({
                            height:'40px'
                        });
                        $('#content .detail a').removeClass('star_clicked').addClass('star_review');
                        $('#content .star_review').each (function() {
                            $(this).css({'background-position':'right top'});
                        });
                        if (typeof data.show != 'undefined') {
                            html = '<li id="review_'+ data.review_id +'" class="review_item">';
                            html += '<div class="grid_2">';
                            html += '<b>'+ data.author +'</b><br />';
                            html += '<img src="<?php echo HTTP_IMAGE; ?>stars_'+ data.rating +'.png" />';
                            html += '<small>'+ data.date_added +'</small>';
                            html += '</div>';
                            html += '<div class="grid_10">'+ data.text +'</div>';
                            html += '<div class="clear"></div>';
                            html += '<div class="grid_12 review-buttons">';
                            html += '<a class="review-reply" onclick="addReply(this,\''+ data.id +'\',\''+ data.review_id +'\')">Replicar</a>';
                            html += '<a class="review-delete" onclick="deleteComment(this,\''+ data.id +'\',\''+ data.review_id +'\')">Eliminar</a>';
                            html += '<a class="review-dislike" onclick="dislikeComment(this,\''+ data.id +'\',\''+ data.review_id +'\')"></a>';
                            html += '<a class="review-like" onclick="likeComment(this,\''+ data.id +'\',\''+ data.review_id +'\')"></a>';
                            html += '</div>';
                            html += '<div class="clear"></div>';
                            html += '</li>';
                            $('.review_item:first-child').before(html);
                            
                            cloned = $('#review_'+ data.review_id).clone();
                            
                            $(cloned).css({
                                'background':'#AEDF4F',
                                'position':'absolute',
                                'top':'0px',
                                'left':'0px',
                                'marginTop':'210px'
                            });
                            
                            $('#review_'+ data.review_id).closest('ul').prepend(cloned);
                            
                            $(cloned).animate({
                                'background':'#f0f0f0',
                                'width':'102%',
                                'opacity':0
                            },1200,function(){
                                $(this).remove();
                            });
                        }
                        if ($('#noComments'.legnth > 0)) {
                            $('#noComments').remove();
                        }
        			}
        		});
         } else {
            $('#msgReview').html('<div class="message warning"><?php echo $Language->get('error_text'); ?></div>');
         }
    } else {
        $('#msgReview').html('<div class="message warning"><?php echo $Language->get('error_login'); ?></div>');
    }
}
</script>