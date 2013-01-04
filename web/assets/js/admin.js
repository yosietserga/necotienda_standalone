$(function() {
    var elements = {
        'body': {
            selector:   'body'
        },
    	'header': {
            childrens:  ['#logo','#search','#links','#geolocate'],
            selector:   '#header',
            parents:    ['body']
        },
    	'nav': {
            childrens:  ['#nav > ul','#nav > li','#nav > a','#nav > ul > ul','#nav > ul > ul li','#nav > ul > ul a'],
            selector:   '#nav',
            parents:    ['body'],
        },
    	'maincontent': {
            childrens:  ['#content','#column_left','#column_right'],
            selector:   '#maincontent',
            parents:    ['body']
        },
        /*
    	'footer': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'content': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'column_left': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'column_right': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'form': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
        'box': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'grid_view': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'list_view': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'links': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
    	'search': {
            childrens:  ['.header','.content'],
            selector:   '.box',
            parents:    ['.header','.content'],
        },
        */
    };
    
    addAdminControls(elements);
    
    $('li.box').each(function() {
        if (!$(this).attr('id')) {
            var parent = $(this).parent().parent();
            $(this).attr('id','widget-box-'+ $(parent).attr('id') +'-'+ $(this).index());
        }
        var html = "";
        html += '<div class="clear"></div>';
        html += '<div class="actions">';
        /* html += '<a class="admin-icons config" onclick=""></a>'; */
        html += '<a class="admin-icons style" onclick="drawPanels(\'#' + $(this).attr('id') +'\');"></a>';
        html += '<a class="admin-icons move" onclick=""></a>';
        /* html += '<a class="admin-icons delete" onclick=""></a>'; */
        html += '</div>';
        html += '<div class="clear"></div>';
        
        $(this).append(html);
    });
    
	$('.aside').sortable({
		forceHelperSize: true,
		forcePlaceholderSize: true,
        connectWith: '.aside',
        handle: '.move',
		opacity: 0.8,
		placeholder: 'placeholder',
		update: function(){
			/* update widget position and config */
		}
	});
    
    $('.aside').disableSelection();
    
    $('.panelWrapper').accordion({
        collapsible: true
    });
    
    /*
    $(".panel-lateral").mouseenter(function(){
        clearTimeout($(this).data('timeoutId'));
    }).mouseleave(function(){
        var e = this;
        var timeoutId = setTimeout(function(){
            slidePanel(e.id);
        }, 900);
        $(this).data('timeoutId', timeoutId); 
    });
    */
    
    $("#borderRadiusSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadius").val(ui.value);
            $("#borderRadiusTopLeft").val(ui.value);
            $("#borderRadiusTopRight").val(ui.value);
            $("#borderRadiusBottomLeft").val(ui.value);
            $("#borderRadiusBottomRight").val(ui.value);
                
            $("#borderRadiusTopLeftSlider").slider('option', 'value', parseInt(ui.value));
            $("#borderRadiusTopRightSlider").slider('option', 'value', parseInt(ui.value));
            $("#borderRadiusBottomLeftSlider").slider('option', 'value', parseInt(ui.value));
            $("#borderRadiusBottomRightSlider").slider('option', 'value', parseInt(ui.value));
                
            setStyle();
        }
	});
    
    $("#borderRadiusSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadius").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderRadiusTopLeftSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadiusTopLeft").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderRadiusTopRightSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadiusTopRight").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderRadiusBottomLeftSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadiusBottomLeft").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderRadiusBottomRightSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRadiusBottomRight").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderWidthSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderWidth").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderTopWidthSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderTopWidth").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderRightWidthSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderRightWidth").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderBottomWidthSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderBottomWidth").val(ui.value);
            setStyle();
        }
	});
    
    $("#borderLeftWidthSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#borderLeftWidth").val(ui.value);
            setStyle();
        }
	});
    
    $("#boxShadowXSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#boxShadowX").val(ui.value);
            setStyle();
        }
	});
    
    $("#boxShadowYSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#boxShadowY").val(ui.value);
            setStyle();
        }
	});
    
    $("#boxShadowBlurSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#boxShadowBlur").val(ui.value);
            setStyle();
        }
	});
    
    $("#boxShadowSpreadSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#boxShadowSpread").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingTitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#titleLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingTitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#titleWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightTitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#titleLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingSubsubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingSubsubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightSubsubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingSubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingSubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightSubtitleSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#subtitleLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingPSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#pLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingPSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#pWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightPSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#pLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingBSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#bLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingBSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#bWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightBSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#bLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $("#letterSpacingASlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#aLetterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingASlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#aWordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightASlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#aLineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $.cookie.json = true;
    if ($.cookie('currentBlock')) {
        drawPanels($.cookie('currentBlock'));
    } else if ($('#selector').val().length > 0){
        drawPanels($('#selector').val());
    } else {
        drawPanels('html,body');
    }
    
});

function addAdminControls(elements,areChildrens) {
    if (typeof areChildrens == 'undefined') {
        areChildrens = false;
    }
    $.each(elements, function(i,el) {
        if (!$(el.selector) && !areChildrens) {
            console.log('No existe el elemento'+ el.selector);
            return true;
        } else if (areChildrens){
            var that = $(el);
        
            if (!that.attr('id') || that.attr('id').length == 0) {
                that.attr('id','widget-'+ Math.floor((Math.random()*10000000)+1) +'-'+ that.index());
            }
            
            var html = "";
            html += '<div class="clear"></div>';
            html += '<div class="actions actions'+ i +'">';
            
            html += '<a class="admin-icons style" onclick="drawPanels(\'#' + that.attr('id') +'\');"></a>';
            
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
            html += '<div class="clear"></div>';
        
            that.addClass('administrable').prepend(html);
            console.log(that);
            
        } else {
            var that = $(el.selector);
        
            if (!that.attr('id') || that.attr('id').length == 0) {
                that.attr('id','widget-'+ Math.floor((Math.random()*10000000)+1) +'-'+ that.index());
            }
            
            var html = "";
            html += '<div class="clear"></div>';
            html += '<div class="actions actions'+ i +'">';
            
            html += '<a class="admin-icons style" onclick="drawPanels(\'#' + that.attr('id') +'\');"></a>';
            
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
            html += '<div class="clear"></div>';
        
            that.addClass('administrable').prepend(html);
            console.log(that);
            
            if (typeof el.childrens != 'undefined') {
                addAdminControls(el.childrens,true);
            }
        }
    });
}

function drawPanels(el) {
    if (typeof el == 'undefined') {
        return false;
    } else {
        $('#selector').val(el);
        
        var cookieName = "";
        cookieName = $('#selector').val().replace(/\s/g, '');
        cookieName = $('#selector').val().replace(/[,#\.]/g, '');
        $.cookie('currentBlock',cookieName);
        
        $('#el').text(el);
        drawStylePanel(el);
    }
}

function drawStylePanel() {
    var style = {};
    var cookieName = "";
    
    cookieName = $('#selector').val().replace(/\s/g, '');
    cookieName = $('#selector').val().replace(/[,#\.]/g, '');
    
    style = $.cookie(cookieName);
    
    if (!style) {
        $('#bgColor').val('');
        $('#bgImage').val('');
        $('#bgRepeat').val('');
        $('#bgPositionX').val('');
        $('#bgPositionY').val('');
        $('#bgAttachment').val('');
        
        $('#borderColor').val('');
        $('#borderStyle').val('');
        $('#borderWidth').val('');
        
        $('#borderTopColor').val('');
        $('#borderTopStyle').val('');
        $('#borderTopWidth').val('');
        
        $('#borderRightColor').val('');
        $('#borderRightStyle').val('');
        $('#borderRightWidth').val('');
        
        $('#borderBottomColor').val('');
        $('#borderBottomStyle').val('');
        $('#borderBottomWidth').val('');
        
        $('#borderLeftColor').val('');
        $('#borderLeftStyle').val('');
        $('#borderLeftWidth').val('');
        
        $('#borderRadius').val('');
        $('#borderRadiusTopLeft').val('');
        $('#borderRadiusTopRight').val('');
        $('#borderRadiusBottomLeft').val('');
        $('#borderRadiusBottomRight').val('');
        
        $('#boxColor').val('');
        $('#boxShadowInset').removeAttr('checked');
        $('#boxShadowX').val(0);
        $('#boxShadowY').val(0);
        $('#boxShadowBlur').val(0);
        $('#boxShadowSpread').val(0);
        
        $('#titleColor').val('');
        $('#titleFamily').val('');
        $('#titleWeight').removeAttr('checked');
        $('#titleStyle').removeAttr('checked');
        $('#titleSize').val('');
        $('#titleAlign').val('');
        $('#titleDecoration').val('');
        $('#titleLetterSpacing').val('');
        $('#titleWordSpacing').val('');
        $('#titleLineHeight').val('');
        
        $('#subtitleColor').val('');
        $('#subtitleFamily').val('');
        $('#subtitleWeight').removeAttr('checked');
        $('#subtitleStyle').removeAttr('checked');
        $('#subtitleSize').val('');
        $('#subtitleAlign').val('');
        $('#subtitleDecoration').val('');
        $('#subtitleLetterSpacing').val('');
        $('#subtitleWordSpacing').val('');
        $('#subtitleLineHeight').val('');
        
        $('#pColor').val('');
        $('#pFamily').val('');
        $('#pWeight').removeAttr('checked');
        $('#pStyle').removeAttr('checked');
        $('#pSize').val('');
        $('#pAlign').val('');
        $('#pDecoration').val('');
        $('#pLetterSpacing').val('');
        $('#pWordSpacing').val('');
        $('#pLineHeight').val('');
        
        $('#bColor').val('');
        $('#bFamily').val('');
        $('#bWeight').removeAttr('checked');
        $('#bStyle').removeAttr('checked');
        $('#bSize').val('');
        $('#bAlign').val('');
        $('#bDecoration').val('');
        $('#bLetterSpacing').val('');
        $('#bWordSpacing').val('');
        $('#bLineHeight').val('');
        
        $('#aColor').val('');
        $('#aFamily').val('');
        $('#aWeight').removeAttr('checked');
        $('#aStyle').removeAttr('checked');
        $('#aSize').val('');
        $('#aAlign').val('');
        $('#aDecoration').val('');
        $('#aLetterSpacing').val('');
        $('#aWordSpacing').val('');
        $('#aLineHeight').val('');
    } else {
        if (typeof style.background.color != 'undefined') { $('#bgColor').val(style.background.color); } else { $('#bgColor').val(''); }
        if (typeof style.background.image != 'undefined') { $('#bgImage').val(style.background.image); } else { $('#bgImage').val(''); }
        if (typeof style.background.repeat != 'undefined') { $('#bgRepeat').val(style.background.repeat); } else { $('#bgRepeat').val(''); }
        if (typeof style.background.positionX != 'undefined') { $('#bgPositionX').val(style.background.positionX); } else { $('#bgPositionX').val(''); }
        if (typeof style.background.positionY != 'undefined') { $('#bgPositionY').val(style.background.positionY); } else { $('#bgPositionY').val(''); }
        if (typeof style.background.attachment != 'undefined') { $('#bgAttachment').val(style.background.attachment); } else { $('#bgAttachment').val(''); }
        if (typeof style.background.css != 'undefined') { $('#bgCss').val(style.background.css); } else { $('#bgCss').val(''); }
        
        if (typeof style.border.color != 'undefined') { $('#borderColor').val(style.border.color); } else { $('#borderColor').val(''); }
        if (typeof style.border.style != 'undefined') { $('#borderStyle').val(style.border.style); } else { $('#borderStyle').val(''); }
        if (typeof style.border.width != 'undefined') { $('#borderWidth').val(style.border.width); } else { $('#borderWidth').val(''); }
        
        if (typeof style.border.topcolor != 'undefined') { $('#borderTopColor').val(style.border.topcolor); } else { $('#borderTopColor').val(''); }
        if (typeof style.border.topstyle != 'undefined') { $('#borderTopStyle').val(style.border.topstyle); } else { $('#borderTopStyle').val(''); }
        if (typeof style.border.topwidth != 'undefined') { $('#borderTopWidth').val(style.border.topwidth); } else { $('#borderTopWidth').val(''); }
        
        if (typeof style.border.rightcolor != 'undefined') { $('#borderRightColor').val(style.border.rightcolor); } else { $('#borderRightColor').val(''); }
        if (typeof style.border.rightstyle != 'undefined') { $('#borderRightStyle').val(style.border.rightstyle); } else { $('#borderRightStyle').val(''); }
        if (typeof style.border.rightwidth != 'undefined') { $('#borderRightWidth').val(style.border.rightwidth); } else { $('#borderRightWidth').val(''); }
        
        if (typeof style.border.bottomcolor != 'undefined') { $('#borderBottomColor').val(style.border.bottomcolor); } else { $('#borderBottomColor').val(''); }
        if (typeof style.border.bottomstyle != 'undefined') { $('#borderBottomStyle').val(style.border.bottomstyle); } else { $('#borderBottomStyle').val(''); }
        if (typeof style.border.bottomwidth != 'undefined') { $('#borderBottomWidth').val(style.border.bottomwidth); } else { $('#borderBottomWidth').val(''); }
        
        if (typeof style.border.leftcolor != 'undefined') { $('#borderLeftColor').val(style.border.leftcolor); } else { $('#borderLeftColor').val(''); }
        if (typeof style.border.leftstyle != 'undefined') { $('#borderLeftStyle').val(style.border.leftstyle); } else { $('#borderLeftStyle').val(''); }
        if (typeof style.border.leftwidth != 'undefined') { $('#borderLeftWidth').val(style.border.leftwidth); } else { $('#borderLeftWidth').val(''); }
        
        if (typeof style.borderradius.all != 'undefined') { $('#borderRadius').val(style.borderradius.all); } else { $('#borderRadius').val(''); }
        if (typeof style.borderradius.topleft != 'undefined') { $('#borderRadiusTopLeft').val(style.borderradius.topleft); } else { $('#borderRadiusTopLeft').val(''); }
        if (typeof style.borderradius.topright != 'undefined') { $('#borderRadiusTopRight').val(style.borderradius.topright); } else { $('#borderRadiusTopRight').val(''); }
        if (typeof style.borderradius.bottomleft != 'undefined') { $('#borderRadiusBottomLeft').val(style.borderradius.bottomleft); } else { $('#borderRadiusBottomLeft').val(''); }
        if (typeof style.borderradius.bottomright != 'undefined') { $('#borderRadiusBottomRight').val(style.borderradius.bottomright); } else { $('#borderRadiusBottomRight').val(''); }
        
        if (typeof style.boxshadow.color != 'undefined') { $('#boxColor').val(style.boxshadow.color); } else { $('#boxColor').val(''); }
        if (typeof style.boxshadow.inset != 'undefined') { $('#boxShadowInset').val(style.boxshadow.inset); } else { $('#boxShadowInset').val(''); }
        if (typeof style.boxshadow.x != 'undefined') { $('#boxShadowX').val(style.boxshadow.x); } else { $('#boxShadowX').val(''); }
        if (typeof style.boxshadow.y != 'undefined') { $('#boxShadowY').val(style.boxshadow.y); } else { $('#boxShadowY').val(''); }
        if (typeof style.boxshadow.blur != 'undefined') { $('#boxShadowBlur').val(style.boxshadow.blur); } else { $('#boxShadowBlur').val(''); }
        if (typeof style.boxshadow.spread != 'undefined') { $('#boxShadowSpread').val(style.boxshadow.spread); } else { $('#boxShadowSpread').val(''); }
        
        if (typeof style.title.color != 'undefined') { $('#titleColor').val(style.title.color); } else { $('#titleColor').val(''); }
        if (typeof style.title.family != 'undefined') { $('#titleFamily').val(style.title.family); } else { $('#titleFamily').val(''); }
        if (typeof style.title.weight == 'undefined') { $('#titleWeight').removeAttr('checked'); } else { $('#titleWeight').attr('checked','checked'); }
        if (typeof style.title.style == 'undefined') { $('#titleStyle').removeAttr('checked'); } else { $('#titleStyle').attr('checked','checked'); }
        if (typeof style.title.size != 'undefined') { $('#titleSize').val(style.title.size); } else { $('#titleSize').val(''); }
        if (typeof style.title.align != 'undefined') { $('#titleAlign').val(style.title.align); } else { $('#titleAlign').val(''); }
        if (typeof style.title.decoration != 'undefined') { $('#titleDecoration').val(style.title.decoration); } else { $('#titleDecoration').val(''); }
        if (typeof style.title.letterspacing != 'undefined') { $('#titleLetterSpacing').val(style.title.letterspacing); } else { $('#titleLetterSpacing').val(''); }
        if (typeof style.title.wordspacing != 'undefined') { $('#titleWordSpacing').val(style.title.wordspacing); } else { $('#titleWordSpacing').val(''); }
        if (typeof style.title.lineheight != 'undefined') { $('#titleLineHeight').val(style.title.lineheight); } else { $('#titleLineHeight').val(''); }
        
        if (typeof style.subtitle.color != 'undefined') { $('#subtitleColor').val(style.subtitle.color); } else { $('#subtitleColor').val(''); }
        if (typeof style.subtitle.family != 'undefined') { $('#subtitleFamily').val(style.subtitle.family); } else { $('#subtitleFamily').val(''); }
        if (typeof style.subtitle.weight == 'undefined') { $('#subtitleWeight').removeAttr('checked'); } else { $('#subtitleWeight').attr('checked','checked'); }
        if (typeof style.subtitle.style == 'undefined') { $('#subtitleStyle').removeAttr('checked'); } else { $('#subtitleStyle').attr('checked','checked'); }
        if (typeof style.subtitle.size != 'undefined') { $('#subtitleSize').val(style.subtitle.size); } else { $('#subtitleSize').val(''); }
        if (typeof style.subtitle.align != 'undefined') { $('#subtitleAlign').val(style.subtitle.align); } else { $('#subtitleAlign').val(''); }
        if (typeof style.subtitle.decoration != 'undefined') { $('#subtitleDecoration').val(style.subtitle.decoration); } else { $('#subtitleDecoration').val(''); }
        if (typeof style.subtitle.letterspacing != 'undefined') { $('#subtitleLetterSpacing').val(style.subtitle.letterspacing); } else { $('#subtitleLetterSpacing').val(''); }
        if (typeof style.subtitle.wordspacing != 'undefined') { $('#subtitleWordSpacing').val(style.subtitle.wordspacing); } else { $('#subtitleWordSpacing').val(''); }
        if (typeof style.subtitle.lineheight != 'undefined') { $('#subtitleLineHeight').val(style.subtitle.lineheight); } else { $('#subtitleLineHeight').val(''); }
        
        if (typeof style.p.color != 'undefined') { $('#pColor').val(style.p.color); } else { $('#pColor').val(''); }
        if (typeof style.p.family != 'undefined') { $('#pFamily').val(style.p.family); } else { $('#pFamily').val(''); }
        if (typeof style.p.weight == 'undefined') { $('#pWeight').removeAttr('checked'); } else { $('#pWeight').attr('checked','checked'); }
        if (typeof style.p.style == 'undefined') { $('#pStyle').removeAttr('checked'); } else { $('#pStyle').attr('checked','checked'); }
        if (typeof style.p.size != 'undefined') { $('#pSize').val(style.p.size); } else { $('#pSize').val(''); }
        if (typeof style.p.align != 'undefined') { $('#pAlign').val(style.p.align); } else { $('#pAlign').val(''); }
        if (typeof style.p.decoration != 'undefined') { $('#pDecoration').val(style.p.decoration); } else { $('#pDecoration').val(''); }
        if (typeof style.p.letterspacing != 'undefined') { $('#pLetterSpacing').val(style.p.letterspacing); } else { $('#pLetterSpacing').val(''); }
        if (typeof style.p.wordspacing != 'undefined') { $('#pWordSpacing').val(style.p.wordspacing); } else { $('#pWordSpacing').val(''); }
        if (typeof style.p.lineheight != 'undefined') { $('#pLineHeight').val(style.p.lineheight); } else { $('#pLineHeight').val(''); }
        
        if (typeof style.b.color != 'undefined') { $('#bColor').val(style.b.color); } else { $('#bColor').val(''); }
        if (typeof style.b.family != 'undefined') { $('#bFamily').val(style.b.family); } else { $('#bFamily').val(''); }
        if (typeof style.b.weight == 'undefined') { $('#bWeight').removeAttr('checked'); } else { $('#bWeight').attr('checked','checked'); }
        if (typeof style.b.style == 'undefined') { $('#bStyle').removeAttr('checked'); } else { $('#bStyle').attr('checked','checked'); }
        if (typeof style.b.size != 'undefined') { $('#bSize').val(style.b.size); } else { $('#bSize').val(''); }
        if (typeof style.b.align != 'undefined') { $('#bAlign').val(style.b.align); } else { $('#bAlign').val(''); }
        if (typeof style.b.decoration != 'undefined') { $('#bDecoration').val(style.b.decoration); } else { $('#bDecoration').val(''); }
        if (typeof style.b.letterspacing != 'undefined') { $('#bLetterSpacing').val(style.b.letterspacing); } else { $('#bLetterSpacing').val(''); }
        if (typeof style.b.wordspacing != 'undefined') { $('#bWordSpacing').val(style.b.wordspacing); } else { $('#bWordSpacing').val(''); }
        if (typeof style.b.lineheight != 'undefined') { $('#bLineHeight').val(style.b.lineheight); } else { $('#bLineHeight').val(''); }
        
        if (typeof style.a.color != 'undefined') { $('#aColor').val(style.a.color); } else { $('#aColor').val(''); }
        if (typeof style.a.family != 'undefined') { $('#aFamily').val(style.a.family); } else { $('#aFamily').val(''); }
        if (typeof style.a.weight == 'undefined') { $('#aWeight').removeAttr('checked'); } else { $('#aWeight').attr('checked','checked'); }
        if (typeof style.a.style == 'undefined') { $('#aStyle').removeAttr('checked'); } else { $('#aStyle').attr('checked','checked'); }
        if (typeof style.a.size != 'undefined') { $('#aSize').val(style.a.size); } else { $('#aSize').val(''); }
        if (typeof style.a.align != 'undefined') { $('#aAlign').val(style.a.align); } else { $('#aAlign').val(''); }
        if (typeof style.a.decoration != 'undefined') { $('#aDecoration').val(style.a.decoration); } else { $('#aDecoration').val(''); }
        if (typeof style.a.letterspacing != 'undefined') { $('#aLetterSpacing').val(style.a.letterspacing); } else { $('#aLetterSpacing').val(''); }
        if (typeof style.a.wordspacing != 'undefined') { $('#aWordSpacing').val(style.a.wordspacing); } else { $('#aWordSpacing').val(''); }
        if (typeof style.a.lineheight != 'undefined') { $('#aLineHeight').val(style.a.lineheight); } else { $('#aLineHeight').val(''); }
        setStyle();
    }
    
    $( "#borderRadius" ).on('change', function(e) {
        $("#borderRadiusSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderRadiusTopLeft" ).on('change', function(e) {
        $("#borderRadiusTopLeftSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderRadiusTopRight" ).on('change', function(e) {
        $("#borderRadiusTopRightSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderRadiusBottomLeft" ).on('change', function(e) {
        $("#borderRadiusBottomLeftSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderRadiusBottomRight" ).on('change', function(e) {
        $("#borderRadiusBottomRightSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderWidth" ).on('change', function(e) {
        $("#borderWidthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderTopWidth" ).on('change', function(e) {
        $("#borderTopWidthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderRightWidth" ).on('change', function(e) {
        $("#borderRightWidthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderBottomWidth" ).on('change', function(e) {
        $("#borderBottomWidthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#borderLeftWidth" ).on('change', function(e) {
        $("#borderLeftWidthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#boxShadowX" ).on('change', function(e) {
        $("#boxShadowXSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#boxShadowY" ).on('change', function(e) {
        $("#boxShadowYSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#boxShadowBlur" ).on('change', function(e) {
        $("#boxShadowBlurSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#boxShadowSpread" ).on('change', function(e) {
        $("#boxShadowSpreadSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#titleLetterSpacing" ).on('change', function(e) {
        $("#letterSpacingTitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#titleWordSpacing" ).on('change', function(e) {
        $("#wordSpacingTitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#titleLineHeight" ).on('change', function(e) {
        $("#lineHeightTitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#subtitleLetterSpacing" ).on('change', function(e) {
        $("#letterSpacingSubtitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#subtitleWordSpacing" ).on('change', function(e) {
        $("#wordSpacingSubtitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#subtitleLineHeight" ).on('change', function(e) {
        $("#lineHeightSubtitleSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#pLetterSpacing" ).on('change', function(e) {
        $("#letterSpacingPSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#pWordSpacing" ).on('change', function(e) {
        $("#wordSpacingPSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#pLineHeight" ).on('change', function(e) {
        $("#lineHeightPSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#bLetterSpacing" ).on('change', function(e) {
        $("#letterSpacingBSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#bWordSpacing" ).on('change', function(e) {
        $("#wordSpacingBSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#bLineHeight" ).on('change', function(e) {
        $("#lineHeightBSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#aLetterSpacing" ).on('change', function(e) {
        $("#letterSpacingASlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#aWordSpacing" ).on('change', function(e) {
        $("#wordSpacingASlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#aLineHeight" ).on('change', function(e) {
        $("#lineHeightASlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $('#bg-colorpicker').ntColorPicker({
        type: 'rgba',
        change:function(color){
            if (color.length > 0) {
                $('#bgColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#title-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#titleColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#subtitle-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#subtitleColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#p-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#pColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#b-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#bColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#a-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#aColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#border-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#borderColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#border_top_colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#borderTopColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#border-right-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#borderRightColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#border-bottom-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#borderBottomColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#border-left-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#borderLeftColor').val(color);
                setStyle();
            }
        }
    });
    
    $('#box-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#boxColor').val(color);
                setStyle();
            }
        }
    });
    
    $('.style-panel').on('change',function(e) { 
        setStyle(); 
    });
}

/**
 * Establece los estilos del documento o del elemento seleccionado. Utiliza un campo oculto para saber cual elemento esta seleccionado
 *
 * @return void.
 */
function setStyle() {
    var that = $($('#selector').val()).get(0);
    var cookieName = "";
    var style = {};
    
    style.background = {};
    style.border = {};
    style.boxshadow = {};
    style.borderradius = {};
    style.title = {};
    style.subtitle = {};
    style.p = {};
    style.b = {};
    style.a = {};
    style.li = {};
    
    cookieName = $('#selector').val().replace(/\s/g, '');
    cookieName = $('#selector').val().replace(/[,#\.]/g, '');
    
    style.background.color = $('#bgColor').val();
    $(that).css({'backgroundColor': $('#bgColor').val()});
    
    style.background.image = $('#bgImage').val();
    $(that).css('backgroundImage','url("'+ $('#bgImage').val() +'")');
        
    style.background.repeat = $('#bgRepeat').val();
    $(that).css('backgroundRepeat',$('#bgRepeat').val());
    
    style.background.positionX = $('#bgPositionX').val();
    style.background.positionY = $('#bgPositionY').val();
    $(that).css({'backgroundPosition': $('#bgPositionX').val() +'px '+ $('#bgPositionY').val() +'px'});
    
    if ($('#bgAttachment').is(':checked')) {
        style.background.attachment = $('#bgAttachment').val();
        $(that).css('backgroundAttachment','fixed');
    } else {
        style.background.attachment = null;
        $(that).css('backgroundAttachment','none');
    }
    
    if ($('#borderAdvanced').val() == 0) {
        style.border.color = $('#borderColor').val();
        $(that).css('borderColor',$('#borderColor').val());
        
        style.border.style = $('#borderStyle').val();
        $(that).css('borderStyle',$('#borderStyle').val());
        
        style.border.width = $('#borderWidth').val();
        $(that).css('borderWidth',$('#borderWidth').val() +'px');
    } else {
        style.border.topcolor = $('#borderTopColor').val();
        $(that).css('borderTopColor',$('#borderTopColor').val());
        
        style.border.topstyle = $('#borderTopStyle').val();
        $(that).css('borderTopStyle',$('#borderTopStyle').val());
        
        style.border.topwidth = $('#borderTopWidth').val();
        $(that).css('borderTopWidth',$('#borderTopWidth').val() +'px');
        
        style.border.rightcolor = $('#borderRightColor').val();
        $(that).css('borderRightColor',$('#borderRightColor').val());
        
        style.border.rightstyle = $('#borderRightStyle').val();
        $(that).css('borderRightStyle',$('#borderRightStyle').val());
        
        style.border.rightwidth = $('#borderRightWidth').val();
        $(that).css('borderRightWidth',$('#borderRightWidth').val() +'px');
        
        style.border.bottomcolor = $('#borderBottomColor').val();
        $(that).css({'borderBottomColor':$('#borderBottomColor').val()});
        
        style.border.bottomstyle = $('#borderBottomStyle').val();
        $(that).css({'borderBottomStyle':$('#borderBottomStyle').val()});
        
        style.border.bottomwidth = $('#borderBottomWidth').val();
        $(that).css({'borderBottomWidth':$('#borderBottomWidth').val() +'px'});
        
        style.border.leftcolor = $('#borderLeftColor').val();
        $(that).css('borderLeftColor',$('#borderLeftColor').val());
        
        style.border.leftstyle = $('#borderLeftStyle').val();
        $(that).css({'borderLeftStyle':$('#borderLeftStyle').val()});
        
        style.border.leftwidth = $('#borderLeftWidth').val();
        $(that).css({'borderLeftWidth':$('#borderLeftWidth').val() +'px'});
    }
    
    
    if ($('#borderRadiusAdvanced').val() == 0) {
        style.borderradius.color = $('#borderRadius').val();
        $(that).css('borderRadius',$('#borderRadius').val() +'px');
    } else {
        var cssBorderRadius = "";
        
        style.borderradius.topleft = $('#borderRadiusTopLeft').val();
        cssBorderRadius += parseInt($('#borderRadiusTopLeft').val()) +'px '; 
        
        style.borderradius.topright = $('#borderRadiusTopRight').val();
        cssBorderRadius += parseInt($('#borderRadiusTopRight').val()) +'px ';
        
        style.borderradius.bottomleft = $('#borderRadiusBottomLeft').val();
        cssBorderRadius += parseInt($('#borderRadiusBottomLeft').val()) +'px '; 
        
        style.borderradius.bottomleft = $('#borderRadiusBottomRight').val();
        cssBorderRadius += parseInt($('#borderRadiusBottomRight').val()) +'px'; 
        
        $(that).css({'borderRadius':cssBorderRadius});
    }
    
    var cssBoxShadow = "";
    if ($('#boxShadowInset').is(':checked')) { 
        style.boxshadow.inset = $('#boxShadowInset').val();
        cssBoxShadow += 'inset '; 
    }
    
    style.boxshadow.x = $('#boxShadowX').val();
    cssBoxShadow += parseInt($('#boxShadowX').val()) +'px ';
    
    style.boxshadow.y = $('#boxShadowY').val();
    cssBoxShadow += parseInt($('#boxShadowY').val()) +'px ';
        
    style.boxshadow.blur = $('#boxShadowBlur').val();
    cssBoxShadow += parseInt($('#boxShadowBlur').val()) +'px ';
        
    style.boxshadow.spread = $('#boxShadowSpread').val();
    cssBoxShadow += parseInt($('#boxShadowSpread').val()) +'px ';
        
    style.boxshadow.color = $('#boxColor').val();
    cssBoxShadow += $('#boxColor').val();
    
    $(that).css('boxShadow',cssBoxShadow);
    
    if ($(that).find('li')) {
        var cssLi = "";
        if ($('#liColor').val()) { 
            style.li.color = $('#liColor').val();
            cssLi += 'color:'+ $('#liColor').val() +';'; 
        }
        if ($('#liFamily option').is(':selected')) { 
            style.li.family = $('#liFamily').val();
            cssLi += 'font-family:'+ $('#liFamily').val() +';'; 
        }
        if ($('#liSize option').is(':selected')) { 
            style.li.size = $('#liSize').val();
            cssLi += 'font-size:'+ $('#liSize').val() +';';  
        }
        if ($('#liStyle').is(':checked')) { 
            style.li.style = $('#liStyle').val();
            cssLi += 'font-style:italic;';  
        }
        if ($('#liWeight').is(':checked')) { 
            style.li.weight = $('#liWeight').val();
            cssLi += 'font-weight:bold;'; 
        }
        if ($('#liDecoration').val()) { 
            style.li.decoration = $('#liDecoration').val();
            cssLi += 'text-decoration:'+ $('#liDecoration').val() +';';  
        }
        if ($('#liAlign').val()) { 
            style.li.align = $('#liAlign').val();
            cssLi += 'text-align:'+ $('#liAlign').val() +';';  
        }
        $(that).find('li').attr('style',cssLi);
    }
    
    if ($(that).find('h1')) {
        var cssTitle = "";
        if ($('#titleColor').val()) { 
            style.title.color = $('#titleColor').val();
            cssTitle += 'color:'+ $('#titleColor').val() +' !important;'; 
        }
        if ($('#titleFamily option').is(':selected')) { 
            style.title.family = $('#titleFamily').val();
            cssTitle += 'font-family:'+ $('#titleFamily').val() +' !important;'; 
        }
        if ($('#titleSize option').is(':selected')) { 
            style.title.size = $('#titleSize').val();
            cssTitle += 'font-size:'+ $('#titleSize').val() +' !important;'; 
        }
        if ($('#titleStyle').val()) { 
            style.title.style = $('#titleStyle').val();
            cssTitle += 'font-style:italic !important;'; 
        }
        if ($('#titleWeight').val()) { 
            style.title.weight = $('#titleWeight').val();
            cssTitle += 'font-weight:bold !important;'; 
        }
        if ($('#titleDecoration').val()) { 
            style.title.decoration = $('#titleDecoration').val();
            cssTitle += 'text-decoration:'+ $('#titleDecoration').val() +' !important;'; 
        }
        if ($('#titleAlign').val()) { 
            style.title.align = $('#titleAlign').val();
            cssTitle += 'text-align:'+ $('#titleAlign').val() +' !important;'; 
        }
        if ($('#titleTransform').val()) { 
            style.title.transform = $('#titleTransform').val();
            cssTitle += 'text-transform:'+ $('#titleTransform').val() +' !important;'; 
        }
        if ($('#titleLetterSpacing').val()) { 
            style.title.transform = $('#titleLetterSpacing').val();
            cssTitle += 'letter-spacing:'+ $('#titleLetterSpacing').val() +'px !important;'; 
        }
        if ($('#titleWordSpacing').val()) { 
            style.title.transform = $('#titleWordSpacing').val();
            cssTitle += 'word-spacing:'+ $('#titleWordSpacing').val() +'px !important;'; 
        }
        if ($('#titleLineHeight').val()) { 
            style.title.transform = $('#titleLineHeight').val();
            cssTitle += 'line-height:'+ $('#titleLineHeight').val() +'px !important;'; 
        }
        $(that).find('h1').attr('style',cssTitle);
    }
    
    if ($(that).find('h2, h3, h4, h5, h6')) {
        var cssSubtitle = "";
        if ($('#subtitleColor').val()) { 
            style.subtitle.color = $('#subtitleColor').val();
            cssSubtitle += 'color:'+ $('#subtitleColor').val() +' !important;'; 
        }
        if ($('#subtitleFamily option').is(':selected')) { 
            style.subtitle.family = $('#subtitleFamily').val();
            cssSubtitle += 'font-family:'+ $('#subtitleFamily').val() +' !important;'; 
        }
        if ($('#subtitleSize option').is(':selected')) { 
            style.subtitle.size = $('#subtitleSize').val();
            cssSubtitle += 'font-size:'+ $('#subtitleSize').val() +' !important;'; 
        }
        if ($('#subtitleStyle').val()) { 
            style.subtitle.style = $('#subtitleStyle').val();
            cssSubtitle += 'font-style:italic !important;'; 
        }
        if ($('#subtitleWeight').val()) { 
            style.subtitle.weight = $('#subtitleWeight').val();
            cssSubtitle += 'font-weight:bold !important;'; 
        }
        if ($('#subtitleDecoration').val()) { 
            style.subtitle.decoration = $('#subtitleDecoration').val();
            cssSubtitle += 'text-decoration:'+ $('#subtitleDecoration').val() +' !important;'; 
        }
        if ($('#subtitleAlign').val()) { 
            style.subtitle.asubtitlegn = $('#subtitleAlign').val();
            cssSubtitle += 'text-align:'+ $('#subtitleAlign').val(); 
        }
        if ($('#subtitleLetterSpacing').val()) { 
            style.subtitle.transform = $('#subtitleLetterSpacing').val();
            cssTitle += 'letter-spacing:'+ $('#subtitleLetterSpacing').val() +'px !important;'; 
        }
        if ($('#subtitleWordSpacing').val()) { 
            style.subtitle.transform = $('#subtitleWordSpacing').val();
            cssTitle += 'word-spacing:'+ $('#subtitleWordSpacing').val() +'px !important;'; 
        }
        if ($('#subtitleLineHeight').val()) { 
            style.subtitle.transform = $('#subtitleLineHeight').val();
            cssTitle += 'line-height:'+ $('#subtitleLineHeight').val() +'px !important;'; 
        }
        $(that).find('h2, h3:not(.panel-lateral), h4, h5, h6').attr('style',cssSubtitle);
    }
    
    if ($(that).find('p')) {
        var cssP = "";
        if ($('#pColor').val()) { 
            style.p.color = $('#pColor').val();
            cssP += 'color:'+ $('#pColor').val() +' !important;'; 
        }
        if ($('#pFamily option').is(':selected')) { 
            style.p.family = $('#pFamily').val();
            cssP += 'font-family:'+ $('#pFamily').val() +' !important;'; 
        }
        if ($('#pSize option').is(':selected')) { 
            style.p.size = $('#pSize').val();
            cssP += 'font-size:'+ $('#pSize').val() +' !important;'; 
        }
        if ($('#pStyle').val()) { 
            style.p.style = $('#pStyle').val();
            cssP += 'font-style:italic !important;'; 
        }
        if ($('#pWeight').val()) { 
            style.p.weight = $('#pWeight').val();
            cssP += 'font-weight:bold !important;'; 
        }
        if ($('#pDecoration').val()) { 
            style.p.decoration = $('#pDecoration').val();
            cssP += 'text-decoration:'+ $('#pDecoration').val() +' !important;'; 
        }
        if ($('#pAlign').val()) { 
            style.p.apgn = $('#pAlign').val();
            cssP += 'text-align:'+ $('#pAlign').val() +' !important;'; 
        }
        if ($('#pLetterSpacing').val()) { 
            style.p.transform = $('#pLetterSpacing').val();
            cssTitle += 'letter-spacing:'+ $('#pLetterSpacing').val() +'px !important;'; 
        }
        if ($('#pWordSpacing').val()) { 
            style.p.transform = $('#pWordSpacing').val();
            cssTitle += 'word-spacing:'+ $('#pWordSpacing').val() +'px !important;'; 
        }
        if ($('#pLineHeight').val()) { 
            style.p.transform = $('#pLineHeight').val();
            cssTitle += 'line-height:'+ $('#pLineHeight').val() +'px !important;'; 
        }
        $(that).find('p').attr('style',cssP);
    }
    
    if ($(that).find('b')) {
        var cssB = "";
        if ($('#bColor').val()) { 
            style.b.color = $('#bColor').val();
            cssB += 'color:'+ $('#bColor').val() +' !important;'; 
        }
        if ($('#bFamily option').is(':selected')) { 
            style.b.family = $('#bFamily').val();
            cssB += 'font-family:'+ $('#bFamily').val() +' !important;'; 
        }
        if ($('#bSize option').is(':selected')) { 
            style.b.size = $('#bSize').val();
            cssB += 'font-size:'+ $('#bSize').val() +' !important;'; 
        }
        if ($('#bStyle').val()) { 
            style.b.style = $('#bStyle').val();
            cssB += 'font-style:italic !important;'; 
        }
        if ($('#bWeight').val()) { 
            style.b.weight = $('#bWeight').val();
            cssB += 'font-weight:bold !important;'; 
        }
        if ($('#bDecoration').val()) { 
            style.b.decoration = $('#bDecoration').val();
            cssB += 'text-decoration:'+ $('#bDecoration').val() +' !important;'; 
        }
        if ($('#bAlign').val()) { 
            style.b.abgn = $('#bAlign').val();
            cssB += 'text-align:'+ $('#bAlign').val() +' !important;'; 
        }
        if ($('#bLetterSpacing').val()) { 
            style.b.transform = $('#bLetterSpacing').val();
            cssTitle += 'letter-spacing:'+ $('#bLetterSpacing').val() +'px !important;'; 
        }
        if ($('#bWordSpacing').val()) { 
            style.b.transform = $('#bWordSpacing').val();
            cssTitle += 'word-spacing:'+ $('#bWordSpacing').val() +'px !important;'; 
        }
        if ($('#bLineHeight').val()) { 
            style.b.transform = $('#bLineHeight').val();
            cssTitle += 'line-height:'+ $('#bLineHeight').val() +'px !important;'; 
        }
        $(that).find('b').attr('style',cssB);
    }
    
    if ($(that).find('a')) {
        var cssA = "";
        if ($('#aColor').val()) { 
            style.a.color = $('#aColor').val();
            cssA += 'color:'+ $('#aColor').val() +' !important;'; 
        }
        if ($('#aFamily option').is(':selected')) { 
            style.a.family = $('#aFamily').val();
            cssA += 'font-family:'+ $('#aFamily').val() +' !important;'; 
        }
        if ($('#aSize option').is(':selected')) { 
            style.a.size = $('#aSize').val();
            cssA += 'font-size:'+ $('#aSize').val() +' !important;'; 
        }
        if ($('#aStyle').val()) { 
            style.a.style = $('#aStyle').val();
            cssA += 'font-style:italic !important;'; 
        }
        if ($('#aWeight').val()) { 
            style.a.weight = $('#aWeight').val();
            cssA += 'font-weight:bold !important;'; 
        }
        if ($('#aDecoration').val()) { 
            style.a.decoration = $('#aDecoration').val();
            cssA += 'text-decoration:'+ $('#aDecoration').val() +' !important;'; 
        }
        if ($('#aAlign').val()) { 
            style.a.aagn = $('#aAlign').val();
            cssA += 'text-align:'+ $('#aAlign').val() +' !important;'; 
        }
        if ($('#aTransform').val()) { 
            style.a.aagn = $('#aTransform').val();
            cssA += 'text-transform:'+ $('#aTransform').val() +' !important;'; 
        }
        if ($('#aLetterSpacing').val()) { 
            style.a.transform = $('#aLetterSpacing').val();
            cssTitle += 'letter-spacing:'+ $('#aLetterSpacing').val() +'px !important;'; 
        }
        if ($('#aWordSpacing').val()) { 
            style.a.transform = $('#aWordSpacing').val();
            cssTitle += 'word-spacing:'+ $('#aWordSpacing').val() +'px !important;'; 
        }
        if ($('#aLineHeight').val()) { 
            style.a.transform = $('#aLineHeight').val();
            cssTitle += 'line-height:'+ $('#aLineHeight').val() +'px !important;'; 
        }
        $(that).find('a:not(.panel-lateral)').attr('style',cssA);
    }
    $.cookie(cookieName,style);
}

/**
 * Helper que establece el valor de la alineacion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setAlign(e,a,v,c,t) {
    $('#alignLeft'+ a).removeClass('align-leftOn');
    $('#alignCenter'+ a).removeClass('align-centerOn');
    $('#alignRight'+ a).removeClass('align-rightOn');
    $('#alignJustify'+ a).removeClass('align-justifyOn');
    $(e).toggleClass(c);
    $('#'+ t).val(v);
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setDecoration(e,a,v,c,t) {
    $('#lineThrough'+ a).removeClass('line-throughOn');
    $('#underline'+ a).removeClass('underlineOn');
    
    if ($('#'+ t).val() == v) {
        $('#'+ t).val('');
        $(e).removeClass(c);
    } else {
        $('#'+ t).val(v);
        $(e).addClass(c);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setWeight(e,v,c,t) {
    $(e).toggleClass(c);
    if ($('#'+ t).val() == v) {
        $('#'+ t).val('');
    } else {
        $('#'+ t).val(v);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setItalic(e,v,c,t) {
    $(e).toggleClass(c);
    if ($('#'+ t).val() == v) {
        $('#'+ t).val('');
    } else {
        $('#'+ t).val(v);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setTransform(e,a,v,c,t) {
    $('#upper'+ a).removeClass('uppercaseOn');
    $('#lower'+ a).removeClass('lowercaseOn');
    
    if ($('#'+ t).val() == v) {
        $('#'+ t).val('');
        $(e).removeClass(c);
    } else {
        $('#'+ t).val(v);
        $(e).addClass(c);
    }
    setStyle();
}

/**
 * Limpia los campos y los estilos de los titulos.
 *
 * @return void.
 */
function resetTitle() {
    $($('#selector').val()).find('h1').css({
        'color': 'none',
        'font': 'none',
        'fontSize': 'none',
        'fontWeight': 'none',
        'fontStyle': 'none',
        'fontFamily': 'none',
        'textDecoration': 'none',
        'textAlign': 'none',
        'letterSpacing': 'auto',
        'wordSpacing': 'auto',
        'lineHeight': 'auto'
    });
    $('#titleColor').val('');
    $('#titleFamily').val('');
    $('#titleWeight').val('');
    $('#titleStyle').val('');
    $('#titleSize').val('');
    $('#titleAlign').val('');
    $('#titleDecoration').val('');
    $('#titleLetterSpacing').val('');
    $('#titleWordSpacing').val('');
    $('#titleLineHeight').val('');
}

/**
 * Limpia los campos y los estilos de los subtitulos.
 *
 * @return void.
 */
function resetSubtitle() {
    $($('#selector').val()).find('h2,h3,h4,h5,h6').css({
        'color': 'none',
        'font': 'none',
        'fontSize': 'none',
        'fontWeight': 'none',
        'fontStyle': 'none',
        'fontFamily': 'none',
        'textDecoration': 'none',
        'textAlign': 'none',
        'letterSpacing': 'auto',
        'wordSpacing': 'auto',
        'lineHeight': 'auto'
    });
    $('#subtitleColor').val('');
    $('#subtitleFamily').val('');
    $('#subtitleWeight').val('');
    $('#subtitleStyle').val('');
    $('#subtitleSize').val('');
    $('#subtitleAlign').val('');
    $('#subtitleDecoration').val('');
    $('#subtitleLetterSpacing').val('');
    $('#subtitleWordSpacing').val('');
    $('#subtitleLineHeight').val('');
}

/**
 * Limpia los campos y los estilos de los parrafos.
 *
 * @return void.
 */
function resetP() {
    $($('#selector').val()).find('p').css({
        'color': 'none',
        'font': 'none',
        'fontSize': 'none',
        'fontWeight': 'none',
        'fontStyle': 'none',
        'fontFamily': 'none',
        'textDecoration': 'none',
        'textAlign': 'none',
        'letterSpacing': 'auto',
        'wordSpacing': 'auto',
        'lineHeight': 'auto'
    });
    $('#pColor').val('');
    $('#pFamily').val('');
    $('#pWeight').val('');
    $('#pStyle').val('');
    $('#pSize').val('');
    $('#pAlign').val('');
    $('#pDecoration').val('');
    $('#pLetterSpacing').val('');
    $('#pWordSpacing').val('');
    $('#pLineHeight').val('');
}

/**
 * Limpia los campos y los estilos de los enfasis.
 *
 * @return void.
 */
function resetB() {
    $($('#selector').val()).find('b').css({
        'color': 'none',
        'font': 'none',
        'fontSize': 'none',
        'fontWeight': 'none',
        'fontStyle': 'none',
        'fontFamily': 'none',
        'textDecoration': 'none',
        'textAlign': 'none',
        'letterSpacing': 'auto',
        'wordSpacing': 'auto',
        'lineHeight': 'auto'
    });
    $('#bColor').val('');
    $('#bFamily').val('');
    $('#bWeight').val('');
    $('#bStyle').val('');
    $('#bSize').val('');
    $('#bAlign').val('');
    $('#bDecoration').val('');
    $('#bLetterSpacing').val('');
    $('#bWordSpacing').val('');
    $('#bLineHeight').val('');
}

/**
 * Limpia los campos y los estilos de los enlaces.
 *
 * @return void.
 */
function resetA() {
    $($('#selector').val()).find('a').css({
        'color': 'none',
        'font': 'none',
        'fontSize': 'none',
        'fontWeight': 'none',
        'fontStyle': 'none',
        'fontFamily': 'none',
        'textDecoration': 'none',
        'textAlign': 'none',
        'letterSpacing': 'auto',
        'wordSpacing': 'auto',
        'lineHeight': 'auto'
    });
    $('#aColor').val('');
    $('#aFamily').val('');
    $('#aWeight').val('');
    $('#aStyle').val('');
    $('#aSize').val('');
    $('#aAlign').val('');
    $('#aDecoration').val('');
    $('#aLetterSpacing').val('');
    $('#aWordSpacing').val('');
    $('#aLineHeight').val('');
}

/**
 * Limpia los campos y los estilos del fondo.
 *
 * @return void.
 */
function resetBackground() {
    $($('#selector').val()).css({
        'background': 'none',
        'backgroundColor': 'none',
        'backgroundImage': 'none',
        'backgroundRepeat': 'none',
        'backgroundPosition': 'none',
        'backgroundAttachment': 'none'
    });
    $('#bgColor').val('');
    $('#bgImage').val('');
    $('#bgRepeat').val('');
    $('#bgPositionX').val('');
    $('#bgPositionY').val('');
    $('#bgAttachment').removeAttr('checked');
}

function cleanStyle() {
    resetTitle();
    resetSubtitle();
    resetP();
    resetB();
    resetA();
    /*
    resetBorder();
    resetBorderRadius();
    resetBoxShadow();
    resetMargins();
    */
}

function copyStyle() {
    if ($("#selector").val().length == 0) {
        alert("Debes seleccionar un elemento de la pagina para copiar");
        return false;
    }
    var cookieName = $.cookie('currentBlock');
    if (!$.cookie(cookieName)) {
        alert("No hay nada para copiar");
        return false;
    } else {
        $.cookie('clipboardStyle',$.cookie(cookieName));
    }
}

function pasteStyle() {
    var cookieName = $.cookie('currentBlock');
    if ($("#selector").val().length == 0 || !cookieName) {
        alert("Debes seleccionar un elemento de la pagina para pegar");
        return false;
    }
    if (!$.cookie('clipboardStyle')) {
        alert("No hay nada para pegar");
        return false;
    } else {
        $.cookie(cookieName,$.cookie('clipboardStyle'));
        drawPanels($("#selector").val());
        setStyle();
    }
}

function saveStyle(url) {
    var params = {
        'class':$("#selector").val(),
        'style':$.cookie($.cookie('currentBlock')),
        'properties':$('#formStyle').serialize()
    };
    /*
    $.post(url,params,function() {
        
    });
    */
}

function printStyle() {
    /** @todo funciones para imprimir el estilo convertir el objeto json a string con estructura ecmas */
}
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
        if (this.id != that.attr('id'))
        $(this).animate({
            'marginLeft':'0px',
        })
        .find('.label')
        .css({
            'display':'none'
        });
    });
    
    if (that.hasClass('on')) {
       that.animate({
            'marginLeft':'0px'
        })
        .removeClass('on');
        
        $('.panel-lateral').find('.label')
        .css({
            'display':'block'
        });
    } else {
        that.animate({
            'marginLeft':'400px'
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
