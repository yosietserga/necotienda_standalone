<script>
    (function () {
        window.deferjQuery(function () {
            window.appendScriptSource("<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js");
            window.appendScriptSource("<?php echo HTTP_JS; ?>necojs/neco.form.js");

        });

        window.deferPlugin('datepicker', function () {
            window.deferPlugin('ntForm',function () {
                var body =  $('body');
                var methods = $('*[data-action="payment"]');

                var loadingIcon = ['<i class="spinner-loader icon">',
                    '<?php include(DIR_TEMPLATE. $this->config->get("config_template") . "/shared/icons/loader.tpl"); ?>',
                    '</i>'].join('');


                var bodyOverlayClosedStateStyle = {
                    overflow:   'auto',
                    marginRight: '0rem'
                };
                var bodyOverlayOpenStateStyle = {
                    overflow: 'hidden',
                    marginRight: '1.063rem'
                };
                var overlayClosedStateStyle = {
                    opacity: 0
                };
                var overlayOpenStateStyle = {
                    opacity: 1,
                    position: "fixed"
                };
                var overlay, appendMessage, appendOverlay, clearForm, onCloseOverlay, createMessage, createOverlay, initPaymentMethod, hasAttr;

                appendMessage = function (target, messageElement) {
                    var target = $(target);
                    target.find('.spinner-loader').remove();
                    target.append(messageElement);
                };
                clearForm = function () {
                    form.find('input')
                        .val('')
                        .removeAttr('checked')
                        .removeClass('neco-input-success')
                        .removeClass('neco-input-error');
                    form.find('select')
                        .removeClass('neco-input-success')
                        .removeClass('neco-input-error');
                    form.find('textarea')
                        .val('')
                        .removeClass('neco-input-success')
                        .removeClass('neco-input-error');
                };
                createMessage = function (type, message) {
                    var message = $('<div>').attr({
                        'id': 'temp',
                        'class': 'message overlayed ' +  type
                    }).html(message);
                    return message;
                };
                createOverlay = function () {
                    var overlay = overlay ||$('<div>');
                    overlay.attr({
                        'class':'overlay-view',
                        'id': 'temp'
                    }).css(overlayOpenStateStyle)
                        .html(loadingIcon);
                    overlay.on('click', function (e) {
                        onCloseOverlay(overlay);
                        return false;
                    });
                    return overlay;
                };
                onCloseOverlay = function (target) {
                    var $target = $(target);
                    if ($target) {
                        $target.css(overlayClosedStateStyle);
                        $target.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function (e) {
                            body.css(bodyOverlayClosedStateStyle);
                            $target.off();
                            $target.empty();
                            $target.remove();
                        });
                    }
                };
                appendOverlay = function (overlay) {
                    body.css(bodyOverlayOpenStateStyle);
                    body.append(overlay);
                };
                initPaymentMethod = function ($form) {
                    var withAsync = ($form[0]) ? $form[0].hasAttribute('data-async') : false;
                    var request = $form.attr('action');

                    $form.ntForm({
                        ajax: withAsync,
                        url: request,
                        beforeSend: function() {
                            if (withAsync) {
                                appendOverlay(createOverlay());
                            }
                        },
                        success: function(data) {
                            if (typeof data.error !== 'undefined' && typeof data.msg !== 'undefined') {
                                appendMessage("#temp", createMessage('error', data.msg));
                            }
                            else if (typeof data.warning !== 'undefined') {
                                appendMessage("#temp", createMessage('warning', data.msg));
                            }
                            else if (typeof data.success !== 'undefined') {
                                clearForm();
                                appendMessage("#temp", createMessage('success', data.msg));
                            }
                            if (typeof data.redirect !== 'undefined') {
                                window.location.href = data.redirect;
                            }
                        }
                    });
                };
                methods.each(function (i, method) {
                    var $form = $(method).find('[data-form="payment"]');
                    initPaymentMethod($form);
                });
            });
        });
    })();
</script>