if (!(window.console && console.log)) {
    (function() {
        var noop = function() {};
        var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error', 'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log', 'markTimeline', 'profile', 'profileEnd', 'markTimeline', 'table', 'time', 'timeEnd', 'timeStamp', 'trace', 'warn'];
        var length = methods.length;
        var console = window.console = {};
        while (length--) {
                console[methods[length]] = noop;
        }
    }());
}

/* jQuery Mask */
!function(e){var t=(navigator.userAgent.indexOf("MSIE")>-1?"paste":"input")+".mask",n=void 0!=window.orientation;e.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"}},e.fn.extend({caret:function(e,t){if(0!=this.length){if("number"==typeof e)return t="number"==typeof t?t:e,this.each(function(){if(this.setSelectionRange)this.focus(),this.setSelectionRange(e,t);else if(this.createTextRange){var n=this.createTextRange();n.collapse(!0),n.moveEnd("character",t),n.moveStart("character",e),n.select()}});if(this[0].setSelectionRange)e=this[0].selectionStart,t=this[0].selectionEnd;else if(document.selection&&document.selection.createRange){var n=document.selection.createRange();e=0-n.duplicate().moveStart("character",-1e5),t=e+n.text.length}return{begin:e,end:t}}},unmask:function(){return this.trigger("unmask")},mask:function(a,r){if(!a&&this.length>0){var i=e(this[0]),o=i.data("tests");return e.map(i.data("buffer"),function(e,t){return o[t]?e:null}).join("")}r=e.extend({placeholder:"_",completed:null},r);var c=e.mask.definitions,o=[],l=a.length,s=null,u=a.length;return e.each(a.split(""),function(e,t){"?"==t?(u--,l=e):c[t]?(o.push(new RegExp(c[t])),null==s&&(s=o.length-1)):o.push(null)}),this.each(function(){function i(e){for(;++e<=u&&!o[e];);return e}function f(e){for(;!o[e]&&--e>=0;);for(var t=e;u>t;t++)if(o[t]){k[t]=r.placeholder;var n=i(t);if(!(u>n&&o[t].test(k[n])))break;k[t]=k[n]}g(),b.caret(Math.max(s,e))}function h(e){for(var t=e,n=r.placeholder;u>t;t++)if(o[t]){var a=i(t),c=k[t];if(k[t]=n,!(u>a&&o[a].test(c)))break;n=c}}function d(t){var a=e(this).caret(),r=t.keyCode;return y=16>r||r>16&&32>r||r>32&&41>r,a.begin-a.end==0||y&&8!=r&&46!=r||m(a.begin,a.end),8==r||46==r||n&&127==r?(f(a.begin+(46==r?0:-1)),!1):27==r?(b.val(x),b.caret(0,p()),!1):void 0}function v(t){if(y)return y=!1,8==t.keyCode?!1:null;t=t||window.event;var n=t.charCode||t.keyCode||t.which,a=e(this).caret();if(t.ctrlKey||t.altKey||t.metaKey)return!0;if(n>=32&&125>=n||n>186){var c=i(a.begin-1);if(u>c){var l=String.fromCharCode(n);if(o[c].test(l)){h(c),k[c]=l,g();var s=i(c);e(this).caret(s),r.completed&&s==u&&r.completed.call(b)}}}return!1}function m(e,t){for(var n=e;t>n&&u>n;n++)o[n]&&(k[n]=r.placeholder)}function g(){return b.val(k.join("")).val()}function p(e){for(var t=b.val(),n=-1,a=0,i=0;u>a;a++)if(o[a]){for(k[a]=r.placeholder;i++<t.length;){var c=t.charAt(i-1);if(o[a].test(c)){k[a]=c,n=a;break}}if(i>t.length)break}else k[a]==t[i]&&a!=l&&(i++,n=a);return!e&&l>n+1?(b.val(""),m(0,u)):(e||n+1>=l)&&(g(),e||b.val(b.val().substring(0,n+1))),l?a:s}var b=e(this),k=e.map(a.split(""),function(e){return"?"!=e?c[e]?r.placeholder:e:void 0}),y=!1,x=b.val();b.data("buffer",k).data("tests",o),b.attr("readonly")||b.one("unmask",function(){b.unbind(".mask").removeData("buffer").removeData("tests")}).bind("focus.mask",function(){x=b.val();var e=p();g(),setTimeout(function(){e==a.length?b.caret(0,e):b.caret(e)},0)}).bind("blur.mask",function(){p(),b.val()!=x&&b.change()}).bind("keydown.mask",d).bind("keypress.mask",v).bind(t,function(){setTimeout(function(){b.caret(p(!0))},0)}),p()})}})}(jQuery);

/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 * 
 * Requires: 1.2.2+
 */
(function(a){function d(b){var c=b||window.event,d=[].slice.call(arguments,1),e=0,f=!0,g=0,h=0;return b=a.event.fix(c),b.type="mousewheel",c.wheelDelta&&(e=c.wheelDelta/120),c.detail&&(e=-c.detail/3),h=e,c.axis!==undefined&&c.axis===c.HORIZONTAL_AXIS&&(h=0,g=-1*e),c.wheelDeltaY!==undefined&&(h=c.wheelDeltaY/120),c.wheelDeltaX!==undefined&&(g=-1*c.wheelDeltaX/120),d.unshift(b,e,g,h),(a.event.dispatch||a.event.handle).apply(this,d)}var b=["DOMMouseScroll","mousewheel"];if(a.event.fixHooks)for(var c=b.length;c;)a.event.fixHooks[b[--c]]=a.event.mouseHooks;a.event.special.mousewheel={setup:function(){if(this.addEventListener)for(var a=b.length;a;)this.addEventListener(b[--a],d,!1);else this.onmousewheel=d},teardown:function(){if(this.removeEventListener)for(var a=b.length;a;)this.removeEventListener(b[--a],d,!1);else this.onmousewheel=null}},a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})})(jQuery);
