$(function(){
    var elements = {
        'body': {
            childrens: [
                '#overheader',
                '#overheader .nt-editable',
                '#header',
                '#header .nt-editable',
                '#logo',
                '#search',
                '#nav',
                '#nav .nt-editable',
                '#maincontent',
                '#content',
                '#column_left',
                '#column_right',
                '#footer',
                '#footer .nt-editable'
            ],
            selector: 'body'
        },
        'column_left_box': {
            childrens: ['.header', '.content'],
            selector: '#column_left li.nt-editable',
            parents: ['column_left'],
            canMove: true,
            canDelete: true
        },
        'column_right_box': {
            childrens: ['.header', '.content'],
            selector: '#column_right li.nt-editable',
            parents: ['column_right'],
            canMove: true,
            canDelete: true
        },
        'footer_widgets': {
            childrens: ['.header', '.content'],
            selector: '#footerWidgets li.nt-editable',
            parents: ['footerWidgets'],
            canMove: true,
            canDelete: true
        },
        'content_widgets': {
            childrens: ['.header', '.content'],
            selector: '#content li.nt-editable',
            parents: ['maincontent'],
            canMove: true,
            canDelete: true
        }
    };

    addAdminControls(elements);

    $('.panel-lateral-tab').hide();
    $('#tabWidgetConfigurator').show();
    $('.panel-lateral-tabs span').on('click', function(){
        $('.panel-lateral-tab').hide();
        $('#'+ $(this).data('tab')).show();
    });
});

/**
 * Reconoce todos los elementos administrables y le asigna los botones de las acciones
 *
 * @param elements object con los elementos a administrar
 * @param areChildrens boolean si los elementos pasados son hijos de otro 
 * @return void.
 */
function addAdminControls(elements, areChildrens) {
    if (typeof areChildrens == 'undefined') {
        areChildrens = false;
    }
    
    if (typeof elements == 'undefined') {
        var elements = {
            'body': {
                childrens: [
                    '#overheader',
                    '#overheader .nt-editable',
                    '#header',
                    '#header .nt-editable',
                    '#logo',
                    '#search',
                    '#nav',
                    '#nav .nt-editable',
                    '#maincontent',
                    '#content',
                    '#column_left',
                    '#column_right',
                    '#footer',
                    '#footer .nt-editable'
                ],
                selector: 'body'
            },
            'column_left_box': {
                childrens: ['.header', '.content'],
                selector: '#column_left li.nt-editable',
                parents: ['column_left'],
                canMove: true,
                canDelete: true
            },
            'column_right_box': {
                childrens: ['.header', '.content'],
                selector: '#column_right li.nt-editable',
                parents: ['column_right'],
                canMove: true,
                canDelete: true
            },
            'footer_widgets': {
                childrens: ['.header', '.content'],
                selector: '#footerWidgets li.nt-editable',
                parents: ['footerWidgets'],
                canMove: true,
                canDelete: true
            },
            'content_widgets': {
                childrens: ['.header', '.content'],
                selector: '#content li.nt-editable',
                parents: ['maincontent'],
                canMove: true,
                canDelete: true
            }
        };

    }
    
    $.each(elements, function (i, el) {
        if (!$(el.selector) && !areChildrens) {
            return true;
        } else {
            if (areChildrens) {
                ele = $(el);
            } else {
                ele = $(el.selector);
            }
            $(ele).each(function () {
                var that = $(this);

                if (that.hasClass('administrable')) {
                    return true;
                }

                if (!that.attr('id') || that.attr('id').length == 0) {
                    that.attr('id', 'widget-' + getParentId(that) + '-' + this.tagName.toLowerCase() + '-' + that.index());
                }

                var html = "";
                html += '<div class="actions actions' + i + '">';
                html += '<a class="admin-icons style" onclick="renderPanels(\'#' + that.attr('id') + '\');$.sidr(\'open\', \'simpleMenu\');"></a>';

                if (el.canConfig) {
                    html += '<a class="admin-icons config" onclick=""></a>';
                }

                if (el.canMove) {
                    html += '<a class="admin-icons move"></a>';
                }

                if (el.canDelete) {
                    html += '<a class="admin-icons delete" onclick=""></a>';
                }

                /*  */
                html += '</div>';

                that.addClass('administrable').prepend(html);
                that.find('.actions' + i).mouseenter(function (e) {
                    that.css({
                        border: 'dashed 1px #900'
                    });
                }).mouseleave(function (e) {
                    that.css({
                        border: 'none'
                    });
                });
                if (!areChildrens && typeof el.childrens !== 'undefined') {
                    addAdminControls(el.childrens, true);
                }
            });
        }
    });
}
/**
 * Muestra y oculta las opciones avanzadas de los paneles
 *
 * @param e el enlace que acciona el evento.
 * @return void.
 */
function showAdvanced(e) {
    if ($(e).hasClass('on')) {
        $(e).removeClass('on').text('Mostrar Opciones Avanzadas');
        $(e).parent().find('.advanced:eq(0)').val(0);
    } else {
        $(e).addClass('on').text('Ocultar Opciones Avanzadas');
        $(e).parent().find('.advanced:eq(0)').val(1);
    }
    $(e).parent().find('> div').slideToggle('fast');
    
}

/**
 * Obtiene los items de una lista y los seriliza
 *
 * @param id de la lista.
 * @return array lista serializada.
 */
function getItems(id) {
    return $('#' + id).sortable('toArray').join(',');
}