/**
 *
 * NecoCSS
 * Author: Yosiet Serga
 * Version: 1.0.0
 * Powered By: CopyCSS (https://github.com/moagrius/copycss)
 * 
 * Dual licensed under the MIT and GPL licenses
 * 
 */
;(function ( $, window, document, undefined ) {
    
    var pluginName = "ntCSS",
        defaults = {};

    function _ntCss( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    _ntCss.prototype = {

        init: function() {
    	
        }
    };

    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "nt_" + pluginName)) {
                $.data(this, "nt_" + pluginName, new _ntCss( this, options ));
            }
        });
    };

	$.fn.getStyles = function(only, except){
		
		// the map to return with requested styles and values as KVP
		var product = {};
		
		// the style object from the DOM element we need to iterate through
		var style;
		
		// recycle the name of the style attribute
		var name;
		
		// if it's a limited list, no need to run through the entire style object
		if(only && only instanceof Array){
			
			for(var i = 0, l = only.length; i < l; i++){
				// since we have the name already, just return via built-in .css method
				name = only[i];
				product[name] = this.css(name);
			}
			
		} else {
			// otherwise, we need to get everything
			var dom = this.get(0);
			
			// standards
			if (window.getComputedStyle) {
				
				// convenience methods to turn css case ('background-image') to camel ('backgroundImage')
				var pattern = /\-([a-z])/g;
				var uc = function (a, b) {
						return b.toUpperCase();
				};			
				var camelize = function(string){
					return string.replace(pattern, uc);
				};
				if (dom) {
				    style = window.getComputedStyle(dom, null)
				}
				// make sure we're getting a good reference
				if (style) {
					var camel, value;
					// opera doesn't give back style.length - use truthy since a 0 length may as well be skipped anyways
					if (style.length) {
						for (var i = 0, l = style.length; i < l; i++) {
							name = style[i];
							camel = camelize(name);
							value = style.getPropertyValue(name);
							product[camel] = value;
						}
					} else {
						// opera
						for (name in style) {
							camel = camelize(name);
							value = style.getPropertyValue(name) || style[name];
							product[camel] = value;
						}
					}
				}
			}
			// IE - first try currentStyle, then normal style object - don't bother with runtimeStyle
			else if (style = dom.currentStyle) {
    				    console.log(style);
				for (name in style) {
					product[name] = style[name];
				}
			}
			else if (style = dom.style) {
    				    console.log(style);
				for (name in style) {
					if (typeof style[name] != 'function') {
						product[name] = style[name];
					}
				}
			}
		}
		
		// remove any styles specified...
		// be careful on blacklist - sometimes vendor-specific values aren't obvious but will be visible...  e.g., excepting 'color' will still let '-webkit-text-fill-color' through, which will in fact color the text
		if(except && except instanceof Array){
			for(var i = 0, l = except.length; i < l; i++){
				name = except[i];
				delete product[name];
			}
		}
		
		// one way out so we can process blacklist in one spot
		return product;
	
	};
	
	// sugar - source is the selector, dom element or jQuery instance to copy from - only and except are optional
	$.fn.copyCSS = function(source, only, except){
		var styles = $(source).ntGetStyles({
		  'only':only,
          'except':except
        });
		this.css(styles);
	};
	
})( jQuery, window, document );