<script>
    (function ($, window, undefined) {
        'use strict';

        var CommentBox;

        CommentBox = (function () {
            var updateLikeness;
            var PLUGIN = "cb";
            var init;
            var updateCommentIdentity;
            var makePlaceholderData;
            var makeDom;
            var makeReply;
            var remove;
            var getData;
            var saveComment;
            var submitReply;
            var save;
            var dislike;
            var like;
            var destroy;
            var add;
            var initBus;
            var dispatch;
            var subscribeAll;
            var subscribe;
            var makeCommentView;
            var e = {};
            var d = {};
            var c = {};

            init = function ($root, contextID) {
                var m = subscribeAll();
                $root.click(function (event) {
                    event.stopPropagation();
                    initBus(event, contextID, m);
                });
            };

            /*--------------------------------------------------------/
             /----------------->>>Markup Builders<<<-------------------/
             /--------------------------------------------------------*/

            makeCommentView = function (data) {
                var markup = [
                    '<li id="review_' + data.review_id + '" data-id-comment="' + data.review_id + '" class="row review_item pending-comment" data-component="comment">',
                    '<div class="review-block">',
                    '<div class="reply-heading reviewer-info large-12 medium-12 small-12 columns">',
                    '<span class="name">' + data.author + '</span>',
                    '<time class="date">' + data.date_added + '</time>',
                    (data.rating) ? '<img class="rating" src="<?php echo HTTP_IMAGE; ?>' + 'stars_' + data.rating + '.png' + '" />' : '',
                    '</div>',

                    '<div class="reply-body review-content large-12 medium-12 small-12 columns">',
                    '<p class="review-body">' + data.text + '</p>',
                    '</div>',

                    '<div class="review-actions large-12 medium-12 small-12 columns">',
                    '<div class="crud-actions">',
                    '<a class="review-reply" data-action="addReply" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">', 'Replicar', '</a>',
                    '<a class="review-delete" data-action="deleteReview" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">', 'Eliminar', '</a>',
                    '</div>',
                    '<div class="engagement-actions">',
                    '<a class="review-like" data-action="likeReview" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">', 'Me gusta', '</a>',
                    '<a class="review-dislike" data-action="dislikeReview" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">', 'No me gusta', '</a>',
                    '<a class="data-likes">',
                    '<i class="icon icon-thumb-up">',
                    '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/like.tpl"); ?>',
                    '</i>',
                    '<ins data-count="likes"><?php echo (int)$review['likes']; ?></ins>',
                    '</a>',
                    '<a class="data-dislikes">',
                    '<i class="icon icon-thumb-down">',
                    '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/like.tpl"); ?> ',
                    '</i>',
                    '<ins data-count="dislikes"><?php echo (int)$review['dislikes']; ?></ins>',
                    '</a>',
                    '</div>',
                    '</div>',
                    '</div>',
                    '</li>'
                ];
                return $(markup.join(""));
            };


            makeReply = function (data) {
                var markup = [
                    '<div data-component="commentBox" data-id-comment-box="' + data.review_id + '" class="reply-box large-12 medium-12 small-12 columns">',
                    '<div data-component="commentWriter"><textarea name="replyText" id="replyText" class="reply-text" placeholder="Agrega tu comentario"></textarea></div>',
                    '<div class="actions reply-actions">',
                    '<button type="submit" data-action="submitReply" class="reply-action" id="replySubmit" type="submit" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">' + '<?php echo $Language->get("button_continue"); ?>' + '</button>',
                    '<button type="submit" data-action="cancelReply" class="cancel-action" id="replyCancel" type="submit" data-id-product="' + data.product_id + '" data-id-review="' + data.review_id + '">' + '<?php echo $Language->get("Cancel"); ?>' + '</button>',
                    '</div>',
                    '</div>'
                ].join("");
                return $(markup);
            };


            /*----------------------------------------------------------/
             /------------------->>>HELPERS<<<---------------------------/
             /----------------------------------------------------------*/


            getData = function (DOM) {
                var text = DOM.$commentWriter.find('textarea').val();
                var rating = DOM.$commentBox.find('[data-value="productRating"]').val();
                var data = {
                    text: text
                };
                if (rating !== undefined) {
                    data.rating = rating;
                }
                return data;
            };

            makePlaceholderData = function () {
                var dt = new Date();
                var author = function() {
                    if ('<?php echo $this->customer->getFirstName(); ?>' && '<?php echo $this->customer->getLastName(); ?>') {
                        return '<?php echo $this->customer->getFirstName(); ?>' + ' ' + '<?php echo $this->customer->getLastName(); ?>';
                    }
                    return 'Guest';
                };
                return {
                    author: author(),
                    date_added: dt.getDate() + "/" + (dt.getMonth() + 1) + "/" + dt.getFullYear()
                };
            };

            updateLikeness = function ($review, data) {
                if (typeof data.success !== undefined) {
                    $review.find('[data-count="likes"]').text(data.likes);
                    $review.find('[data-count="dislikes"]').text(data.dislikes);
                }
            };

            /*----------------------------------------------------------/
             /----------------->>>COMMENT ACTIONS<<<---------------------/
             /----------------------------------------------------------*/

            /* UI Controls -----------------*/

            add = function (context) {
                var data = context.data;
                var commentBlock = context.DOM.$reviewItem.find('[data-component="commentItem"]');
                commentBlock.append(makeReply(data));
            };

            remove = function (context) {
                context.DOM.$commentBox.remove();
            };

            /* Crud -----------------*/

            save = function (action, data) {
                var requestUrl = '<?php echo $Url::createUrl("store/product/"); ?>' + action;
                if (data.product_id) {
                    requestUrl += '&product_id=' + data.product_id;
                }
                if (data.review_id) {
                    requestUrl += '&review_id=' + data.review_id;
                }
                return $.post(requestUrl, data, null, 'json');
            };

            destroy = function (context) {
                if (confirm('<?php echo $Language->get('text_confirm_delete'); ?>'))
                {
                    $('#review_' + context.data.review_id).slideUp(function () {
                        $(this).remove();
                    });
                    save("deleteReview", context.data);
                }
            };

            /* Update-----------------------------------*/

            like = function (context) {
                var p = context.data.product_id;
                var r = context.data.review_id;
                var $review = $('#review_' + r);
                $.post('<?php echo $Url::createUrl("store/product/likeReview"); ?>&product_id=' + p + '&review_id=' + r,
                {
                    'product_id': p,
                    'review_id': r
                }, function (response) {
                    var data = $.parseJSON(response);
                    updateLikeness($review, data);
                });
            };

            dislike = function (context) {
                var p = context.data.product_id;
                var r = context.data.review_id;
                var $review = $('#review_' + r);
                $.post('<?php echo $Url::createUrl("store/product/dislikeReview"); ?>&product_id=' + p + '&review_id=' + r,
                {
                    'product_id': p,
                    'review_id': r
                }, function (response) {
                    var data = $.parseJSON(response);
                    updateLikeness($review, data);
                });
            };


            submitReply = function (context) {
                var request;
                var data = $.extend(context.data, getData(context.DOM));
                var commentItem = $("#review_" + data.review_id);

                request = save("reply", data);
                request.then(function (response) {
                    var newData = $.parseJSON(response);
                    var newCommentBox = makeCommentView(newData);
                    commentItem.append(newCommentBox);
                });
            };

            /*----------------------------------------------------------/
             /----------------->>>COMMENT ACTIONS<<<---------------------/
             /----------------------------------------------------------*/

            updateCommentIdentity = function ($el, data) {
                $el[0].id = "review_" + data.review_id;
                $el.attr('data-id-comment', data.review_id);
            };

            saveComment = function (context) {
                var request;
                var $commentBox = $("#comment");
                var $textarea = $commentBox.find("textarea");
                var text = $textarea.val();
                var rating = $commentBox.find('[data-value="productRating"]').val();
                var placeholderData = $.extend(makePlaceholderData(), {text: text, rating : rating});
                var data = $.extend(context.data, {
                    text: encodeURIComponent(text),
                    rating: rating}
                );

                var $commentsListComponent = $('[data-component="commentsList"]');
                var $noComments = $('#noComments');
                var $newCommentBox = makeCommentView(placeholderData);


                if ($noComments.length) {
                    $noComments.replaceWith($newCommentBox);
                } else {
                    $commentsListComponent.append($newCommentBox);
                }

                request = save("write", data);
                $textarea.val("");
                request.then(function (response) {
                    updateCommentIdentity($newCommentBox, response);

                }).done(function () {
                    $newCommentBox.removeClass('pending-comment');
                });
            };

            /*--------------------------------------------------------/
             /----------------->>>EVENT INITIALIZATION*<<<-------------/
             /--------------------------------------------------------*/

            subscribe = function (actionMap, id, fn) {
                actionMap[id] = fn;
            };

            dispatch = function (actionMap, id, data) {
                if (id && actionMap[id]) {
                    actionMap[id](data);
                }
            };

            makeDom = function ($ref, data) {
                var $comment = $('[data-id-comment="' + data.review_id + '"]');
                var $commentBox = $comment.find('[data-component="commentBox"]');
                var $commentWriter = $commentBox.find('[data-component="commentWriter"]');
                return {
                    $ref: $ref,
                    $reviewItem: $comment,
                    $commentWriter: $commentWriter,
                    $commentBox: $commentBox
                };
            };

            initBus = function (event, contextID, actionMap) {
                var $ref = $(event.target);
                var $comment = $ref.closest("[data-id-comment]");
                var actionId = $ref.attr('data-action') || false;
                var commentId = $comment.attr('data-id-comment') || false;
                var data = {
                    "product_id": contextID,
                    "review_id": "0"
                };
                if (commentId) {
                    data["review_id"] = commentId;
                }
                dispatch(actionMap, actionId, {
                    DOM: makeDom($ref, data),
                    data: data
                });
            };

            subscribeAll = function () {
                var m = {};
                subscribe(m, "addReply", add);
                subscribe(m, "deleteReview", destroy);
                subscribe(m, "likeReview", like);
                subscribe(m, "dislikeReview", dislike);
                subscribe(m, "submitComment", saveComment);
                subscribe(m, "submitReply", submitReply);
                subscribe(m, "cancelReply", remove);

                return Object.freeze(m);
            };

            return {
                init: init
            };
        })();

        window.CommentBox = CommentBox;
    })(jQuery, window, undefined);
</script>