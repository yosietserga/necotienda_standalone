$(function(){
    $('.dd').click(function () {
		$('ul.menu_body').slideUp(200);
		$(this).find('ul.menu_body').slideDown(200);
	});
	
	$(document).bind('click', function(e) {
	var $clicked = $(e.target);
	if (! $clicked.parents().hasClass("dd"))
		$("ul.menu_body").slideUp(200);
	});
});

/**
 * Muestra y oculta los paneles laterales
 *
 * @param panel el identificador del panel.
 * @return false si panel es undefined.
 */
function slidePanel(panel) {
    if (typeof panel == 'undefined') {
        return false;
    }
    that = $('#' + panel);
    $('.panel-lateral').each(function(){
        if (this.id != that.attr('id')) {
            $('body,html').animate({
                'marginLeft':'0px'
            });
            
            $(this).animate({
                'marginLeft':'0px',
            })
            .find('.label')
            .css({
                'display':'none'
            });
        }
    });
    
    if (that.hasClass('on')) {
        $('body,html').animate({
            'marginLeft':'0px'
        });
       that.animate({
            'marginLeft':'0px'
        })
        .removeClass('on');
        
        $('.panel-lateral').find('.label')
        .css({
            'display':'block'
        });
    } else {
        $('body,html').animate({
            'marginLeft':'20%'
        });
        that.animate({
            'marginLeft':'30%'
        }).addClass('on')
        .find('.label')
        .css({
            'display':'block'
        });
    }
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