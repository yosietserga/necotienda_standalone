$(function(){

    var currentMarginLeft = 0;
    var currentWidth = 0;

    $('#showAdminPanel').sidr({
        displace: false,
        onOpen: function() {
            currentMarginLeft = $("html").css("marginLeft");
            currentWidth = $("html").width();
            $("html").css({
                "marginLeft":300 +'px',
                width: (currentWidth - 300) +'px'
            });
        },
        onClose: function() {
            $("html").css({
                "marginLeft":currentMarginLeft,
                width: currentWidth +'px'
            });
        }
    });

    $('window').on('resize', function(){
        currentMarginLeft = $("body").css("marginLeft");
        $.sidr('close', 'sidr');
    });

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
function addAdminControls() {
    var i = 0;
    $('.nt-editable, [nt-editable]').each(function () {

        var that = $(this);

        if (that.hasClass('administrable')) {
            return true;
        }

        if (!that.attr('id') || that.attr('id').length == 0) {
            that.attr('id', 'widget-' + getParentId(that) + '-' + this.tagName.toLowerCase() + '-' + that.index());
        }

        var html = "";
        html += '<div class="actions actions' + i + '">';
        html += '<a class="admin-icons style" onclick="renderPanels(\'#' + that.attr('id') + '\');$.sidr(\'open\', \'sidr\');"></a>';

        if (that.attr('configurable')) {
            html += '<a class="admin-icons config" onclick=""></a>';
        }

        if (that.attr('movable')) {
            html += '<a class="admin-icons move"></a>';
        }

        if (that.attr('removable')) {
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
    });

    i++;
}

function getParentId(el) {
    var parent = el.parent();

    if (parent.length > 0
        && $(parent).prop('tagName').toLowerCase() !== 'html'
        && $(parent).prop('tagName').toLowerCase() !== 'body'
        && $(el).prop('tagName').toLowerCase() !== 'body')
    {
        var id = $(parent).attr('id');
        if (id === undefined || id === 0) {
            return getParentId($(parent));
        } else {
            return id;
        }
    } else {
        return false;
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

/*! Sidr - v1.2.1 - 2013-11-06
 * https://github.com/artberri/sidr
 * Copyright (c) 2013 Alberto Varela; Licensed MIT */
(function(e){var t=!1,i=!1,n={isUrl:function(e){var t=RegExp("^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$","i");return t.test(e)?!0:!1},loadContent:function(e,t){e.html(t)},addPrefix:function(e){var t=e.attr("id"),i=e.attr("class");"string"==typeof t&&""!==t&&e.attr("id",t.replace(/([A-Za-z0-9_.\-]+)/g,"sidr-id-$1")),"string"==typeof i&&""!==i&&"sidr-inner"!==i&&e.attr("class",i.replace(/([A-Za-z0-9_.\-]+)/g,"sidr-class-$1")),e.removeAttr("style")},execute:function(n,s,a){"function"==typeof s?(a=s,s="sidr"):s||(s="sidr");var r,d,l,c=e("#"+s),u=e(c.data("body")),f=e("html"),p=c.outerWidth(!0),g=c.data("speed"),h=c.data("side"),m=c.data("displace"),v=c.data("onOpen"),y=c.data("onClose"),x="sidr"===s?"sidr-open":"sidr-open "+s+"-open";if("open"===n||"toggle"===n&&!c.is(":visible")){if(c.is(":visible")||t)return;if(i!==!1)return o.close(i,function(){o.open(s)}),void 0;t=!0,"left"===h?(r={left:p+"px"},d={left:"0px"}):(r={right:p+"px"},d={right:"0px"}),u.is("body")&&(l=f.scrollTop(),f.css("overflow-x","hidden").scrollTop(l)),m?u.addClass("sidr-animating").css({width:u.width(),position:"absolute"}).animate(r,g,function(){e(this).addClass(x)}):setTimeout(function(){e(this).addClass(x)},g),c.css("display","block").animate(d,g,function(){t=!1,i=s,"function"==typeof a&&a(s),u.removeClass("sidr-animating")}),v()}else{if(!c.is(":visible")||t)return;t=!0,"left"===h?(r={left:0},d={left:"-"+p+"px"}):(r={right:0},d={right:"-"+p+"px"}),u.is("body")&&(l=f.scrollTop(),f.removeAttr("style").scrollTop(l)),u.addClass("sidr-animating").animate(r,g).removeClass(x),c.animate(d,g,function(){c.removeAttr("style").hide(),u.removeAttr("style"),e("html").removeAttr("style"),t=!1,i=!1,"function"==typeof a&&a(s),u.removeClass("sidr-animating")}),y()}}},o={open:function(e,t){n.execute("open",e,t)},close:function(e,t){n.execute("close",e,t)},toggle:function(e,t){n.execute("toggle",e,t)},toogle:function(e,t){n.execute("toggle",e,t)}};e.sidr=function(t){return o[t]?o[t].apply(this,Array.prototype.slice.call(arguments,1)):"function"!=typeof t&&"string"!=typeof t&&t?(e.error("Method "+t+" does not exist on jQuery.sidr"),void 0):o.toggle.apply(this,arguments)},e.fn.sidr=function(t){var i=e.extend({name:"sidr",speed:200,side:"left",source:null,renaming:!0,body:"body",displace:!0,onOpen:function(){},onClose:function(){}},t),s=i.name,a=e("#"+s);if(0===a.length&&(a=e("<div />").attr("id",s).appendTo(e("body"))),a.addClass("sidr").addClass(i.side).data({speed:i.speed,side:i.side,body:i.body,displace:i.displace,onOpen:i.onOpen,onClose:i.onClose}),"function"==typeof i.source){var r=i.source(s);n.loadContent(a,r)}else if("string"==typeof i.source&&n.isUrl(i.source))e.get(i.source,function(e){n.loadContent(a,e)});else if("string"==typeof i.source){var d="",l=i.source.split(",");if(e.each(l,function(t,i){d+='<div class="sidr-inner">'+e(i).html()+"</div>"}),i.renaming){var c=e("<div />").html(d);c.find("*").each(function(t,i){var o=e(i);n.addPrefix(o)}),d=c.html()}n.loadContent(a,d)}else null!==i.source&&e.error("Invalid Sidr Source");return this.each(function(){var t=e(this),i=t.data("sidr");i||(t.data("sidr",s),"ontouchstart"in document.documentElement?(t.bind("touchstart",function(e){e.originalEvent.touches[0],this.touched=e.timeStamp}),t.bind("touchend",function(e){var t=Math.abs(e.timeStamp-this.touched);200>t&&(e.preventDefault(),o.toggle(s))})):t.click(function(e){e.preventDefault(),o.toggle(s)}))})}})(jQuery);