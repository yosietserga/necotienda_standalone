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
            <div class="star-item" data-hover-item="1">
                <a class="star_review" id="1" data-review-rating-star="1"></a>
            </div>
            <div class="star-item" data-hover-item="2">
                <a class="star_review" id="2" data-review-rating-star="2"></a>
            </div>
            <div class="star-item" data-hover-item="3">
                <a class="star_review" id="3" data-review-rating-star="3"></a>
            </div>
            <div class="star-item" data-hover-item="4">
                <a class="star_review" id="4" data-review-rating-star="4"></a>
            </div>
            <div class="star-item" data-hover-item="5">
                <a class="star_review" id="5" data-review-rating-star="5"></a>
            </div>
            <input data-value="review" type="hidden" name="rating" id="review_" value="0" />
            <!--<span><?php echo $Language->get('entry_good'); ?></span>-->
        </div>
    </div>
    <a title="<?php echo $Language->get('button_continue'); ?>" onclick="review();" class="button action-comment"><?php echo $Language->get('button_continue'); ?></a>
</div>

<script>

var ratingStars = '*[data-review-rating-star]';
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
    $('*[data-hover-item]').hover(
        function(e) {
            var self = this;
            var dataHoverItem = ~~self.dataset.hoverItem;

            $(ratingStars).each (function(i, e) {
                var dataReviewStar = ~~e.dataset.reviewRatingStar;
                if (dataReviewStar <= dataHoverItem) {
                    $(this).css({'background-position':'0 top'});
                }
            });
        },
        function() {
            $(ratingStars).each (function(i, e) {
                $(e).css({'background-position':'14px top'});
            });
        }
    );
    $('*[data-hover-item]').click(function(e) {
        var self = this;
        var dataHoverItem = ~~self.dataset.hoverItem;

        $('*[data-value="review"]').val(dataHoverItem);
        $(ratingStars).each (function(i, e) {
            var dataReviewStar = ~~e.dataset.reviewRatingStar;
            if (dataReviewStar <= dataHoverItem) {
                $(e).removeClass();
                $(e).addClass('star_clicked');
            } else {
                $(e).removeClass();
                $(e).addClass('star_review');
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
                            html = '<li id="review_'+ data.review_id +'" class="row review_item">';
                            html += '<div class="large-2 medium-4 small-4">';
                            html += '<span>'+ data.author +'</span>';
                            html += '<img src="<?php echo HTTP_IMAGE; ?>stars_'+ data.rating +'.png" />';
                            html += '<time datetime='.concat(data.date_added).concat(">").concat(data.date_added).concat('</time>');
                            html += '</div>';
                            html += '<div class="large-6 medium-12 small 12 columns">'+ data.text +'</div>';
                            html += '<div class="large-5 medium-12 small 12 columns review-buttons">';
                            html += '<a class="review-reply" onclick="addReply(this,\''+ data.product_id +'\',\''+ data.review_id +'\')">Replicar</a>';
                            html += '<a class="review-delete" onclick="deleteComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')">Eliminar</a>';
                            html += '<a class="review-dislike" onclick="dislikeComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')"></a>';
                            html += '<a class="review-like" onclick="likeComment(this,\''+ data.product_id +'\',\''+ data.review_id +'\')"></a>';
                            html += '</div>';
                            html += '</li>';
                            $('.review_item:first-child').before(html);
                            
                            cloned = $('#review_'+ data.review_id).clone();
                            
                            $(cloned).css({
                                'background':'#AEDF4F',
                                'position':'absolute',
                                'top':'60px',
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