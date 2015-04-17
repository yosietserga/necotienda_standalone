$(function(){    
    $('#qWidgets').on('change',function(e){
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
            
    bgPreloader = $(document.createElement('div')).css({
        position:'fixed',
        top:'0px',
        left:'0px',
        background:'rgba(0,0,0,0.5)',
        height:'100%',
        width:'100%',
        display:'block',
        'z-index':'9998'
    }).attr({
        id:'bgPreloader'
    }).appendTo('body');
    
    divPreloader = $(document.createElement('div')).css({
        'position':'fixed',
        'top':'40%',
        'left':'40%',
        'margin':'0px auto',
        'padding':'5px',
        'background':'#fff',
        'height':'100px',
        'width':'280px',
        'display':'block',
        'boxShadow':'0px 0px 4px #000',
        'borderRadius':'4px',
        'textAlign':'center',
        'z-index':'9999'
    }).attr({
        id:'divPreloader'
    }).html('<b style="color:#000;">Por favor espere mientras se cargan los complementos.</b><br /><img src="'+ window.nt.http_admin_image +'loader.gif" alt="Cargando..." />').appendTo('body');
    
    $.ajaxQueue().then(function(response){
        divPreloader.remove();
        bgPreloader.remove();
    });
    
    var data = {};
    
    $('a.advanced').on('click', function(e) {
        div = $(this).closest('li').find('div.attributes:eq(0)');
        if (div.hasClass('on')) {
            div.removeClass('on').slideUp();
        } else {
            div.addClass('on').slideDown();
        }
    });
    
    $("#widgetsPanel li").draggable({
        connectToSortable:'.widgetWrapper',
        revert: "invalid",
        helper: function(event){
            data.name = $(this).data('title');
            data.extension = $(this).data('widget');
            data.id = "widget_" + data.extension + "_" + rand();
            output = '';
            output += '<b class="widgetTitle">' + data.name + '</b><br />';
            output += '<a class="advanced">Advanced</a><br />';
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
    
    $(".widgetWrapper").sortable({
        placeholder: "widgetPlaceHolder",
        connectWith: '.widgetWrapper',
        revert: true,
        cursor: 'move',
        handle: '.moveWidget',
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
                data.position = $(this).data('position');
                data.wrapper = $(this);
                data.sort_order = ($(data.item).index() + 1);         
                
                data.inputs = '<input class="widgetName" type="hidden" name="Widgets[' + data.id + '][name]" id="' + data.id + '_name" value="' + data.id + '" /><input class="widgetPosition" type="hidden" name="Widgets[' + data.id + '][position]" id="' + data.id + '_position" value="' + data.position + '" /><input class="widgetSortOrder" type="hidden" name="Widgets[' + data.id + '][order]" id="' + data.id + '_order" value="'+ data.sort_order +'" />';
                
                var widgetId = data.id;
                
                $.ajaxQueue({
                    url: createAdminUrl('module/'+ data.extension +'/widget', 'store_id='+ getUrlVars()['store_id']),
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
                            $('.widgetTitle').after('<img src="'+ window.nt.http_admin_image +'small_loading.gif" class="saving" />');
                            $.post(createAdminUrl('module/'+ widgetModule +'/widget', {
                                store_id:getUrlVars()['store_id'],
                                name:widgetName,
                                order:data.sort_order,
                                position:data.position
                            }), 
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
    })/* .disableSelection() */;
    
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
    $.post(createAdminUrl('style/widget/sortable'),data);
}

function deleteWidget(e) {
    if (confirm("\xbfEst\u00E1 seguro que desea eliminar este widget?")) {
        var li = $(e).closest("li");
        var widgetName = $(li).attr('id');
        li.fadeOut(function(){
            li.remove();
        });
        $.getJSON(createAdminUrl('style/widget/delete', 'name='+ widgetName));
    }
}

function rand (min, max) {
    if (!min && !max) {
        min = 0;
        max = 2147483647;
    }
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function loadNtWidgets(widget) {
    if (typeof widget.extension == 'undefined' ||
        typeof widget.position == 'undefined' ||
        typeof widget.name == 'undefined' ||
        typeof widget.order == 'undefined') {
        return false;
    }
    
    $.ajaxQueue({
        url: createAdminUrl("module/"+ widget.extension +"/widget", "w=1"),
        dataType: "json",
        data:widget
    }).done(function( data ) {
        $('#'+ widget.name +' .attributes').html(data.html);
        $('#'+ widget.name +'_form').append('<input type="hidden" name="Widgets['+ widget.name +'][position]" value="'+ widget.position +'" /><input type="hidden" name="Widgets['+ widget.name +'][order]" value="'+ widget.order +'" /><input type="hidden" name="Widgets['+ widget.name +'][name]" value="'+ widget.name +'" />');
        $('.widgetWrapper').find("input, select, textarea, p")
        .bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(e) {
            e.stopImmediatePropagation();
        });
        $('#'+ widget.name +'').find('input, select, textarea').on('change',function(event){
            $('.saving').remove();
            $('#'+ widget.name +' .widgetTitle').after('<img src="'+ window.nt.http_admin_image +'small_loading.gif" class="saving" />');
            $.post(createAdminUrl("module/"+ widget.extension +"/widget", {
                name:widget.name,
                order:widget.order,
                position:widget.position
            }), 
            $('#'+ widget.name +'_form').serialize(),
            function(respons){
                $('.saving').remove();
                resp = $.parseJSON(respons);
            });
        });
    });
}