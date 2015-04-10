<input type="text" name="searchWidget" id="searchWidget" value="" placeholder="<?php echo $Language->get('Search Widget...'); ?>" />
<div class="clear"></div>
<ul id="widgetsPanel" class="widgetsPanel"></ul>

<script type="text/javascript" src="<?php echo HTTP_ADMIN; ?>js/vendor/jquery.ajaxqueue.min.js"></script>
<script>
$(function(){
    var data = {};
    
    $.getJSON('<?php echo $Url::createAdminUrl('style/widget/getalljson', [], 'NONSSL', HTTP_ADMIN); ?>',
    {
        store_id:'<?php echo (int)STORE_ID; ?>'
    },
    function(data){
        if (data.modules) {
            var html = '';
            $.each(data.modules, function(i, item){
                html += '<li class="neco-widget" data-title="'+ item.name +'" data-widget="'+ item.widget +'">'
                +'<b>'+ item.name +'</b><br />'
                +item.description
                +'</li>';
            });
            $('#widgetsPanel').append(html);
               
            $('#searchWidget').on('change',function(e){
                var that = this;
                var valor = $(that).val().toLowerCase();
                if (valor.length <= 0) {
                    $('#widgetsPanel li').show();
                } else {
                    $('#widgetsPanel li b').each(function(){
                        if ($(this).text().toLowerCase().indexOf( valor ) > 0) {
                            $(this).closest('li').show();
                        } else {
                            $(this).closest('li').hide();
                        }
                    });
                }
            });
            
            $("#widgetsPanel li").draggable({
                connectToSortable:'ul.widgets',
                revert: "invalid",
                helper: function(event){
                    data.name = $(this).data('title');
                    data.extension = $(this).data('widget');
                    data.id = "widget_" + data.extension + "_" + rand();

                    /**
                     * renderizar un elemento vacío con el botón configurar y al hacer click
                     * abrir el panel lateral en la pestaña de configuración con los campos de este widget 
                     * para configurar y al final final un botón en el panel que diga Actualizar
                     * y al hacer click en él renderizar el widget en el frontend tal cual como debe ser
                     * generando el html por ajax, ya cuando se actualice la página si lo cargará por php
                     */

                    output = '';
                    output += '<b class="widgetTitle">' + data.name + '</b><br />';
                    output += '<a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />';
                    output += '<div class="attributes"></div>';
                    output += '<div style="float:right">';
                    output += '<a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>';
                    output += '<a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>';
                    output += '</div>';

                    data.html = output;
                    data.widget = $(this).clone();
                    data.widget.attr('id',data.id).addClass('widgetSet').html(output);

                    return data.widget;
                }
            });    
    
            $('ul.widgets').sortable({
                forceHelperSize: true,
                forcePlaceholderSize: true,
                connectWith: 'ul.widgets',
                handle: '.move',
                opacity: 0.8,
                dropOnEmpty: true,
                placeholder: 'placeholder',
                start: function(event,ui){
                    if ($(this).data().uiSortable) {
                        data.item = $($(this).data().uiSortable.currentItem);
                    } else if ($(this).data()['ui-sortable']) {
                        data.item = $($(this).data()['ui-sortable'].currentItem);
                    } else if ($(this).data().sortable) {
                        data.item = $($(this).data().sortable.currentItem);
                    } else {
                        console.log('No se definió jquery ui sortable');
                    }

                    if (data.name) {
                        data.item.attr('id',data.id).removeClass('neco-widget').addClass('widgetSet').html(output);
                    }
                },
                receive:function(event,ui) {
                    if (data.name) {
                        /**
                         * renderizar la configuracion del widget en el panel lateral
                         */
                        data.position = $(this).data('position');
                        data.wrapper = $(this);
                        data.sort_order = ($(data.item).index() + 1);
                        console.log(data);

                        data.inputs = '<input class="widgetName" type="hidden" name="Widgets[' + data.id + '][name]" id="' + data.id + '_name" value="' + data.id + '" />'
                                +'<input class="widgetPosition" type="hidden" name="Widgets[' + data.id + '][position]" id="' + data.id + '_position" value="' + data.position + '" />'
                                +'<input class="widgetSortOrder" type="hidden" name="Widgets[' + data.id + '][order]" id="' + data.id + '_order" value="'+ data.sort_order +'" />';

                        var widgetId = data.id;
                        
                        $.ajaxQueue({
                            url: '<?php echo HTTP_ADMIN; ?>index.php?r=module/'+ data.extension +'/widget&token=<?php echo $_SESSION[C_CODE . '_ukey']; ?>&store_id=<?php echo STORE_ID; ?>',
                            dataType: "json",
                            data:{
                                'extension':data.extension,
                                'order':data.sort_order,
                                'position':data.position,
                                'name':data.id
                            }
                        }).done(function( response ) {
                            if (typeof response.html != 'undefined') {
                                $('#'+ widgetId +' div.attributes').append(response.html);
                                $('#'+ widgetId +'_form').append(data.inputs);

                                $('#'+ widgetId +' a.advanced').on('click', function(e) {
                                    div = $(this).closest('li').find('div.attributes:eq(0)');
                                    if (div.hasClass('on')) {
                                        div.removeClass('on').slideUp();
                                    } else {
                                        div.addClass('on').slideDown();
                                    }
                                });

                                var widgetModule = data.extension;
                                var widgetName = widgetId;
                                var widgetLi = $('#'+ widgetId);

                                $('#'+ widgetId).find('input, select, textarea').on('change',function(event){
                                    $('.widgetTitle').after('<img src="<?php echo HTTP_ADMIN_IMAGE; ?>small_loading.gif" class="saving" />');
                                    $.post('<?php echo HTTP_ADMIN; ?>index.php?r=module/'+ widgetModule +'/widget&token=<?php echo $_SESSION[C_CODE . '_ukey']; ?>&store_id=<?php echo STORE_ID; ?>&name='+ widgetName +'&order='+ data.sort_order +'&position='+ data.position, 
                                    $('#'+ widgetId +'_form').serialize(),
                                    function(respons){
                                        $('.saving').remove();
                                        resp = $.parseJSON(respons);
                                        if (typeof resp.error != 'undefined') {

                                        }
                                        if (typeof resp.success != 'undefined') {

                                        }
                                    });
                                });
                            }
                            $(".widgetWrapper").find("input, select, textarea")
                            .bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(e) {
                                e.stopImmediatePropagation();
                            });
                        });
                        data.name = null;
                        addAdminControls();
                    } else {
                        console.log('nothing happen');
                    }
                },
                stop: function () {
                    $(this).find("input, select, textarea")
                    .bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(e) {
                        e.stopImmediatePropagation();
                    });
                },
                update: function(event,ui){
                    if (!data.name) {
                        setOrder();
                    }
                }
            })
            .append('<li>&nbsp;</li>');
        }
    });
});

function setOrder() {
    data = {};
    $('.widgetSet').each(function(){
        $(this).find('.widgetPosition').val( $(this).closest('.widgetWrapper').data('position') );
        $(this).find('.widgetSortOrder').val( ($(this).index() + 1) );
        data[$(this).attr('id')] = {
            'name':$(this).attr('id'),
            'position':$(this).closest('.widgetWrapper').data('position'),
            'order':($(this).index() + 1)
        };
    });
    $.post('<?php echo $Url::createAdminUrl('style/widget/sortable', [], 'NONSSL', HTTP_ADMIN); ?>',data);
}
function deleteWidget(e) {
    if (confirm("\xbfEst\u00E1 seguro que desea eliminar este widget?")) {
        var li = $(e).closest("li");
        var widgetName = $(li).attr('id');
        li.fadeOut(function(){
            li.remove();
        });
        $.getJSON('<?php echo $Url::createAdminUrl('style/widget/delete', [], 'NONSSL', HTTP_ADMIN); ?>&name='+ widgetName);
    }
}
function rand (min, max) {
    if (!min && !max) {
        min = 0;
        max = 2147483647;
    }
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>