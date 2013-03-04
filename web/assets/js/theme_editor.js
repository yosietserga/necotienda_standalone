$(function() {
    var elements = {
        'body': {
            selector:   'body'
        },
    	'header': {
            childrens:  ['#header .nt-editable','#logo','#search'],
            selector:   '#header',
            parents:    ['body']
        },
    	'nav': {
            childrens:  ['#nav .nt-editable'],
            selector:   '#nav',
            parents:    ['body'],
        },
    	'column_left_box': {
            childrens:  ['.header','.content','#column_left .nt-editable'],
            selector:   '#column_left .box',
            parents:    ['maincontent'],
            canMove:    true
        },
    	'column_right_box': {
            childrens:  ['.header','.content','#column_right .nt-editable'],
            selector:   '#column_right .box',
            parents:    ['maincontent'],
            canMove:    true
        },
    	'maincontent': {
            childrens:  ['#content','#column_left','#column_right'],
            selector:   '#maincontent',
            parents:    ['body']
        }
    };
    
    addAdminControls(elements);
    
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
    
    var width = $(window).width();
    var height = $(window).height();
    var tooltip = $('<div id="tooltip" />').css({
        position: 'absolute',
        top: -25,
        left: -10
    }).hide();

    var ttip = tooltip.clone();
    $("#marginSlider").find(".ui-slider-handle").append(ttip);
    $("#marginSlider").slider({
        range: "min",
		min: -width,
		max: width,
		slide: function(event, ui) {
            $("#margin").val(ui.value);
            $("#marginTop").val(ui.value);
            $("#marginRight").val(ui.value);
            $("#marginBottom").val(ui.value);
            $("#marginLeft").val(ui.value);
                
            $("#marginTopSlider").slider('option', 'value', parseInt(ui.value));
            $("#marginRightSlider").slider('option', 'value', parseInt(ui.value));
            $("#marginBottomSlider").slider('option', 'value', parseInt(ui.value));
            $("#marginLeftSlider").slider('option', 'value', parseInt(ui.value));
            
            setStyle();
        }
	});
    
    
    $("#marginTopSlider").slider({
        range: "min",
		min: -height,
		max: height,
		slide: function(event, ui) {
            $("#marginTop").val(ui.value);
            setStyle();
        }
	});
    
    $("#marginRightSlider").slider({
        range: "min",
		min: -width,
		max: width,
		slide: function(event, ui) {
            $("#marginRight").val(ui.value);
            setStyle();
        }
	});
    
    $("#marginBottomSlider").slider({
        range: "min",
		min: -height,
		max: height,
		slide: function(event, ui) {
            $("#marginBottom").val(ui.value);
            setStyle();
        }
	});
    
    $("#marginLeftSlider").slider({
        range: "min",
		min: -width,
		max: width,
		slide: function(event, ui) {
            $("#marginLeft").val(ui.value);
            setStyle();
        }
	});
    
    $("#paddingSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#padding").val(ui.value);
            $("#paddingTop").val(ui.value);
            $("#paddingRight").val(ui.value);
            $("#paddingBottom").val(ui.value);
            $("#paddingLeft").val(ui.value);
                
            $("#paddingTopSlider").slider('option', 'value', parseInt(ui.value));
            $("#paddingRightSlider").slider('option', 'value', parseInt(ui.value));
            $("#paddingBottomSlider").slider('option', 'value', parseInt(ui.value));
            $("#paddingLeftSlider").slider('option', 'value', parseInt(ui.value));
                
            setStyle();
        }
	});
    $("#paddingTopSlider").slider({
        range: "min",
		min: 0,
		max: height,
		slide: function(event, ui) {
            $("#paddingTop").val(ui.value);
            setStyle();
        }
	});
    
    $("#paddingRightSlider").slider({
        range: "min",
		min: 0,
		max: width,
		slide: function(event, ui) {
            $("#paddingRight").val(ui.value);
            setStyle();
        }
	});
    
    $("#paddingBottomSlider").slider({
        range: "min",
		min: 0,
		max: height,
		slide: function(event, ui) {
            $("#paddingBottom").val(ui.value);
            setStyle();
        }
	});
    
    $("#paddingLeftSlider").slider({
        range: "min",
		min: 0,
		max: width,
		slide: function(event, ui) {
            $("#paddingLeft").val(ui.value);
            setStyle();
        }
	});
    
    $("#topSlider").slider({
        range: "min",
		min: -height,
		max: height,
		slide: function(event, ui) {
            $("#top").val(ui.value);
            setStyle();
        }
	});
    $("#leftSlider").slider({
        range: "min",
		min: -width,
		max: width,
		slide: function(event, ui) {
            $("#left").val(ui.value);
            setStyle();
        }
	});
    $("#widthSlider").slider({
        range: "min",
		min: 0,
		max: width,
		slide: function(event, ui) {
            $("#width").val(ui.value);
            setStyle();
        }
	});
    $("#heightSlider").slider({
        range: "min",
		min: 0,
		max: height,
		slide: function(event, ui) {
            $("#height").val(ui.value);
            setStyle();
        }
	});
    
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
    
    $("#letterSpacingSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#letterSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#wordSpacingSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#wordSpacing").val(ui.value);
            setStyle();
        }
	});
    $("#lineHeightSlider").slider({
        range: "min",
		min: 0,
		max: 250,
		slide: function(event, ui) {
            $("#lineHeight").val(ui.value);
            setStyle();
        }
	});
    
    $.cookie.json = true;
    if ($.cookie('currentBlock')) {
        drawStylePanels('#' + $.cookie('currentBlock'));
    } else if ($('#selector').val().length > 0){
        drawStylePanels($('#selector').val());
    } else {
        drawStylePanels('html,body');
    }
});

function drawStylePanels(el,mainEl) {
    if (typeof el == 'undefined') {
        return false;
    } else {
        if (typeof mainEl == 'undefined' || mainEl.length == 0) {
            mainEl = el;
        }
        $("#selectors").val('');
        $('#selector').val(el);
        $('#mainselector').val(mainEl);
        
        var cookieName = "";
        cookieName = $('#selector').val().replace(/\s/g, '');
        cookieName = $('#selector').val().replace(/[,#\.]/g, '');
        $.cookie('currentBlock',cookieName);
        
        $('#el').text(el);
        loadStyle();
        drawStylePanel(el);
    }
}

function loadStyle() {
    var elements = {};
    elements = $.cookie('elements');
    if (elements) {
        $.each(elements, function(el,style) {
            that = $('#'+ el);
            
            that.css({
                'backgroundColor':style.background.color,
                'backgroundImage':style.background.image,
                'backgroundRepeat':style.background.repeat,
                'backgroundPosition':style.background.positionX +'px'+ style.background.positionY +'px',
                'backgroundAttachment':style.background.attachment,
                
                'top':style.dimensions.top +'px',
                'left':style.dimensions.left +'px',
                'width':style.dimensions.width +'px',
                'height':style.dimensions.height +'px',
                
                'fontColor':style.font.color,
                'fontFamily':style.font.family,
                'fontWeight':style.font.weight,
                'fontStyle':style.font.style,
                'fontSize':style.font.size +'px',
                'textAlign':style.font.align,
                'textDecoration':style.font.decoration,
                'textTransform':style.font.transform,
                'letterSpacing':style.font.letterspacing +'px',
                'wordSpacing':style.font.wordspacing +'px',
                'lineHeight':style.font.lineheight +'px'
            });

            var cssBoxShadow = "";
            if (style.boxshadow.inset) { cssBoxShadow += 'inset '; }
            cssBoxShadow += parseInt(style.boxshadow.x) +'px ';
            cssBoxShadow += parseInt(style.boxshadow.y) +'px ';
            cssBoxShadow += parseInt(style.boxshadow.blur) +'px ';
            cssBoxShadow += parseInt(style.boxshadow.spread) +'px ';
            cssBoxShadow += style.boxshadow.color;
            $(that).css('boxShadow',cssBoxShadow);
                
                
            if ((typeof (style.border.topcolor) == 'undefined' || !style.border.topcolor)
             && (typeof (style.border.rightcolor) == 'undefined' || !style.border.rightcolor)
             && (typeof (style.border.bottomcolor) == 'undefined' || !style.border.bottomcolor)
             && (typeof (style.border.leftcolor) == 'undefined' || !style.border.leftcolor)) {
                that.css({
                    'borderColor':style.border.color,
                    'borderStyle':style.border.style,
                    'borderWidth':style.border.width
                });
            } else {
                that.css({
                    'borderTopColor':style.border.topcolor,
                    'borderTopStyle':style.border.topstyle,
                    'borderTopWidth':style.border.topwidth,
                    
                    'borderRightColor':style.border.rightcolor,
                    'borderRightStyle':style.border.rightstyle,
                    'borderRightWidth':style.border.rightwidth,
                    
                    'borderBottomColor':style.border.botomcolor,
                    'borderBottomStyle':style.border.botomstyle,
                    'borderBottomWidth':style.border.botomwidth,
                    
                    'borderLeftColor':style.border.leftcolor,
                    'borderLeftStyle':style.border.leftstyle,
                    'borderLeftWidth':style.border.leftwidth
                });
            }
            
                console.log(style.borderradius);
            if (!style.borderradius.topleft
             && !style.borderradius.topright
             && !style.borderradius.bottomleft
             && !style.borderradius.bottomright) {
                that.css({
                    'borderRadius':style.borderradius.all
                });
            } else {
                that.css({
                    'borderRadius':style.borderradius.topleft +'px '+ style.borderradius.topright +'px '+ style.borderradius.bottomright +'px '+ style.borderradius.bottomleft +'px'
                });
            }
            
            if ((typeof (style.margin.top) == 'undefined' || !style.margin.top)
             && (typeof (style.margin.right) == 'undefined' || !style.margin.right)
             && (typeof (style.margin.bottom) == 'undefined' || !style.margin.bottom)
             && (typeof (style.margin.left) == 'undefined' || !style.margin.left)) {
                that.css({
                    'margin':style.margin.all
                });
            } else {
                that.css({
                    'marginTop':style.margin.top +'px',
                    'marginRight':style.margin.right +'px',
                    'marginBottom':style.margin.bottom +'px',
                    'marginLeft':style.margin.left +'px',
                });
            }
            
            if ((typeof (style.padding.top) == 'undefined' || !style.padding.top)
             && (typeof (style.padding.right) == 'undefined' || !style.padding.right)
             && (typeof (style.padding.bottom) == 'undefined' || !style.padding.bottom)
             && (typeof (style.padding.left) == 'undefined' || !style.padding.left)) {
                that.css({
                    'padding':style.padding.all
                });
            } else {
                that.css({
                    'paddingTop':style.padding.top +'px',
                    'paddingRight':style.padding.right +'px',
                    'paddingBottom':style.padding.bottom +'px',
                    'paddingLeft':style.padding.left +'px',
                });
            }
            
            if ((typeof (style.padding.top) == 'undefined' || !style.padding.top)
             && (typeof (style.padding.right) == 'undefined' || !style.padding.right)
             && (typeof (style.padding.bottom) == 'undefined' || !style.padding.bottom)
             && (typeof (style.padding.left) == 'undefined' || !style.padding.left)) {
                that.css({
                    'padding':style.padding.all
                });
            } else {
                that.css({
                    'paddingTop':style.padding.top +'px',
                    'paddingRight':style.padding.right +'px',
                    'paddingBottom':style.padding.bottom +'px',
                    'paddingLeft':style.padding.left +'px',
                });
            }
        });
    }
}

function setElementToStyle(el) {
    var ele = $('#mainselector').val();
    var mainEl = ele;
    console.log(ele);
    if (typeof el != 'undefined' || el.length > 0) {
        if (el == 'subtitle') {
            ele =  mainEl + ' h2,';
            ele += mainEl + ' h3,';
            ele += mainEl + ' h4,';
            ele += mainEl + ' h5,';
            ele += mainEl + ' h6';
        } else if (el != 'null') {
            ele += ' ' + el;
        } else {
            mainEl = '';
        }
    }
    drawStylePanels(ele,mainEl);
}

function drawStylePanel() {
    var style = {};
    var cookieName = "";
    
    if (!$.cookie('elements')) {
        var elements = {};
        $.cookie('elements',elements);
    } else {
        var elements = $.cookie('elements');
    }
    
    cookieName = $('#selector').val().replace(/\s/g, '');
    cookieName = $('#selector').val().replace(/[,#\.]/g, '');
    
    if (typeof elements[cookieName] == 'undefined') {
        style = false;
    } else {
        style = elements[cookieName];
    }
    
    if (!style) {
        $('#bgCss').val('');
        $('#bgColor').val('');
        $('#bgImage').val('');
        $('#bgRepeat').val('');
        $('#bgPositionX').val('');
        $('#bgPositionY').val('');
        $('#bgAttachment').removeAttr('checked');
        
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
        
        $('#margin').val('');
        $('#marginTop').val('');
        $('#marginRight').val('');
        $('#marginBottom').val('');
        $('#marginLeft').val('');
        
        $('#padding').val('');
        $('#paddingTop').val('');
        $('#paddingRight').val('');
        $('#paddingBottom').val('');
        $('#paddingLeft').val('');
        
        $('#width').val('');
        $('#height').val('');
        $('#top').val('');
        $('#left').val('');
        
        $('#boxColor').val('');
        $('#boxShadowInset').removeAttr('checked');
        $('#boxShadowX').val(0);
        $('#boxShadowY').val(0);
        $('#boxShadowBlur').val(0);
        $('#boxShadowSpread').val(0);
        
        $('#fontColor').val('');
        $('#fontFamily').val('');
        $('#fontWeight').removeAttr('checked');
        $('#fontStyle').removeAttr('checked');
        $('#fontSize').val('');
        $('#fontAlign').val('');
        $('#fontDecoration').val('');
        $('#fontTransform').val('');
        $('#letterSpacing').val('');
        $('#wordSpacing').val('');
        $('#lineHeight').val('');
    } else {
        if (typeof style.background.color != 'undefined') { $('#bgColor').val(style.background.color); } else { $('#bgColor').val(''); }
        if (typeof style.background.image != 'undefined') { $('#bgImage').val(style.background.image); } else { $('#bgImage').val(''); }
        if (typeof style.background.repeat != 'undefined') { $('#bgRepeat').val(style.background.repeat); } else { $('#bgRepeat').val(''); }
        if (typeof style.background.positionX != 'undefined') { $('#bgPositionX').val(style.background.positionX); } else { $('#bgPositionX').val(''); }
        if (typeof style.background.positionY != 'undefined') { $('#bgPositionY').val(style.background.positionY); } else { $('#bgPositionY').val(''); }
        if (typeof style.background.attachment != 'undefined') { $('#bgAttachment').attr('checked','checked'); } else { $('#bgAttachment').removeAttr(''); }
        
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
        
        if (typeof style.margin.all != 'undefined') { $('#margin').val(style.margin.all); } else { $('#margin').val(''); }
        if (typeof style.margin.top != 'undefined') { $('#marginTop').val(style.margin.top); } else { $('#marginTop').val(''); }
        if (typeof style.margin.right != 'undefined') { $('#marginRight').val(style.margin.right); } else { $('#marginRight').val(''); }
        if (typeof style.margin.bottom != 'undefined') { $('#marginBottom').val(style.margin.bottom); } else { $('#marginBottom').val(''); }
        if (typeof style.margin.left != 'undefined') { $('#marginLeft').val(style.margin.left); } else { $('#marginLeft').val(''); }
        
        if (typeof style.padding.all != 'undefined') { $('#padding').val(style.padding.all); } else { $('#padding').val(''); }
        if (typeof style.padding.top != 'undefined') { $('#paddingTop').val(style.padding.top); } else { $('#paddingTop').val(''); }
        if (typeof style.padding.right != 'undefined') { $('#paddingRight').val(style.padding.right); } else { $('#paddingRight').val(''); }
        if (typeof style.padding.bottom != 'undefined') { $('#paddingBottom').val(style.padding.bottom); } else { $('#paddingBottom').val(''); }
        if (typeof style.padding.left != 'undefined') { $('#paddingLeft').val(style.padding.left); } else { $('#paddingLeft').val(''); }
        
        if (typeof style.dimensions.top != 'undefined') { $('#top').val(style.dimensions.top); } else { $('#top').val(''); }
        if (typeof style.dimensions.left != 'undefined') { $('#left').val(style.dimensions.left); } else { $('#left').val(''); }
        if (typeof style.dimensions.width != 'undefined') { $('#width').val(style.dimensions.width); } else { $('#width').val(''); }
        if (typeof style.dimensions.height != 'undefined') { $('#height').val(style.dimensions.height); } else { $('#height').val(''); }
        
        if (typeof style.boxshadow.color != 'undefined') { $('#boxColor').val(style.boxshadow.color); } else { $('#boxColor').val(''); }
        if (typeof style.boxshadow.inset != 'undefined') { $('#boxShadowInset').attr('checked','checked'); } else { $('#boxShadowInset').removeAttr('checked'); }
        if (typeof style.boxshadow.x != 'undefined') { $('#boxShadowX').val(style.boxshadow.x); } else { $('#boxShadowX').val(''); }
        if (typeof style.boxshadow.y != 'undefined') { $('#boxShadowY').val(style.boxshadow.y); } else { $('#boxShadowY').val(''); }
        if (typeof style.boxshadow.blur != 'undefined') { $('#boxShadowBlur').val(style.boxshadow.blur); } else { $('#boxShadowBlur').val(''); }
        if (typeof style.boxshadow.spread != 'undefined') { $('#boxShadowSpread').val(style.boxshadow.spread); } else { $('#boxShadowSpread').val(''); }
        
        if (typeof style.font.color != 'undefined') { $('#fontColor').val(style.font.color); } else { $('#fontColor').val(''); }
        if (typeof style.font.family != 'undefined') { $('#fontFamily').val(style.font.family); } else { $('#fontFamily').val(''); }
        if (typeof style.font.weight == 'undefined') { $('#fontWeight').removeAttr('checked'); } else { $('#fontWeight').attr('checked','checked'); }
        if (typeof style.font.style == 'undefined') { $('#fontStyle').removeAttr('checked'); } else { $('#fontStyle').attr('checked','checked'); }
        if (typeof style.font.size != 'undefined') { $('#fontSize').val(style.font.size); } else { $('#fontSize').val(''); }
        if (typeof style.font.align != 'undefined') { $('#fontAlign').val(style.font.align); } else { $('#fontAlign').val(''); }
        if (typeof style.font.decoration != 'undefined') { $('#fontDecoration').val(style.font.decoration); } else { $('#fontDecoration').val(''); }
        if (typeof style.font.transform != 'undefined') { $('#fontTransform').val(style.font.transform); } else { $('#fontTransform').val(''); }
        if (typeof style.font.letterspacing != 'undefined') { $('#letterSpacing').val(style.font.letterspacing); } else { $('#letterSpacing').val(''); }
        if (typeof style.font.wordspacing != 'undefined') { $('#wordSpacing').val(style.font.wordspacing); } else { $('#wordSpacing').val(''); }
        if (typeof style.font.lineheight != 'undefined') { $('#lineHeight').val(style.font.lineheight); } else { $('#lineHeight').val(''); }
        
        setStyle();
    }
    
    $( "#width" ).on('change', function(e) {
        $("#widthSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#height" ).on('change', function(e) {
        $("#heightSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#top" ).on('change', function(e) {
        $("#topSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#left" ).on('change', function(e) {
        $("#leftSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
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
    
    $( "#margin" ).on('change', function(e) {
        $("#marginSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#marginTop" ).on('change', function(e) {
        $("#marginTopSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#marginRight" ).on('change', function(e) {
        $("#marginRightSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#marginLeft" ).on('change', function(e) {
        $("#marginLeftSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#marginBottom" ).on('change', function(e) {
        $("#marginBottomSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    
    $( "#padding" ).on('change', function(e) {
        $("#paddingSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#paddingTop" ).on('change', function(e) {
        $("#paddingTopSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#paddingRight" ).on('change', function(e) {
        $("#paddingRightSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#paddingLeft" ).on('change', function(e) {
        $("#paddingLeftSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#paddingBottom" ).on('change', function(e) {
        $("#paddingBottomSlider").slider('option', 'value', parseInt($(this).val()));
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
    
    $( "#letterSpacing" ).on('change', function(e) {
        $("#letterSpacingSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#wordSpacing" ).on('change', function(e) {
        $("#wordSpacingSlider").slider('option', 'value', parseInt($(this).val()));
        setStyle();
    });
    $( "#lineHeight" ).on('change', function(e) {
        $("#lineHeightSlider").slider('option', 'value', parseInt($(this).val()));
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
    
    $('#font-colorpicker').ntColorPicker({
        type: 'hex',
        change:function(color){
            if (color.length > 0) {
                $('#fontColor').val(color);
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
    var that = $($('#selector').val()); /* $($('#selector').val()).get(0); */
    var cookieName = "";
    var style = {};
    var elements = {};
    
    if (!$.cookie('elements')) {
        $.cookie('elements',elements);
    } else {
        var elements = $.cookie('elements');
    }
    
    cookieName = $('#selector').val().replace(/\s/g, '');
    cookieName = $('#selector').val().replace(/[,#\.]/g, '');
    
    if (typeof elements[cookieName] == 'undefined') {
        style = {};
    } else {
        style = elements[cookieName];
    }
    
    style.background = {};
    style.border = {};
    style.boxshadow = {};
    style.borderradius = {};
    style.margin = {};
    style.padding = {};
    style.position = {};
    style.dimensions = {};
    style.font = {};
    
    var bgCss = "";
    
        style.background.color = $('#bgColor').val();
        $(that).css({'backgroundColor': $('#bgColor').val()});
        bgCss += "background-color:" + $('#bgColor').val() +";";
        
        style.background.image = $('#bgImage').val();
        $(that).css('backgroundImage','url("'+ $('#bgImage').val() +'")');
        bgCss += "background-image:" + 'url("'+ $('#bgImage').val() +'");';
            
        style.background.repeat = $('#bgRepeat').val();
        $(that).css('backgroundRepeat',$('#bgRepeat').val());
        bgCss += "background-repeat:" + $('#bgRepeat').val() +";";
        
        style.background.positionX = $('#bgPositionX').val();
        style.background.positionY = $('#bgPositionY').val();
        $(that).css({'backgroundPosition': $('#bgPositionX').val() +'px '+ $('#bgPositionY').val() +'px'});
        bgCss += "background-position:" + $('#bgPositionX').val() +'px '+ $('#bgPositionY').val() +'px;';
        
        if ($('#bgAttachment').is(':checked')) {
            style.background.attachment = $('#bgAttachment').val();
            $(that).css('backgroundAttachment','fixed');
            bgCss += "background-attachment:fixed;";
        } else {
            style.background.attachment = null;
            $(that).css('backgroundAttachment','none');
            bgCss += "background-attachment:none;";
        }
        
        
    if ($('#bgCss').val().length > 0) {
        props = $(that).attr('style',$(that).attr('style') + $("#bgCss").val());
        
        /*
        props = cssToJson($("#bgCss").val());
        $.each(props,function(i,value) {
            $(that).css(value);
        });
        */
    }
    style.background.css = $('#bgCss').val();
    
    
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
        style.borderradius.all = $('#borderRadius').val();
        $(that).css('borderRadius',$('#borderRadius').val() +'px');
    } else {
        var cssBorderRadius = "";
        
        style.borderradius.topleft = $('#borderRadiusTopLeft').val();
        cssBorderRadius += parseInt($('#borderRadiusTopLeft').val()) +'px '; 
        
        style.borderradius.topright = $('#borderRadiusTopRight').val();
        cssBorderRadius += parseInt($('#borderRadiusTopRight').val()) +'px ';
        
        style.borderradius.bottomleft = $('#borderRadiusBottomLeft').val();
        cssBorderRadius += parseInt($('#borderRadiusBottomLeft').val()) +'px '; 
        
        style.borderradius.bottomright = $('#borderRadiusBottomRight').val();
        cssBorderRadius += parseInt($('#borderRadiusBottomRight').val()) +'px'; 
        
        $(that).css({'borderRadius':cssBorderRadius});
    }
    
    style.dimensions.width = $('#width').val();
    $(that).css('width',$('#width').val() +'px');
    
    style.dimensions.height = $('#height').val();
    $(that).css('height',$('#height').val() +'px');
    
    style.dimensions.top = $('#top').val();
    $(that).css('top',$('#top').val() +'px');
    
    style.dimensions.left = $('#left').val();
    $(that).css('left',$('#left').val() +'px');
    
    style.dimensions.position = $('#position').val();
    $(that).css('position',$('#position').val());
    
    if ($('#marginAdvanced').val() == 0) {
        style.margin.all = $('#margin').val();
        $(that).css('margin',$('#margin').val() +'px');
    } else {
        style.margin.top = $('#marginTop').val();
        $(that).css({'marginTop':$('#marginTop').val() +'px'});
        
        style.margin.right = $('#marginRight').val();
        $(that).css({'marginRight':$('#marginRight').val() +'px'});
        
        style.margin.left = $('#marginLeft').val();
        $(that).css({'marginLeft':$('#marginLeft').val() +'px'});
        
        style.margin.bottom = $('#marginBottom').val();
        $(that).css({'paddingBottom':$('#paddingBottom').val() +'px'});
    }
    
    if ($('#paddingAdvanced').val() == 0) {
        style.padding.all = $('#padding').val();
        $(that).css('padding',$('#padding').val() +'px');
    } else {
        style.padding.top = $('#paddingTop').val();
        $(that).css({'paddingTop':$('#paddingTop').val() +'px'});
        
        style.padding.right = $('#paddingRight').val();
        $(that).css({'paddingRight':$('#paddingRight').val() +'px'});
        
        style.padding.left = $('#paddingLeft').val();
        $(that).css({'paddingLeft':$('#paddingLeft').val() +'px'});
        
        style.padding.bottom = $('#paddingBottom').val();
        $(that).css({'paddingBottom':$('#paddingBottom').val() +'px'});
    }
    
    var cssBoxShadow = "";
    if ($('#boxShadowInset').is(':checked')) { 
        style.boxshadow.inset = 1;
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
    
    var cssFont = "";
        
    if ($('#fontColor').val()) { 
        style.font.color = $('#fontColor').val();
        $(that).css('color',$('#fontColor').val());
    }
    if ($('#fontFamily option').is(':selected')) { 
        style.font.family = $('#fontFamily').val();
        $(that).css('fontFamily',$('#fontFamily').val());
    }
    if ($('#fontSize option').is(':selected')) { 
        style.font.size = $('#fontSize').val();
        $(that).css('fontSize',$('#fontSize').val());
    }
    if ($('#fontStyle').val()) { 
        style.font.style = $('#fontStyle').val();
        $(that).css('fontStyle','italic');
    }
    if ($('#fontWeight').val()) { 
        style.font.weight = $('#fontWeight').val();
        $(that).css('fontWeight','bold');
    }
    if ($('#fontDecoration').val()) { 
        style.font.decoration = $('#fontDecoration').val();
        $(that).css('textDecoration',$('#fontDecoration').val());
    }
    if ($('#fontAlign').val()) { 
        style.font.align = $('#fontAlign').val();
        $(that).css('textAlign',$('#fontAlign').val());
    }
    if ($('#fontTransform').val()) { 
        style.font.transform = $('#fontTransform').val();
        $(that).css('textTransform',$('#fontTransform').val());
    }
    if ($('#letterSpacing').val()) { 
        style.font.transform = $('#letterSpacing').val();
        $(that).css('letter-spacing',$('#letterSpacing').val());
    }
    if ($('#wordSpacing').val()) { 
        style.font.transform = $('#wordSpacing').val();
        $(that).css('wordSpacing',$('#wordSpacing').val());
    }
    if ($('#lineHeight').val()) { 
        style.font.transform = $('#lineHeight').val();
        $(that).css('lineHeight',$('#lineHeight').val());
    }
    
    elements[cookieName] = style;
    $.cookie('elements',elements);
 }

function cssToJson(css) {
    if (typeof css == 'undefined' || css.length == 0) {
        return false;
    }
    var styles = css.split(';'),
        i= styles.length,
        json = {},
        style, k, v;
    
    
    while (i--)
    {
        style = styles[i].split(':');
        var k = $.trim(style[0]);
        var v = $.trim(style[1]);
        if (k.length > 0 && v.length > 0)
        {
            json[i] = {};
            json[i][k] = v;
        }
    }
    return json;
    //return $.parseJSON(json);
}

/**
 * Helper que establece el valor de la alineacion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setAlign(e,v,c) {
    $('#alignLeft').removeClass('align-leftOn');
    $('#alignCenter').removeClass('align-centerOn');
    $('#alignRight').removeClass('align-rightOn');
    $('#alignJustify').removeClass('align-justifyOn');
    $(e).toggleClass(c);
    $('#fontAlign').val(v);
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setDecoration(e,v,c) {
    $('#lineThrough').removeClass('line-throughOn');
    $('#underline').removeClass('underlineOn');
    
    if ($('#fontDecoration').val() == v) {
        $('#fontDecoration').val('');
        $(e).removeClass(c);
    } else {
        $('#fontDecoration').val(v);
        $(e).addClass(c);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setWeight(e,v,c) {
    $(e).toggleClass(c);
    if ($('#fontWeight').val() == v) {
        $('#fontWeight').val('');
    } else {
        $('#fontWeight').val(v);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setItalic(e,v,c) {
    $(e).toggleClass(c);
    if ($('#fontStyle').val() == v) {
        $('#fontStyle').val('');
    } else {
        $('#fontStyle').val(v);
    }
    setStyle();
}

/**
 * Helper que establece el valor de la decoracion del texto del elemento seleccionado.
 *
 * @return void.
 */
function setTransform(e,v,c) {
    $('#upper').removeClass('uppercaseOn');
    $('#lower').removeClass('lowercaseOn');
    
    if ($('#fontTransform').val() == v) {
        $('#fontTransform').val('');
        $(e).removeClass(c);
    } else {
        $('#fontTransform').val(v);
        $(e).addClass(c);
    }
    setStyle();
}

/**
 * Limpia los campos y los estilos de los fuentes.
 *
 * @return void.
 */
function resetFont() {
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
    $('#fontColor').val('');
    $('#fontFamily').val('');
    $('#fontWeight').val('');
    $('#fontStyle').val('');
    $('#fontSize').val('');
    $('#fontAlign').val('');
    $('#fontDecoration').val('');
    $('#fontLetterSpacing').val('');
    $('#fontWordSpacing').val('');
    $('#fontLineHeight').val('');
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

/**
 * Limpia los campos y los margenes externos.
 *
 * @return void.
 */
function resetMargin() {
    $($('#selector').val()).css({
        'margin': 'auto'
    });
}

/**
 * Limpia los campos y los margenes externos.
 *
 * @return void.
 */
function resetDimensions() {
    $($('#selector').val()).css({
        'width': 'auto',
        'height': 'auto',
        'top': 'auto',
        'left': 'auto',
        'position':'relative'
    });
}

/**
 * Limpia los campos y los margenes internos.
 *
 * @return void.
 */
function resetPadding() {
    $($('#selector').val()).css({
        'padding': '0px'
    });
}

function cleanStyle() {
    resetFont();
    resetBackground();
    resetMargin();
    resetPadding();
    resetDimensions();
    /*
    resetBorder();
    resetBorderRadius();
    resetBoxShadow();
    resetMargins();
    */
}

function copyStyle() {
    var cookieName = $.cookie('currentBlock');
    if (cookieName.length == 0 || !cookieName) {
        alert("Debes seleccionar un elemento de la pagina para copiar");
        return false;
    }
    var elements = $.cookie('elements');
    if (typeof elements[cookieName] != 'undefined') {
        $.cookie('clipboardStyle',elements[cookieName]);
    } else {
        alert("No hay nada para copiar");
        return false;
    }
}

function pasteStyle() {
    var cookieName = $.cookie('currentBlock');
    if (cookieName.length == 0 || !cookieName) {
        alert("Debes seleccionar un elemento de la pagina para pegar");
        return false;
    }
    if (!$.cookie('clipboardStyle')) {
        alert("No hay nada para pegar");
        return false;
    } else {
        var elements = $.cookie('elements');
        elements[cookieName] = $.cookie('clipboardStyle');
        $.cookie('elements',elements);
        drawStylePanels($("#selector").val());
        setStyle();
    }
}

function saveStyle(url) {
    var theme_id = getUrlVars()["theme_id"];
    
    if (typeof theme_id != 'undefined') {
        $.post(url,{
            'theme_id':theme_id,
            'selectors':$.cookie('elements')
        });
    }
}

function printStyle() {
    /** @todo funciones para imprimir el estilo convertir el objeto json a string con estructura ecmas */
}
function getParentId(el) {
    var parent = el.parent();
        
    if (parent.length > 0 
    && $(parent).prop('tagName').toLowerCase() != 'html' 
    && $(parent).prop('tagName').toLowerCase() != 'body'
    && $(el).prop('tagName').toLowerCase() != 'body') 
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
 * Reconoce todos los elementos administrables y le asigna los botones de las acciones
 *
 * @param elements object con los elementos a administrar
 * @param areChildrens boolean si los elementos pasados son hijos de otro 
 * @return void.
 */
function addAdminControls(elements,areChildrens) {
    if (typeof areChildrens == 'undefined') {
        areChildrens = false;
    }
    $.each(elements, function(i,el) {
        if (!$(el.selector) && !areChildrens) {
            return true;
        } else {
            if (areChildrens) {
                ele = $(el);
            } else {
                ele = $(el.selector);
            }
            $(ele).each(function() {
                var that = $(this);
                
                if (that.hasClass('administrable')) {
                    return true;
                }
            
                if (!that.attr('id') || that.attr('id').length == 0) {
                    that.attr('id','widget-'+ getParentId(that) +'-'+ this.tagName.toLowerCase() +'-'+ that.index());
                }
                
                var html = "";
                html += '<div class="actions actions'+ i +'">';
                html += '<p style="color:#000;font:normal 10px arial">'+ that.attr('id') +'</p>';
                html += '<a class="admin-icons style" onclick="drawStylePanels(\'#' + that.attr('id') +'\');slidePanel(\'style\')"></a>';
                
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
                that.find('.actions'+ i).mouseenter(function(e) {
                    that.css({
                        border:'dashed 1px #900'
                    });
                }).mouseleave(function(e) {
                    that.css({
                        border:'none'
                    });
                });
                if (!areChildrens && typeof el.childrens != 'undefined') {
                    addAdminControls(el.childrens,true);
                }
            });
        }
    });
}

