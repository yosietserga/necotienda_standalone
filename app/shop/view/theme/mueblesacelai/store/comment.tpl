<div id="msgReview"></div>
<div class="content clearfix">
    <div>
        <div class="detail">
            <textarea name="text" id="text" placeholder="Escribe tu pregunta o comentario aqu&iacute;"></textarea>
        </div>
    </div>
        <div class="label" style="margin-top: 0.875rem;">
            <strong><?php echo $Language->get('entry_rating'); ?><strong>
            <div style="display:inline; margin-left: 0.5rem;" class="detail">
                <a class="star_review" id="1"></a>
                <a class="star_review" id="2"></a>
                <a class="star_review" id="3"></a>
                <a class="star_review" id="4"></a>
                <a class="star_review" id="5"></a>
                <input type="hidden" name="rating" id="review_" value="0"/>
            </div>
        </div> 
    <div class="btn btn--primary" style="margin-top: 1.25rem;">
        <a title="<?php echo $Language->get('button_continue'); ?>" onclick="review();"><?php echo $Language->get('button_continue'); ?></a>
    </div>
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
    $('#content .star_review').hover(
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
            $('#content .star_review').each (function() {
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
                $(this).css({'background-position':'left top'});
            } else {
                $(this).removeClass();
                $(this).addClass('star_review');
                $(this).css({'background-position':'right top'});
            }
        });
    });
});

function review() {
    if ('<?php echo (bool)$islogged; ?>') {
        if ($('#text').val().length > 0) {
            $('.success, .warning').remove();
 			$('#review_button').hide();
        	$('#msgReview').html('<div class="message warning"><?php echo $Language->get('text_wait'); ?></div>');
        	$.post('<?php echo $Url::createUrl('store/product/write'); ?>&product_id=<?php echo $product_id; ?>',
        		{
                    'text': encodeURIComponent($('textarea[name=\'text\']').val()),
                    'rating': encodeURIComponent($('input[name=\'rating\']').val()) || '',
                    'product_id': '<?php echo (int)$product_id; ?>'
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
                            html = '<li id="review_'+ data.review_id +'" class="review_item row">';
                            html += '<div class="column">';
                            html += '<strong>'+ data.author +'</strong>';
                            html += '<time style="font-size: 0.835rem;font-style:italic;margin-left: 0.375rem;">'+ data.date_added +'</time>';
                            html += '</div>';
                            html += '<div class="column" style="margin-top: 0.835rem">'; 
                            html += '<img src="<?php echo HTTP_IMAGE; ?>stars_'+ data.rating +'.png" />'; 
                            html += '</div>'; 
                            html += '<div class="column" style="margin-top: 0.835rem; font-size: 0.835rem;">'+ data.text +'</div>';

                            html += '<div class="review-buttons">';
                            html += '<a class="review-reply" onclick="addReply(this,\''+ data.product_id +'\',\''+ data.review_id +'\')" style="margin-right: 0.835rem;">Replicar</a>';
                            html += '<a class="review-delete" onclick="deleteComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')" style="margin-right: 0.835rem;">Eliminar</a>';
                            html += '<a class="review-dislike" onclick="dislikeComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')" style="margin-right: 0.835rem;"></a>';
                            html += '<a class="review-like" onclick="likeComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')" style="margin-right: 0.835rem;"></a>';
                            html += '</div>';
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