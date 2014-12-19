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

 /*
 * jQuery Cryptography Plug-in
 * version: 1.0.0 (24 Sep 2008)
 * copyright 2008 Scott Thompson http://www.itsyndicate.ca - scott@itsyndicate.ca
 * http://www.opensource.org/licenses/mit-license.php
 *
 * A set of functions to do some basic cryptography encoding/decoding
 * I compiled from some javascripts I found into a jQuery plug-in.
 * Thanks go out to the original authors.
 *
 * Also a big thanks to Wade W. Hedgren http://homepages.uc.edu/~hedgreww
 * for the 1.1.1 upgrade to conform correctly to RFC4648 Sec5 url save base64
 *
 * Changelog: 1.1.0
 * - rewrote plugin to use only one item in the namespace
 *
 * Changelog: 1.1.1
 * - added code to base64 to allow URL and Filename Safe Alphabet (RFC4648 Sec5) 
 *
 * --- Base64 Encoding and Decoding code was written by
 *
 * Base64 code from Tyler Akins -- http://rumkin.com
 * and is placed in the public domain
 *
 *
 * --- MD5 and SHA1 Functions based upon Paul Johnston's javascript libraries.
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.1 Copyright (C) Paul Johnston 1999 - 2002.
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for more info.
 *
 * xTea Encrypt and Decrypt
 * copyright 2000-2005 Chris Veness
 * http://www.movable-type.co.uk
 *
 *
 * Examples:
 *
        var md5 = $().crypt({method:"md5",source:$("#phrase").val()});
        var sha1 = $().crypt({method:"sha1",source:$("#phrase").val()});
        var b64 = $().crypt({method:"b64enc",source:$("#phrase").val()});
        var b64dec = $().crypt({method:"b64dec",source:b64});
        var xtea = $().crypt({method:"xteaenc",source:$("#phrase").val(),keyPass:$("#passPhrase").val()});
        var xteadec = $().crypt({method:"xteadec",source:xtea,keyPass:$("#passPhrase").val()});
        var xteab64 = $().crypt({method:"xteab64enc",source:$("#phrase").val(),keyPass:$("#passPhrase").val()});
        var xteab64dec = $().crypt({method:"xteab64dec",source:xteab64,keyPass:$("#passPhrase").val()});

    You can also pass source this way.
    var md5 = $("#idOfSource").crypt({method:"md5"});
 *
 */
;(function($){$.fn.crypt=function(options){var defaults={b64Str:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",strKey:"9333cc23245f2c47546719fd37e2d6f412d862d5222652336ee97bdd03ac2095",method:"md5",source:"",chrsz:8,hexcase:0};if(typeof(options.urlsafe)=='undefined'){defaults.b64Str+='+/=';options.urlsafe=false;}else if(options.urlsafe){defaults.b64Str+='-_=';}else{defaults.b64Str+='+/=';}var opts=$.extend(defaults,options);if(!opts.source){var $this=$(this);if($this.html())opts.source=$this.html();else if($this.val())opts.source=$this.val();else{alert("Please provide source text");return false;};};if(opts.method=='md5'){return md5(opts);}else if(opts.method=='sha1'){return sha1(opts);}else if(opts.method=='b64enc'){return b64enc(opts);}else if(opts.method=='b64dec'){return b64dec(opts);}else if(opts.method=='xteaenc'){return xteaenc(opts);}else if(opts.method=='xteadec'){return xteadec(opts);}else if(opts.method=='xteab64enc'){var tmpenc=xteaenc(opts);opts.method="b64enc";opts.source=tmpenc;return b64enc(opts);}else if(opts.method=='xteab64dec'){var tmpdec=b64dec(opts);opts.method="xteadec";opts.source=tmpdec;return xteadec(opts);}function b64enc(params){var output="";var chr1,chr2,chr3;var enc1,enc2,enc3,enc4;var i=0;do{chr1=params.source.charCodeAt(i++);chr2=params.source.charCodeAt(i++);chr3=params.source.charCodeAt(i++);enc1=chr1>>2;enc2=((chr1&3)<<4)|(chr2>>4);enc3=((chr2&15)<<2)|(chr3>>6);enc4=chr3&63;if(isNaN(chr2)){enc3=enc4=64;}else if(isNaN(chr3)){enc4=64;};output+=params.b64Str.charAt(enc1)
+params.b64Str.charAt(enc2)
+params.b64Str.charAt(enc3)
+params.b64Str.charAt(enc4);}while(i<params.source.length);return output;};function b64dec(params){var output="";var chr1,chr2,chr3;var enc1,enc2,enc3,enc4;var i=0;var re=new RegExp('[^A-Za-z0-9'+params.b64Str.substr(-3)+']','g');params.source=params.source.replace(re,"");do{enc1=params.b64Str.indexOf(params.source.charAt(i++));enc2=params.b64Str.indexOf(params.source.charAt(i++));enc3=params.b64Str.indexOf(params.source.charAt(i++));enc4=params.b64Str.indexOf(params.source.charAt(i++));chr1=(enc1<<2)|(enc2>>4);chr2=((enc2&15)<<4)|(enc3>>2);chr3=((enc3&3)<<6)|enc4;output=output+String.fromCharCode(chr1);if(enc3!=64){output=output+String.fromCharCode(chr2);}if(enc4!=64){output=output+String.fromCharCode(chr3);}}while(i<params.source.length);return output;};function md5(params){return binl2hex(core_md5(str2binl(params.source),params.source.length*params.chrsz));function binl2hex(binarray)
{var hex_tab=params.hexcase?"0123456789ABCDEF":"0123456789abcdef";var str="";for(var i=0;i<binarray.length*4;i++)
{str+=hex_tab.charAt((binarray[i>>2]>>((i%4)*8+4))&0xF)+hex_tab.charAt((binarray[i>>2]>>((i%4)*8))&0xF);};return str;};function core_hmac_md5(key,data)
{var bkey=str2binl(key);if(bkey.length>16)bkey=core_md5(bkey,key.length*params.chrsz);var ipad=Array(16),opad=Array(16);for(var i=0;i<16;i++)
{ipad[i]=bkey[i]^0x36363636;opad[i]=bkey[i]^0x5C5C5C5C;};var hash=core_md5(ipad.concat(str2binl(data)),512+data.length*params.chrsz);return core_md5(opad.concat(hash),512+128);};function str2binl(str)
{var bin=Array();var mask=(1<<params.chrsz)-1;for(var i=0;i<str.length*params.chrsz;i+=params.chrsz)bin[i>>5]|=(str.charCodeAt(i/params.chrsz)&mask)<<(i%32);return bin;}function bit_rol(num,cnt)
{return(num<<cnt)|(num>>>(32-cnt));}function md5_cmn(q,a,b,x,s,t)
{return safe_add(bit_rol(safe_add(safe_add(a,q),safe_add(x,t)),s),b);}function md5_ff(a,b,c,d,x,s,t)
{return md5_cmn((b&c)|((~b)&d),a,b,x,s,t);}function md5_gg(a,b,c,d,x,s,t)
{return md5_cmn((b&d)|(c&(~d)),a,b,x,s,t);}function md5_hh(a,b,c,d,x,s,t)
{return md5_cmn(b^c^d,a,b,x,s,t);}function md5_ii(a,b,c,d,x,s,t)
{return md5_cmn(c^(b|(~d)),a,b,x,s,t);}function core_md5(x,len)
{x[len>>5]|=0x80<<((len)%32);x[(((len+64)>>>9)<<4)+14]=len;var a=1732584193;var b=-271733879;var c=-1732584194;var d=271733878;for(var i=0;i<x.length;i+=16)
{var olda=a;var oldb=b;var oldc=c;var oldd=d;a=md5_ff(a,b,c,d,x[i+0],7,-680876936);d=md5_ff(d,a,b,c,x[i+1],12,-389564586);c=md5_ff(c,d,a,b,x[i+2],17,606105819);b=md5_ff(b,c,d,a,x[i+3],22,-1044525330);a=md5_ff(a,b,c,d,x[i+4],7,-176418897);d=md5_ff(d,a,b,c,x[i+5],12,1200080426);c=md5_ff(c,d,a,b,x[i+6],17,-1473231341);b=md5_ff(b,c,d,a,x[i+7],22,-45705983);a=md5_ff(a,b,c,d,x[i+8],7,1770035416);d=md5_ff(d,a,b,c,x[i+9],12,-1958414417);c=md5_ff(c,d,a,b,x[i+10],17,-42063);b=md5_ff(b,c,d,a,x[i+11],22,-1990404162);a=md5_ff(a,b,c,d,x[i+12],7,1804603682);d=md5_ff(d,a,b,c,x[i+13],12,-40341101);c=md5_ff(c,d,a,b,x[i+14],17,-1502002290);b=md5_ff(b,c,d,a,x[i+15],22,1236535329);a=md5_gg(a,b,c,d,x[i+1],5,-165796510);d=md5_gg(d,a,b,c,x[i+6],9,-1069501632);c=md5_gg(c,d,a,b,x[i+11],14,643717713);b=md5_gg(b,c,d,a,x[i+0],20,-373897302);a=md5_gg(a,b,c,d,x[i+5],5,-701558691);d=md5_gg(d,a,b,c,x[i+10],9,38016083);c=md5_gg(c,d,a,b,x[i+15],14,-660478335);b=md5_gg(b,c,d,a,x[i+4],20,-405537848);a=md5_gg(a,b,c,d,x[i+9],5,568446438);d=md5_gg(d,a,b,c,x[i+14],9,-1019803690);c=md5_gg(c,d,a,b,x[i+3],14,-187363961);b=md5_gg(b,c,d,a,x[i+8],20,1163531501);a=md5_gg(a,b,c,d,x[i+13],5,-1444681467);d=md5_gg(d,a,b,c,x[i+2],9,-51403784);c=md5_gg(c,d,a,b,x[i+7],14,1735328473);b=md5_gg(b,c,d,a,x[i+12],20,-1926607734);a=md5_hh(a,b,c,d,x[i+5],4,-378558);d=md5_hh(d,a,b,c,x[i+8],11,-2022574463);c=md5_hh(c,d,a,b,x[i+11],16,1839030562);b=md5_hh(b,c,d,a,x[i+14],23,-35309556);a=md5_hh(a,b,c,d,x[i+1],4,-1530992060);d=md5_hh(d,a,b,c,x[i+4],11,1272893353);c=md5_hh(c,d,a,b,x[i+7],16,-155497632);b=md5_hh(b,c,d,a,x[i+10],23,-1094730640);a=md5_hh(a,b,c,d,x[i+13],4,681279174);d=md5_hh(d,a,b,c,x[i+0],11,-358537222);c=md5_hh(c,d,a,b,x[i+3],16,-722521979);b=md5_hh(b,c,d,a,x[i+6],23,76029189);a=md5_hh(a,b,c,d,x[i+9],4,-640364487);d=md5_hh(d,a,b,c,x[i+12],11,-421815835);c=md5_hh(c,d,a,b,x[i+15],16,530742520);b=md5_hh(b,c,d,a,x[i+2],23,-995338651);a=md5_ii(a,b,c,d,x[i+0],6,-198630844);d=md5_ii(d,a,b,c,x[i+7],10,1126891415);c=md5_ii(c,d,a,b,x[i+14],15,-1416354905);b=md5_ii(b,c,d,a,x[i+5],21,-57434055);a=md5_ii(a,b,c,d,x[i+12],6,1700485571);d=md5_ii(d,a,b,c,x[i+3],10,-1894986606);c=md5_ii(c,d,a,b,x[i+10],15,-1051523);b=md5_ii(b,c,d,a,x[i+1],21,-2054922799);a=md5_ii(a,b,c,d,x[i+8],6,1873313359);d=md5_ii(d,a,b,c,x[i+15],10,-30611744);c=md5_ii(c,d,a,b,x[i+6],15,-1560198380);b=md5_ii(b,c,d,a,x[i+13],21,1309151649);a=md5_ii(a,b,c,d,x[i+4],6,-145523070);d=md5_ii(d,a,b,c,x[i+11],10,-1120210379);c=md5_ii(c,d,a,b,x[i+2],15,718787259);b=md5_ii(b,c,d,a,x[i+9],21,-343485551);a=safe_add(a,olda);b=safe_add(b,oldb);c=safe_add(c,oldc);d=safe_add(d,oldd);};return Array(a,b,c,d);};};function safe_add(x,y)
{var lsw=(x&0xFFFF)+(y&0xFFFF);var msw=(x>>16)+(y>>16)+(lsw>>16);return(msw<<16)|(lsw&0xFFFF);};function sha1(params){return binb2hex(core_sha1(str2binb(params.source),params.source.length*params.chrsz));function core_sha1(x,len)
{x[len>>5]|=0x80<<(24-len%32);x[((len+64>>9)<<4)+15]=len;var w=Array(80);var a=1732584193;var b=-271733879;var c=-1732584194;var d=271733878;var e=-1009589776;for(var i=0;i<x.length;i+=16)
{var olda=a;var oldb=b;var oldc=c;var oldd=d;var olde=e;for(var j=0;j<80;j++)
{if(j<16)w[j]=x[i+j];else w[j]=rol(w[j-3]^w[j-8]^w[j-14]^w[j-16],1);var t=safe_add(safe_add(rol(a,5),sha1_ft(j,b,c,d)),safe_add(safe_add(e,w[j]),sha1_kt(j)));e=d;d=c;c=rol(b,30);b=a;a=t;}a=safe_add(a,olda);b=safe_add(b,oldb);c=safe_add(c,oldc);d=safe_add(d,oldd);e=safe_add(e,olde);}return Array(a,b,c,d,e);}function rol(num,cnt)
{return(num<<cnt)|(num>>>(32-cnt));}function sha1_kt(t)
{return(t<20)?1518500249:(t<40)?1859775393:(t<60)?-1894007588:-899497514;}function sha1_ft(t,b,c,d)
{if(t<20)return(b&c)|((~b)&d);if(t<40)return b^c^d;if(t<60)return(b&c)|(b&d)|(c&d);return b^c^d;}function binb2hex(binarray)
{var hex_tab=params.hexcase?"0123456789ABCDEF":"0123456789abcdef";var str="";for(var i=0;i<binarray.length*4;i++)
{str+=hex_tab.charAt((binarray[i>>2]>>((3-i%4)*8+4))&0xF)+hex_tab.charAt((binarray[i>>2]>>((3-i%4)*8))&0xF);}return str;}function str2binb(str)
{var bin=Array();var mask=(1<<params.chrsz)-1;for(var i=0;i<str.length*params.chrsz;i+=params.chrsz)bin[i>>5]|=(str.charCodeAt(i/params.chrsz)&mask)<<(32-params.chrsz-i%32);return bin;}};function xteaenc(params){var v=new Array(2),k=new Array(4),s="",i;params.source=escape(params.source);for(var i=0;i<4;i++)k[i]=Str4ToLong(params.strKey.slice(i*4,(i+1)*4));for(i=0;i<params.source.length;i+=8){v[0]=Str4ToLong(params.source.slice(i,i+4));v[1]=Str4ToLong(params.source.slice(i+4,i+8));code(v,k);s+=LongToStr4(v[0])+LongToStr4(v[1]);}return escCtrlCh(s);function code(v,k){var y=v[0],z=v[1];var delta=0x9E3779B9,limit=delta*32,sum=0;while(sum!=limit){y+=(z<<4^z>>>5)+z^sum+k[sum&3];sum+=delta;z+=(y<<4^y>>>5)+y^sum+k[sum>>>11&3];}v[0]=y;v[1]=z;}};function xteadec(params){var v=new Array(2),k=new Array(4),s="",i;for(var i=0;i<4;i++)k[i]=Str4ToLong(params.strKey.slice(i*4,(i+1)*4));ciphertext=unescCtrlCh(params.source);for(i=0;i<ciphertext.length;i+=8){v[0]=Str4ToLong(ciphertext.slice(i,i+4));v[1]=Str4ToLong(ciphertext.slice(i+4,i+8));decode(v,k);s+=LongToStr4(v[0])+LongToStr4(v[1]);}s=s.replace(/\0+$/,'');return unescape(s);function decode(v,k){var y=v[0],z=v[1];var delta=0x9E3779B9,sum=delta*32;while(sum!=0){z-=(y<<4^y>>>5)+y^sum+k[sum>>>11&3];sum-=delta;y-=(z<<4^z>>>5)+z^sum+k[sum&3];}v[0]=y;v[1]=z;}};function Str4ToLong(s){var v=0;for(var i=0;i<4;i++)v|=s.charCodeAt(i)<<i*8;return isNaN(v)?0:v;};function LongToStr4(v){var s=String.fromCharCode(v&0xFF,v>>8&0xFF,v>>16&0xFF,v>>24&0xFF);return s;};function escCtrlCh(str){return str.replace(/[\0\t\n\v\f\r\xa0'"!]/g,function(c){return'!'+c.charCodeAt(0)+'!';});};function unescCtrlCh(str){return str.replace(/!\d\d?\d?!/g,function(c){return String.fromCharCode(c.slice(1,-1));});};};})(jQuery);
 
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

/*! fancyBox v2.1.4 fancyapps.com | fancyapps.com/fancybox/#license */
(function(C,z,f,r){var q=f(C),n=f(z),b=f.fancybox=function(){b.open.apply(this,arguments)},H=navigator.userAgent.match(/msie/),w=null,s=z.createTouch!==r,t=function(a){return a&&a.hasOwnProperty&&a instanceof f},p=function(a){return a&&"string"===f.type(a)},F=function(a){return p(a)&&0<a.indexOf("%")},l=function(a,d){var e=parseInt(a,10)||0;d&&F(a)&&(e*=b.getViewport()[d]/100);return Math.ceil(e)},x=function(a,b){return l(a,b)+"px"};f.extend(b,{version:"2.1.4",defaults:{padding:15,margin:20,width:800,
height:600,minWidth:100,minHeight:100,maxWidth:9999,maxHeight:9999,autoSize:!0,autoHeight:!1,autoWidth:!1,autoResize:!0,autoCenter:!s,fitToView:!0,aspectRatio:!1,topRatio:0.5,leftRatio:0.5,scrolling:"auto",wrapCSS:"",arrows:!0,closeBtn:!0,closeClick:!1,nextClick:!1,mouseWheel:!0,autoPlay:!1,playSpeed:3E3,preload:3,modal:!1,loop:!0,ajax:{dataType:"html",headers:{"X-fancyBox":!0}},iframe:{scrolling:"auto",preload:!0},swf:{wmode:"transparent",allowfullscreen:"true",allowscriptaccess:"always"},keys:{next:{13:"left",
34:"up",39:"left",40:"up"},prev:{8:"right",33:"down",37:"right",38:"down"},close:[27],play:[32],toggle:[70]},direction:{next:"left",prev:"right"},scrollOutside:!0,index:0,type:null,href:null,content:null,title:null,tpl:{wrap:'<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',image:'<img class="fancybox-image" src="{href}" alt="" />',iframe:'<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen'+
(H?' allowtransparency="true"':"")+"></iframe>",error:'<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',closeBtn:'<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',next:'<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',prev:'<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'},openEffect:"fade",openSpeed:250,openEasing:"swing",openOpacity:!0,
openMethod:"zoomIn",closeEffect:"fade",closeSpeed:250,closeEasing:"swing",closeOpacity:!0,closeMethod:"zoomOut",nextEffect:"elastic",nextSpeed:250,nextEasing:"swing",nextMethod:"changeIn",prevEffect:"elastic",prevSpeed:250,prevEasing:"swing",prevMethod:"changeOut",helpers:{overlay:!0,title:!0},onCancel:f.noop,beforeLoad:f.noop,afterLoad:f.noop,beforeShow:f.noop,afterShow:f.noop,beforeChange:f.noop,beforeClose:f.noop,afterClose:f.noop},group:{},opts:{},previous:null,coming:null,current:null,isActive:!1,
isOpen:!1,isOpened:!1,wrap:null,skin:null,outer:null,inner:null,player:{timer:null,isActive:!1},ajaxLoad:null,imgPreload:null,transitions:{},helpers:{},open:function(a,d){if(a&&(f.isPlainObject(d)||(d={}),!1!==b.close(!0)))return f.isArray(a)||(a=t(a)?f(a).get():[a]),f.each(a,function(e,c){var k={},g,h,j,m,l;"object"===f.type(c)&&(c.nodeType&&(c=f(c)),t(c)?(k={href:c.data("fancybox-href")||c.attr("href"),title:c.data("fancybox-title")||c.attr("title"),isDom:!0,element:c},f.metadata&&f.extend(!0,k,
c.metadata())):k=c);g=d.href||k.href||(p(c)?c:null);h=d.title!==r?d.title:k.title||"";m=(j=d.content||k.content)?"html":d.type||k.type;!m&&k.isDom&&(m=c.data("fancybox-type"),m||(m=(m=c.prop("class").match(/fancybox\.(\w+)/))?m[1]:null));p(g)&&(m||(b.isImage(g)?m="image":b.isSWF(g)?m="swf":"#"===g.charAt(0)?m="inline":p(c)&&(m="html",j=c)),"ajax"===m&&(l=g.split(/\s+/,2),g=l.shift(),l=l.shift()));j||("inline"===m?g?j=f(p(g)?g.replace(/.*(?=#[^\s]+$)/,""):g):k.isDom&&(j=c):"html"===m?j=g:!m&&(!g&&
k.isDom)&&(m="inline",j=c));f.extend(k,{href:g,type:m,content:j,title:h,selector:l});a[e]=k}),b.opts=f.extend(!0,{},b.defaults,d),d.keys!==r&&(b.opts.keys=d.keys?f.extend({},b.defaults.keys,d.keys):!1),b.group=a,b._start(b.opts.index)},cancel:function(){var a=b.coming;a&&!1!==b.trigger("onCancel")&&(b.hideLoading(),b.ajaxLoad&&b.ajaxLoad.abort(),b.ajaxLoad=null,b.imgPreload&&(b.imgPreload.onload=b.imgPreload.onerror=null),a.wrap&&a.wrap.stop(!0,!0).trigger("onReset").remove(),b.coming=null,b.current||
b._afterZoomOut(a))},close:function(a){b.cancel();!1!==b.trigger("beforeClose")&&(b.unbindEvents(),b.isActive&&(!b.isOpen||!0===a?(f(".fancybox-wrap").stop(!0).trigger("onReset").remove(),b._afterZoomOut()):(b.isOpen=b.isOpened=!1,b.isClosing=!0,f(".fancybox-item, .fancybox-nav").remove(),b.wrap.stop(!0,!0).removeClass("fancybox-opened"),b.transitions[b.current.closeMethod]())))},play:function(a){var d=function(){clearTimeout(b.player.timer)},e=function(){d();b.current&&b.player.isActive&&(b.player.timer=
setTimeout(b.next,b.current.playSpeed))},c=function(){d();f("body").unbind(".player");b.player.isActive=!1;b.trigger("onPlayEnd")};if(!0===a||!b.player.isActive&&!1!==a){if(b.current&&(b.current.loop||b.current.index<b.group.length-1))b.player.isActive=!0,f("body").bind({"afterShow.player onUpdate.player":e,"onCancel.player beforeClose.player":c,"beforeLoad.player":d}),e(),b.trigger("onPlayStart")}else c()},next:function(a){var d=b.current;d&&(p(a)||(a=d.direction.next),b.jumpto(d.index+1,a,"next"))},
prev:function(a){var d=b.current;d&&(p(a)||(a=d.direction.prev),b.jumpto(d.index-1,a,"prev"))},jumpto:function(a,d,e){var c=b.current;c&&(a=l(a),b.direction=d||c.direction[a>=c.index?"next":"prev"],b.router=e||"jumpto",c.loop&&(0>a&&(a=c.group.length+a%c.group.length),a%=c.group.length),c.group[a]!==r&&(b.cancel(),b._start(a)))},reposition:function(a,d){var e=b.current,c=e?e.wrap:null,k;c&&(k=b._getPosition(d),a&&"scroll"===a.type?(delete k.position,c.stop(!0,!0).animate(k,200)):(c.css(k),e.pos=f.extend({},
e.dim,k)))},update:function(a){var d=a&&a.type,e=!d||"orientationchange"===d;e&&(clearTimeout(w),w=null);b.isOpen&&!w&&(w=setTimeout(function(){var c=b.current;c&&!b.isClosing&&(b.wrap.removeClass("fancybox-tmp"),(e||"load"===d||"resize"===d&&c.autoResize)&&b._setDimension(),"scroll"===d&&c.canShrink||b.reposition(a),b.trigger("onUpdate"),w=null)},e&&!s?0:300))},toggle:function(a){b.isOpen&&(b.current.fitToView="boolean"===f.type(a)?a:!b.current.fitToView,s&&(b.wrap.removeAttr("style").addClass("fancybox-tmp"),
b.trigger("onUpdate")),b.update())},hideLoading:function(){n.unbind(".loading");f("#fancybox-loading").remove()},showLoading:function(){var a,d;b.hideLoading();a=f('<div id="fancybox-loading"><div></div></div>').click(b.cancel).appendTo("body");n.bind("keydown.loading",function(a){if(27===(a.which||a.keyCode))a.preventDefault(),b.cancel()});b.defaults.fixed||(d=b.getViewport(),a.css({position:"absolute",top:0.5*d.h+d.y,left:0.5*d.w+d.x}))},getViewport:function(){var a=b.current&&b.current.locked||
!1,d={x:q.scrollLeft(),y:q.scrollTop()};a?(d.w=a[0].clientWidth,d.h=a[0].clientHeight):(d.w=s&&C.innerWidth?C.innerWidth:q.width(),d.h=s&&C.innerHeight?C.innerHeight:q.height());return d},unbindEvents:function(){b.wrap&&t(b.wrap)&&b.wrap.unbind(".fb");n.unbind(".fb");q.unbind(".fb")},bindEvents:function(){var a=b.current,d;a&&(q.bind("orientationchange.fb"+(s?"":" resize.fb")+(a.autoCenter&&!a.locked?" scroll.fb":""),b.update),(d=a.keys)&&n.bind("keydown.fb",function(e){var c=e.which||e.keyCode,k=
e.target||e.srcElement;if(27===c&&b.coming)return!1;!e.ctrlKey&&(!e.altKey&&!e.shiftKey&&!e.metaKey&&(!k||!k.type&&!f(k).is("[contenteditable]")))&&f.each(d,function(d,k){if(1<a.group.length&&k[c]!==r)return b[d](k[c]),e.preventDefault(),!1;if(-1<f.inArray(c,k))return b[d](),e.preventDefault(),!1})}),f.fn.mousewheel&&a.mouseWheel&&b.wrap.bind("mousewheel.fb",function(d,c,k,g){for(var h=f(d.target||null),j=!1;h.length&&!j&&!h.is(".fancybox-skin")&&!h.is(".fancybox-wrap");)j=h[0]&&!(h[0].style.overflow&&
"hidden"===h[0].style.overflow)&&(h[0].clientWidth&&h[0].scrollWidth>h[0].clientWidth||h[0].clientHeight&&h[0].scrollHeight>h[0].clientHeight),h=f(h).parent();if(0!==c&&!j&&1<b.group.length&&!a.canShrink){if(0<g||0<k)b.prev(0<g?"down":"left");else if(0>g||0>k)b.next(0>g?"up":"right");d.preventDefault()}}))},trigger:function(a,d){var e,c=d||b.coming||b.current;if(c){f.isFunction(c[a])&&(e=c[a].apply(c,Array.prototype.slice.call(arguments,1)));if(!1===e)return!1;c.helpers&&f.each(c.helpers,function(d,
e){e&&(b.helpers[d]&&f.isFunction(b.helpers[d][a]))&&(e=f.extend(!0,{},b.helpers[d].defaults,e),b.helpers[d][a](e,c))});f.event.trigger(a+".fb")}},isImage:function(a){return p(a)&&a.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp)((\?|#).*)?$)/i)},isSWF:function(a){return p(a)&&a.match(/\.(swf)((\?|#).*)?$/i)},_start:function(a){var d={},e,c;a=l(a);e=b.group[a]||null;if(!e)return!1;d=f.extend(!0,{},b.opts,e);e=d.margin;c=d.padding;"number"===f.type(e)&&(d.margin=[e,e,e,e]);"number"===f.type(c)&&
(d.padding=[c,c,c,c]);d.modal&&f.extend(!0,d,{closeBtn:!1,closeClick:!1,nextClick:!1,arrows:!1,mouseWheel:!1,keys:null,helpers:{overlay:{closeClick:!1}}});d.autoSize&&(d.autoWidth=d.autoHeight=!0);"auto"===d.width&&(d.autoWidth=!0);"auto"===d.height&&(d.autoHeight=!0);d.group=b.group;d.index=a;b.coming=d;if(!1===b.trigger("beforeLoad"))b.coming=null;else{c=d.type;e=d.href;if(!c)return b.coming=null,b.current&&b.router&&"jumpto"!==b.router?(b.current.index=a,b[b.router](b.direction)):!1;b.isActive=
!0;if("image"===c||"swf"===c)d.autoHeight=d.autoWidth=!1,d.scrolling="visible";"image"===c&&(d.aspectRatio=!0);"iframe"===c&&s&&(d.scrolling="scroll");d.wrap=f(d.tpl.wrap).addClass("fancybox-"+(s?"mobile":"desktop")+" fancybox-type-"+c+" fancybox-tmp "+d.wrapCSS).appendTo(d.parent||"body");f.extend(d,{skin:f(".fancybox-skin",d.wrap),outer:f(".fancybox-outer",d.wrap),inner:f(".fancybox-inner",d.wrap)});f.each(["Top","Right","Bottom","Left"],function(a,b){d.skin.css("padding"+b,x(d.padding[a]))});b.trigger("onReady");
if("inline"===c||"html"===c){if(!d.content||!d.content.length)return b._error("content")}else if(!e)return b._error("href");"image"===c?b._loadImage():"ajax"===c?b._loadAjax():"iframe"===c?b._loadIframe():b._afterLoad()}},_error:function(a){f.extend(b.coming,{type:"html",autoWidth:!0,autoHeight:!0,minWidth:0,minHeight:0,scrolling:"no",hasError:a,content:b.coming.tpl.error});b._afterLoad()},_loadImage:function(){var a=b.imgPreload=new Image;a.onload=function(){this.onload=this.onerror=null;b.coming.width=
this.width;b.coming.height=this.height;b._afterLoad()};a.onerror=function(){this.onload=this.onerror=null;b._error("image")};a.src=b.coming.href;!0!==a.complete&&b.showLoading()},_loadAjax:function(){var a=b.coming;b.showLoading();b.ajaxLoad=f.ajax(f.extend({},a.ajax,{url:a.href,error:function(a,e){b.coming&&"abort"!==e?b._error("ajax",a):b.hideLoading()},success:function(d,e){"success"===e&&(a.content=d,b._afterLoad())}}))},_loadIframe:function(){var a=b.coming,d=f(a.tpl.iframe.replace(/\{rnd\}/g,
(new Date).getTime())).attr("scrolling",s?"auto":a.iframe.scrolling).attr("src",a.href);f(a.wrap).bind("onReset",function(){try{f(this).find("iframe").hide().attr("src","//about:blank").end().empty()}catch(a){}});a.iframe.preload&&(b.showLoading(),d.one("load",function(){f(this).data("ready",1);s||f(this).bind("load.fb",b.update);f(this).parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show();b._afterLoad()}));a.content=d.appendTo(a.inner);a.iframe.preload||b._afterLoad()},_preloadImages:function(){var a=
b.group,d=b.current,e=a.length,c=d.preload?Math.min(d.preload,e-1):0,f,g;for(g=1;g<=c;g+=1)f=a[(d.index+g)%e],"image"===f.type&&f.href&&((new Image).src=f.href)},_afterLoad:function(){var a=b.coming,d=b.current,e,c,k,g,h;b.hideLoading();if(a&&!1!==b.isActive)if(!1===b.trigger("afterLoad",a,d))a.wrap.stop(!0).trigger("onReset").remove(),b.coming=null;else{d&&(b.trigger("beforeChange",d),d.wrap.stop(!0).removeClass("fancybox-opened").find(".fancybox-item, .fancybox-nav").remove());b.unbindEvents();
e=a.content;c=a.type;k=a.scrolling;f.extend(b,{wrap:a.wrap,skin:a.skin,outer:a.outer,inner:a.inner,current:a,previous:d});g=a.href;switch(c){case "inline":case "ajax":case "html":a.selector?e=f("<div>").html(e).find(a.selector):t(e)&&(e.data("fancybox-placeholder")||e.data("fancybox-placeholder",f('<div class="fancybox-placeholder"></div>').insertAfter(e).hide()),e=e.show().detach(),a.wrap.bind("onReset",function(){f(this).find(e).length&&e.hide().replaceAll(e.data("fancybox-placeholder")).data("fancybox-placeholder",
!1)}));break;case "image":e=a.tpl.image.replace("{href}",g);break;case "swf":e='<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="'+g+'"></param>',h="",f.each(a.swf,function(a,b){e+='<param name="'+a+'" value="'+b+'"></param>';h+=" "+a+'="'+b+'"'}),e+='<embed src="'+g+'" type="application/x-shockwave-flash" width="100%" height="100%"'+h+"></embed></object>"}(!t(e)||!e.parent().is(a.inner))&&a.inner.append(e);b.trigger("beforeShow");
a.inner.css("overflow","yes"===k?"scroll":"no"===k?"hidden":k);b._setDimension();b.reposition();b.isOpen=!1;b.coming=null;b.bindEvents();if(b.isOpened){if(d.prevMethod)b.transitions[d.prevMethod]()}else f(".fancybox-wrap").not(a.wrap).stop(!0).trigger("onReset").remove();b.transitions[b.isOpened?a.nextMethod:a.openMethod]();b._preloadImages()}},_setDimension:function(){var a=b.getViewport(),d=0,e=!1,c=!1,e=b.wrap,k=b.skin,g=b.inner,h=b.current,c=h.width,j=h.height,m=h.minWidth,u=h.minHeight,n=h.maxWidth,
v=h.maxHeight,s=h.scrolling,q=h.scrollOutside?h.scrollbarWidth:0,y=h.margin,p=l(y[1]+y[3]),r=l(y[0]+y[2]),z,A,t,D,B,G,C,E,w;e.add(k).add(g).width("auto").height("auto").removeClass("fancybox-tmp");y=l(k.outerWidth(!0)-k.width());z=l(k.outerHeight(!0)-k.height());A=p+y;t=r+z;D=F(c)?(a.w-A)*l(c)/100:c;B=F(j)?(a.h-t)*l(j)/100:j;if("iframe"===h.type){if(w=h.content,h.autoHeight&&1===w.data("ready"))try{w[0].contentWindow.document.location&&(g.width(D).height(9999),G=w.contents().find("body"),q&&G.css("overflow-x",
"hidden"),B=G.height())}catch(H){}}else if(h.autoWidth||h.autoHeight)g.addClass("fancybox-tmp"),h.autoWidth||g.width(D),h.autoHeight||g.height(B),h.autoWidth&&(D=g.width()),h.autoHeight&&(B=g.height()),g.removeClass("fancybox-tmp");c=l(D);j=l(B);E=D/B;m=l(F(m)?l(m,"w")-A:m);n=l(F(n)?l(n,"w")-A:n);u=l(F(u)?l(u,"h")-t:u);v=l(F(v)?l(v,"h")-t:v);G=n;C=v;h.fitToView&&(n=Math.min(a.w-A,n),v=Math.min(a.h-t,v));A=a.w-p;r=a.h-r;h.aspectRatio?(c>n&&(c=n,j=l(c/E)),j>v&&(j=v,c=l(j*E)),c<m&&(c=m,j=l(c/E)),j<u&&
(j=u,c=l(j*E))):(c=Math.max(m,Math.min(c,n)),h.autoHeight&&"iframe"!==h.type&&(g.width(c),j=g.height()),j=Math.max(u,Math.min(j,v)));if(h.fitToView)if(g.width(c).height(j),e.width(c+y),a=e.width(),p=e.height(),h.aspectRatio)for(;(a>A||p>r)&&(c>m&&j>u)&&!(19<d++);)j=Math.max(u,Math.min(v,j-10)),c=l(j*E),c<m&&(c=m,j=l(c/E)),c>n&&(c=n,j=l(c/E)),g.width(c).height(j),e.width(c+y),a=e.width(),p=e.height();else c=Math.max(m,Math.min(c,c-(a-A))),j=Math.max(u,Math.min(j,j-(p-r)));q&&("auto"===s&&j<B&&c+y+
q<A)&&(c+=q);g.width(c).height(j);e.width(c+y);a=e.width();p=e.height();e=(a>A||p>r)&&c>m&&j>u;c=h.aspectRatio?c<G&&j<C&&c<D&&j<B:(c<G||j<C)&&(c<D||j<B);f.extend(h,{dim:{width:x(a),height:x(p)},origWidth:D,origHeight:B,canShrink:e,canExpand:c,wPadding:y,hPadding:z,wrapSpace:p-k.outerHeight(!0),skinSpace:k.height()-j});!w&&(h.autoHeight&&j>u&&j<v&&!c)&&g.height("auto")},_getPosition:function(a){var d=b.current,e=b.getViewport(),c=d.margin,f=b.wrap.width()+c[1]+c[3],g=b.wrap.height()+c[0]+c[2],c={position:"absolute",
top:c[0],left:c[3]};d.autoCenter&&d.fixed&&!a&&g<=e.h&&f<=e.w?c.position="fixed":d.locked||(c.top+=e.y,c.left+=e.x);c.top=x(Math.max(c.top,c.top+(e.h-g)*d.topRatio));c.left=x(Math.max(c.left,c.left+(e.w-f)*d.leftRatio));return c},_afterZoomIn:function(){var a=b.current;a&&(b.isOpen=b.isOpened=!0,b.wrap.css("overflow","visible").addClass("fancybox-opened"),b.update(),(a.closeClick||a.nextClick&&1<b.group.length)&&b.inner.css("cursor","pointer").bind("click.fb",function(d){!f(d.target).is("a")&&!f(d.target).parent().is("a")&&
(d.preventDefault(),b[a.closeClick?"close":"next"]())}),a.closeBtn&&f(a.tpl.closeBtn).appendTo(b.skin).bind("click.fb",function(a){a.preventDefault();b.close()}),a.arrows&&1<b.group.length&&((a.loop||0<a.index)&&f(a.tpl.prev).appendTo(b.outer).bind("click.fb",b.prev),(a.loop||a.index<b.group.length-1)&&f(a.tpl.next).appendTo(b.outer).bind("click.fb",b.next)),b.trigger("afterShow"),!a.loop&&a.index===a.group.length-1?b.play(!1):b.opts.autoPlay&&!b.player.isActive&&(b.opts.autoPlay=!1,b.play()))},_afterZoomOut:function(a){a=
a||b.current;f(".fancybox-wrap").trigger("onReset").remove();f.extend(b,{group:{},opts:{},router:!1,current:null,isActive:!1,isOpened:!1,isOpen:!1,isClosing:!1,wrap:null,skin:null,outer:null,inner:null});b.trigger("afterClose",a)}});b.transitions={getOrigPosition:function(){var a=b.current,d=a.element,e=a.orig,c={},f=50,g=50,h=a.hPadding,j=a.wPadding,m=b.getViewport();!e&&(a.isDom&&d.is(":visible"))&&(e=d.find("img:first"),e.length||(e=d));t(e)?(c=e.offset(),e.is("img")&&(f=e.outerWidth(),g=e.outerHeight())):
(c.top=m.y+(m.h-g)*a.topRatio,c.left=m.x+(m.w-f)*a.leftRatio);if("fixed"===b.wrap.css("position")||a.locked)c.top-=m.y,c.left-=m.x;return c={top:x(c.top-h*a.topRatio),left:x(c.left-j*a.leftRatio),width:x(f+j),height:x(g+h)}},step:function(a,d){var e,c,f=d.prop;c=b.current;var g=c.wrapSpace,h=c.skinSpace;if("width"===f||"height"===f)e=d.end===d.start?1:(a-d.start)/(d.end-d.start),b.isClosing&&(e=1-e),c="width"===f?c.wPadding:c.hPadding,c=a-c,b.skin[f](l("width"===f?c:c-g*e)),b.inner[f](l("width"===
f?c:c-g*e-h*e))},zoomIn:function(){var a=b.current,d=a.pos,e=a.openEffect,c="elastic"===e,k=f.extend({opacity:1},d);delete k.position;c?(d=this.getOrigPosition(),a.openOpacity&&(d.opacity=0.1)):"fade"===e&&(d.opacity=0.1);b.wrap.css(d).animate(k,{duration:"none"===e?0:a.openSpeed,easing:a.openEasing,step:c?this.step:null,complete:b._afterZoomIn})},zoomOut:function(){var a=b.current,d=a.closeEffect,e="elastic"===d,c={opacity:0.1};e&&(c=this.getOrigPosition(),a.closeOpacity&&(c.opacity=0.1));b.wrap.animate(c,
{duration:"none"===d?0:a.closeSpeed,easing:a.closeEasing,step:e?this.step:null,complete:b._afterZoomOut})},changeIn:function(){var a=b.current,d=a.nextEffect,e=a.pos,c={opacity:1},f=b.direction,g;e.opacity=0.1;"elastic"===d&&(g="down"===f||"up"===f?"top":"left","down"===f||"right"===f?(e[g]=x(l(e[g])-200),c[g]="+=200px"):(e[g]=x(l(e[g])+200),c[g]="-=200px"));"none"===d?b._afterZoomIn():b.wrap.css(e).animate(c,{duration:a.nextSpeed,easing:a.nextEasing,complete:b._afterZoomIn})},changeOut:function(){var a=
b.previous,d=a.prevEffect,e={opacity:0.1},c=b.direction;"elastic"===d&&(e["down"===c||"up"===c?"top":"left"]=("up"===c||"left"===c?"-":"+")+"=200px");a.wrap.animate(e,{duration:"none"===d?0:a.prevSpeed,easing:a.prevEasing,complete:function(){f(this).trigger("onReset").remove()}})}};b.helpers.overlay={defaults:{closeClick:!0,speedOut:200,showEarly:!0,css:{},locked:!s,fixed:!0},overlay:null,fixed:!1,create:function(a){a=f.extend({},this.defaults,a);this.overlay&&this.close();this.overlay=f('<div class="fancybox-overlay"></div>').appendTo("body");
this.fixed=!1;a.fixed&&b.defaults.fixed&&(this.overlay.addClass("fancybox-overlay-fixed"),this.fixed=!0)},open:function(a){var d=this;a=f.extend({},this.defaults,a);this.overlay?this.overlay.unbind(".overlay").width("auto").height("auto"):this.create(a);this.fixed||(q.bind("resize.overlay",f.proxy(this.update,this)),this.update());a.closeClick&&this.overlay.bind("click.overlay",function(a){f(a.target).hasClass("fancybox-overlay")&&(b.isActive?b.close():d.close())});this.overlay.css(a.css).show()},
close:function(){f(".fancybox-overlay").remove();q.unbind("resize.overlay");this.overlay=null;!1!==this.margin&&(f("body").css("margin-right",this.margin),this.margin=!1);this.el&&this.el.removeClass("fancybox-lock")},update:function(){var a="100%",b;this.overlay.width(a).height("100%");H?(b=Math.max(z.documentElement.offsetWidth,z.body.offsetWidth),n.width()>b&&(a=n.width())):n.width()>q.width()&&(a=n.width());this.overlay.width(a).height(n.height())},onReady:function(a,b){f(".fancybox-overlay").stop(!0,
!0);this.overlay||(this.margin=n.height()>q.height()||"scroll"===f("body").css("overflow-y")?f("body").css("margin-right"):!1,this.el=z.all&&!z.querySelector?f("html"):f("body"),this.create(a));a.locked&&this.fixed&&(b.locked=this.overlay.append(b.wrap),b.fixed=!1);!0===a.showEarly&&this.beforeShow.apply(this,arguments)},beforeShow:function(a,b){b.locked&&(this.el.addClass("fancybox-lock"),!1!==this.margin&&f("body").css("margin-right",l(this.margin)+b.scrollbarWidth));this.open(a)},onUpdate:function(){this.fixed||
this.update()},afterClose:function(a){this.overlay&&!b.isActive&&this.overlay.fadeOut(a.speedOut,f.proxy(this.close,this))}};b.helpers.title={defaults:{type:"float",position:"bottom"},beforeShow:function(a){var d=b.current,e=d.title,c=a.type;f.isFunction(e)&&(e=e.call(d.element,d));if(p(e)&&""!==f.trim(e)){d=f('<div class="fancybox-title fancybox-title-'+c+'-wrap">'+e+"</div>");switch(c){case "inside":c=b.skin;break;case "outside":c=b.wrap;break;case "over":c=b.inner;break;default:c=b.skin,d.appendTo("body"),
H&&d.width(d.width()),d.wrapInner('<span class="child"></span>'),b.current.margin[2]+=Math.abs(l(d.css("margin-bottom")))}d["top"===a.position?"prependTo":"appendTo"](c)}}};f.fn.fancybox=function(a){var d,e=f(this),c=this.selector||"",k=function(g){var h=f(this).blur(),j=d,k,l;!g.ctrlKey&&(!g.altKey&&!g.shiftKey&&!g.metaKey)&&!h.is(".fancybox-wrap")&&(k=a.groupAttr||"data-fancybox-group",l=h.attr(k),l||(k="rel",l=h.get(0)[k]),l&&(""!==l&&"nofollow"!==l)&&(h=c.length?f(c):e,h=h.filter("["+k+'="'+l+
'"]'),j=h.index(this)),a.index=j,!1!==b.open(h,a)&&g.preventDefault())};a=a||{};d=a.index||0;!c||!1===a.live?e.unbind("click.fb-start").bind("click.fb-start",k):n.undelegate(c,"click.fb-start").delegate(c+":not('.fancybox-item, .fancybox-nav')","click.fb-start",k);this.filter("[data-fancybox-start=1]").trigger("click");return this};n.ready(function(){f.scrollbarWidth===r&&(f.scrollbarWidth=function(){var a=f('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo("body"),b=a.children(),
b=b.innerWidth()-b.height(99).innerWidth();a.remove();return b});if(f.support.fixedPosition===r){var a=f.support,d=f('<div style="position:fixed;top:20px;"></div>').appendTo("body"),e=20===d[0].offsetTop||15===d[0].offsetTop;d.remove();a.fixedPosition=e}f.extend(b.defaults,{scrollbarWidth:f.scrollbarWidth(),fixed:f.support.fixedPosition,parent:f("body")})})})(window,document,jQuery);

/* Copyright (c) 2006 Brandon Aaron (http://brandonaaron.net)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * $LastChangedDate: 2007-07-21 18:45:56 -0500 (Sat, 21 Jul 2007) $
 * $Rev: 2447 $
 *
 * Version 2.1.1
 */
(function($) {
	$.fn.bgIframe = $.fn.bgiframe = function(s) {
		if (navigator.userAgent.indexOf('MSIE') > -1 && /6.0/.test(navigator.userAgent)) {
			s = $.extend({
				top: 'auto',
				left: 'auto',
				width: 'auto',
				height: 'auto',
				opacity: true,
				src: 'javascript:false;'
			}, s || {});
			var prop = function(n) {
				return n && n.constructor == Number ? n + 'px' : n;
			},
				html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="' + s.src + '"' + 'style="display:block;position:absolute;z-index:-1;' + (s.opacity !== false ? 'filter:Alpha(Opacity=\'0\');' : '') + 'top:' + (s.top == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')' : prop(s.top)) + ';' + 'left:' + (s.left == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')' : prop(s.left)) + ';' + 'width:' + (s.width == 'auto' ? 'expression(this.parentNode.offsetWidth+\'px\')' : prop(s.width)) + ';' + 'height:' + (s.height == 'auto' ? 'expression(this.parentNode.offsetHeight+\'px\')' : prop(s.height)) + ';' + '"/>';
			return this.each(function() {
				if ($('> iframe.bgiframe', this).length == 0) this.insertBefore(document.createElement(html), this.firstChild);
			});
		}
		return this;
	};
})(jQuery);
(function(a) {
	var c = (navigator.userAgent.indexOf('MSIE') > -1 ? "paste" : "input") + ".mask";
	var b = (window.orientation != undefined);
	a.mask = {
		definitions: {
			"9": "[0-9]",
			a: "[A-Za-z]",
			"*": "[A-Za-z0-9]"
		}
	};
	a.fn.extend({
		caret: function(e, f) {
			if (this.length == 0) {
				return
			}
			if (typeof e == "number") {
				f = (typeof f == "number") ? f : e;
				return this.each(function() {
					if (this.setSelectionRange) {
						this.focus();
						this.setSelectionRange(e, f)
					} else {
						if (this.createTextRange) {
							var g = this.createTextRange();
							g.collapse(true);
							g.moveEnd("character", f);
							g.moveStart("character", e);
							g.select()
						}
					}
				})
			} else {
				if (this[0].setSelectionRange) {
					e = this[0].selectionStart;
					f = this[0].selectionEnd
				} else {
					if (document.selection && document.selection.createRange) {
						var d = document.selection.createRange();
						e = 0 - d.duplicate().moveStart("character", -100000);
						f = e + d.text.length
					}
				}
				return {
					begin: e,
					end: f
				}
			}
		},
		unmask: function() {
			return this.trigger("unmask")
		},
		mask: function(j, d) {
			if (!j && this.length > 0) {
				var f = a(this[0]);
				var g = f.data("tests");
				return a.map(f.data("buffer"), function(l, m) {
					return g[m] ? l : null
				}).join("")
			}
			d = a.extend({
				placeholder: "_",
				completed: null
			}, d);
			var k = a.mask.definitions;
			var g = [];
			var e = j.length;
			var i = null;
			var h = j.length;
			a.each(j.split(""), function(m, l) {
				if (l == "?") {
					h--;
					e = m
				} else {
					if (k[l]) {
						g.push(new RegExp(k[l]));
						if (i == null) {
							i = g.length - 1
						}
					} else {
						g.push(null)
					}
				}
			});
			return this.each(function() {
				var r = a(this);
				var m = a.map(j.split(""), function(x, y) {
					if (x != "?") {
						return k[x] ? d.placeholder : x
					}
				});
				var n = false;
				var q = r.val();
				r.data("buffer", m).data("tests", g);
				function v(x) {
					while (++x <= h && !g[x]) {}
					return x
				}
				function t(x) {
					while (!g[x] && --x >= 0) {}
					for (var y = x; y < h; y++) {
						if (g[y]) {
							m[y] = d.placeholder;
							var z = v(y);
							if (z < h && g[y].test(m[z])) {
								m[y] = m[z]
							} else {
								break
							}
						}
					}
					s();
					r.caret(Math.max(i, x))
				}
				function u(y) {
					for (var A = y, z = d.placeholder; A < h; A++) {
						if (g[A]) {
							var B = v(A);
							var x = m[A];
							m[A] = z;
							if (B < h && g[B].test(x)) {
								z = x
							} else {
								break
							}
						}
					}
				}
				function l(y) {
					var x = a(this).caret();
					var z = y.keyCode;
					n = (z < 16 || (z > 16 && z < 32) || (z > 32 && z < 41));
					if ((x.begin - x.end) != 0 && (!n || z == 8 || z == 46)) {
						w(x.begin, x.end)
					}
					if (z == 8 || z == 46 || (b && z == 127)) {
						t(x.begin + (z == 46 ? 0 : -1));
						return false
					} else {
						if (z == 27) {
							r.val(q);
							r.caret(0, p());
							return false
						}
					}
				}
				function o(B) {
					if (n) {
						n = false;
						return (B.keyCode == 8) ? false : null
					}
					B = B || window.event;
					var C = B.charCode || B.keyCode || B.which;
					var z = a(this).caret();
					if (B.ctrlKey || B.altKey || B.metaKey) {
						return true
					} else {
						if ((C >= 32 && C <= 125) || C > 186) {
							var x = v(z.begin - 1);
							if (x < h) {
								var A = String.fromCharCode(C);
								if (g[x].test(A)) {
									u(x);
									m[x] = A;
									s();
									var y = v(x);
									a(this).caret(y);
									if (d.completed && y == h) {
										d.completed.call(r)
									}
								}
							}
						}
					}
					return false
				}
				function w(x, y) {
					for (var z = x; z < y && z < h; z++) {
						if (g[z]) {
							m[z] = d.placeholder
						}
					}
				}
				function s() {
					return r.val(m.join("")).val()
				}
				function p(y) {
					var z = r.val();
					var C = -1;
					for (var B = 0, x = 0; B < h; B++) {
						if (g[B]) {
							m[B] = d.placeholder;
							while (x++ < z.length) {
								var A = z.charAt(x - 1);
								if (g[B].test(A)) {
									m[B] = A;
									C = B;
									break
								}
							}
							if (x > z.length) {
								break
							}
						} else {
							if (m[B] == z[x] && B != e) {
								x++;
								C = B
							}
						}
					}
					if (!y && C + 1 < e) {
						r.val("");
						w(0, h)
					} else {
						if (y || C + 1 >= e) {
							s();
							if (!y) {
								r.val(r.val().substring(0, C + 1))
							}
						}
					}
					return (e ? B : i)
				}
				if (!r.attr("readonly")) {
					r.one("unmask", function() {
						r.unbind(".mask").removeData("buffer").removeData("tests")
					}).bind("focus.mask", function() {
						q = r.val();
						var x = p();
						s();
						setTimeout(function() {
							if (x == j.length) {
								r.caret(0, x)
							} else {
								r.caret(x)
							}
						}, 0)
					}).bind("blur.mask", function() {
						p();
						if (r.val() != q) {
							r.change()
						}
					}).bind("keydown.mask", l).bind("keypress.mask", o).bind(c, function() {
						setTimeout(function() {
							r.caret(p(true))
						}, 0)
					})
				}
				p()
			})
		}
	})
})(jQuery);


//colResizable - by Alvaro Prieto Lauroba - MIT & GPL
(function(d) {
	var A = d(document),
		v = "<style type='text/css'>",
		u = "}</style>",
		f = "position",
		o = ":absolute;",
		k = "append",
		E = d("head")[k](v + ".CRZ{table-layout:fixed}.CRZ td,.CRZ th{overflow:hidden}.CRC{height:0px;" + f + ":relative}.CRG{margin-left:-5px;" + f + o + " z-index:5}.CRG .CRZ{" + f + o + "background-color:red;filter:alpha(opacity=1);opacity:0;width:10px;cursor:e-resize;height:100%}.CRL{" + f + o + "width:1px}.CRD{border-left:1px dotted black" + u),
		q = null,
		a = q,
		e = [],
		L = 0,
		n = "id",
		m = "px",
		c = "CRZ",
		B = parseInt,
		p = Math,
		C = navigator.userAgent.indexOf('MSIE') > -1,
		g = false,
		s = "mousemove.",
		t = "mouseup.",
		x = "tr:first ",
		b = "width",
		r = "border-",
		w = "table",
		y = '<div class="CR',
		h = "removeClass",
		i = "addClass",
		j = "attr";
	function H(f, k) {
		var a = d(f),
			h = a[j](n) || c + g++,
			g = "currentStyle";
		if (k.disable) return K(a);
		if (!a.is(w) || e[h]) return;
		a[i](c)[j](n, h).before(y + 'C"/>');
		a.o = k;
		a.g = [];
		a.c = [];
		a.w = a[b]();
		a.d = a.prev();
		a.s = B(C ? f.cellSpacing || f[g].borderSpacing : a.css(r + "spacing")) || 2;
		a.b = B(C ? f.border || f[g].borderLeftWidth : a.css(r + "left-" + b)) || 1;
		e[h] = a;
		D(a)
	}
	function K(a) {
		var b = a[j](n),
			a = e[b];
		if (!a || !a.is(w)) return;
		a[h](c).d.remove();
		delete e[b]
	}
	function D(a) {
		var e = a.find(x + "th"),
			f = "removeAttr";
		if (!e.length) e = a.find(x + "td");
		a.l = e.length;
		e.each(function(l) {
			var g = d(this),
				e = d(a.d[k](y + 'G"></div>')[0].lastChild);
			e.t = a;
			e.i = l;
			e.c = g;
			g.w = g[b]();
			a.g.push(e);
			a.c.push(g);
			g[b](g.w)[f](b);
			if (l < a.l - 1) e.mousedown(J).html('<div class="' + c + '"></div>')[k](a.o.gripInnerHtml);
			else e[i]("CRL")[h]("CRG");
			e.data(c, {
				i: l,
				t: a[j](n)
			})
		});
		l(a);
		a.find("tr:not(:first)").find("td,th").each(function() {
			d(this)[f](b)
		})
	}
	function l(a) {
		a.d[b](a.w);
		for (var d, c = 0; c < a.l; c++) {
			d = a.c[c];
			a.g[c].css({
				left: d.offset().left - a.offset().left + d.outerWidth() + a.s / 2 + m,
				height: a.outerHeight()
			})
		}
	}
	function z(g, f, j) {
		var e = a.x - a.l,
			d = g.c[f],
			c = g.c[f + 1],
			h = d.w + e,
			i = c.w - e;
		d[b](h + m);
		c[b](i + m);
		if (j) {
			d.w = h;
			c.w = i
		}
	}
	function F(i) {
		if (!a) return;
		var b = a.t,
			d = i.pageX - a.L + a.l,
			e = 20,
			c = a.i,
			h = b.s * 1.5 + e + b.b,
			j = c == b.l - 1 ? b.w - h : b.g[c + 1][f]().left - b.s - e,
			k = c ? b.g[c - 1][f]().left + b.s + e : h;
		d = p.max(k, p.min(j, d));
		a.x = d;
		a.css("left", d + m);
		if (b.o.liveDrag) {
			z(b, c);
			l(b)
		}
		return g
	}
	function G(f) {
		A.unbind(s + c).unbind(t + c);
		d("head :last-child").remove();
		if (!a) return;
		var b = a[h](a.t.o.draggingClass).t,
			e = b.o.onResize;
		if (a.x) {
			z(b, a.i, 1);
			l(b);
			if (e) {
				f.currentTarget = b[0];
				e(f)
			}
		}
		a = q
	}
	function J(o) {
		var n = d(this).data(c),
			j = e[n.t],
			h = j.g[n.i],
			m = 0,
			l;
		h.L = o.pageX;
		h.l = h[f]().left;
		A.bind(s + c, F).bind(t + c, G);
		E[k](v + "*{cursor:e-resize!important" + u);
		h[i](j.o.draggingClass);
		a = h;
		if (j.c[n.i].l) for (; m < j.l; m++) {
			l = j.c[m];
			l.l = g;
			l.w = l[b]()
		}
		return g
	}
	function I() {
		for (a in e) {
			var a = e[a],
				d = 0,
				f = 0;
			a[h](c);
			if (a.w != a[b]()) {
				a.w = a[b]();
				for (; d < a.l; d++) f += a.c[d].w;
				for (d = 0; d < a.l; d++) a.c[d].css(b, p.round(1e3 * a.c[d].w / f) / 10 + "%").l = 1
			}
			l(a[i](c))
		}
	}
	d(window).bind("resize." + c, I);
	d.fn.extend({
		colResizable: function(a) {
			var b = {
				draggingClass: "CRD",
				gripInnerHtml: "",
				onResize: q,
				liveDrag: g,
				disable: g
			},
				a = d.extend(b, a);
			return this.each(function() {
				H(this, a)
			})
		}
	})
})(jQuery);
/*

Style HTML
---------------

Written by Nochum Sossonko, (nsossonko@hotmail.com)

Based on code initially developed by: Einar Lielmanis, <elfz@laacz.lv>
http://jsbeautifier.org/


You are free to use this in any way you want, in case you find this useful or working for you.

Usage:
style_html(html_source);

style_html(html_source, options);

The options are:
indent_size (default 4) � indentation size,
indent_char (default space) � character to indent with,
max_char (default 70) - maximum amount of characters per line,
brace_style (default "collapse") - "collapse" | "expand" | "end-expand"
put braces on the same line as control statements (default), or put braces on own line (Allman / ANSI style), or just put end braces on own line.
unformatted (defaults to inline tags) - list of tags, that shouldn't be reformatted
indent_scripts (default normal) - "keep"|"separate"|"normal"

e.g.

style_html(html_source, {
'indent_size': 2,
'indent_char': ' ',
'max_char': 78,
'brace_style': 'expand',
'unformatted': ['a', 'sub', 'sup', 'b', 'i', 'u']
});
*/

function style_html(html_source, options) {
	//Wrapper function to invoke all the necessary constructors and deal with the output.
	var multi_parser, indent_size, indent_character, max_char, brace_style, unformatted;
	options = options || {};
	indent_size = options.indent_size || 4;
	indent_character = options.indent_char || ' ';
	brace_style = options.brace_style || 'collapse';
	max_char = options.max_char == 0 ? Infinity : options.max_char || 70;
	unformatted = options.unformatted || ['a', 'span', 'bdo', 'em', 'strong', 'dfn', 'code', 'samp', 'kbd', 'var', 'cite', 'abbr', 'acronym', 'q', 'sub', 'sup', 'tt', 'i', 'b', 'big', 'small', 'u', 's', 'strike', 'font', 'ins', 'del', 'pre', 'address', 'dt', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

	function Parser() {
		this.pos = 0; //Parser position
		this.token = '';
		this.current_mode = 'CONTENT'; //reflects the current Parser mode: TAG/CONTENT
		this.tags = { //An object to hold tags, their position, and their parent-tags, initiated with default values
			parent: 'parent1',
			parentcount: 1,
			parent1: ''
		};
		this.tag_type = '';
		this.token_text = this.last_token = this.last_text = this.token_type = '';
		this.Utils = { //Uilities made available to the various functions
			whitespace: "\n\r\t ".split(''),
			single_token: 'br,input,link,meta,!doctype,basefont,base,area,hr,wbr,param,img,isindex,?xml,embed,?php,?,?='.split(','),
			//all the single tags for HTML
			extra_liners: 'head,body,/html'.split(','),
			//for tags that need a line of whitespace before them
			in_array: function(what, arr) {
				for (var i = 0; i < arr.length; i++) {
					if (what === arr[i]) {
						return true;
					}
				}
				return false;
			}
		}
		this.get_content = function() { //function to capture regular content between tags
			var input_char = '',
				content = [],
				space = false; //if a space is needed
			while (this.input.charAt(this.pos) !== '<') {
				if (this.pos >= this.input.length) {
					return content.length ? content.join('') : ['', 'TK_EOF'];
				}
				input_char = this.input.charAt(this.pos);
				this.pos++;
				this.line_char_count++;
				if (this.Utils.in_array(input_char, this.Utils.whitespace)) {
					if (content.length) {
						space = true;
					}
					this.line_char_count--;
					continue; //don't want to insert unnecessary space
				} else if (space) {
					if (this.line_char_count >= this.max_char) { //insert a line when the max_char is reached
						content.push('\n');
						for (var i = 0; i < this.indent_level; i++) {
							content.push(this.indent_string);
						}
						this.line_char_count = 0;
					} else {
						content.push(' ');
						this.line_char_count++;
					}
					space = false;
				}
				content.push(input_char); //letter at-a-time (or string) inserted to an array
			}
			return content.length ? content.join('') : '';
		}
		this.get_contents_to = function(name) { //get the full content of a script or style to pass to js_beautify
			if (this.pos == this.input.length) {
				return ['', 'TK_EOF'];
			}
			var input_char = '';
			var content = '';
			var reg_match = new RegExp('\<\/' + name + '\\s*\>', 'igm');
			reg_match.lastIndex = this.pos;
			var reg_array = reg_match.exec(this.input);
			var end_script = reg_array ? reg_array.index : this.input.length; //absolute end of script
			if (this.pos < end_script) { //get everything in between the script tags
				content = this.input.substring(this.pos, end_script);
				this.pos = end_script;
			}
			return content;
		}
		this.record_tag = function(tag) { //function to record a tag and its parent in this.tags Object
			if (this.tags[tag + 'count']) { //check for the existence of this tag type
				this.tags[tag + 'count']++;
				this.tags[tag + this.tags[tag + 'count']] = this.indent_level; //and record the present indent level
			} else { //otherwise initialize this tag type
				this.tags[tag + 'count'] = 1;
				this.tags[tag + this.tags[tag + 'count']] = this.indent_level; //and record the present indent level
			}
			this.tags[tag + this.tags[tag + 'count'] + 'parent'] = this.tags.parent; //set the parent (i.e. in the case of a div this.tags.div1parent)
			this.tags.parent = tag + this.tags[tag + 'count']; //and make this the current parent (i.e. in the case of a div 'div1')
		}
		this.retrieve_tag = function(tag) { //function to retrieve the opening tag to the corresponding closer
			if (this.tags[tag + 'count']) { //if the openener is not in the Object we ignore it
				var temp_parent = this.tags.parent; //check to see if it's a closable tag.
				while (temp_parent) { //till we reach '' (the initial value);
					if (tag + this.tags[tag + 'count'] === temp_parent) { //if this is it use it
						break;
					}
					temp_parent = this.tags[temp_parent + 'parent']; //otherwise keep on climbing up the DOM Tree
				}
				if (temp_parent) { //if we caught something
					this.indent_level = this.tags[tag + this.tags[tag + 'count']]; //set the indent_level accordingly
					this.tags.parent = this.tags[temp_parent + 'parent']; //and set the current parent
				}
				delete this.tags[tag + this.tags[tag + 'count'] + 'parent']; //delete the closed tags parent reference...
				delete this.tags[tag + this.tags[tag + 'count']]; //...and the tag itself
				if (this.tags[tag + 'count'] == 1) {
					delete this.tags[tag + 'count'];
				} else {
					this.tags[tag + 'count']--;
				}
			}
		}
		this.get_tag = function() { //function to get a full tag and parse its type
			var input_char = '',
				content = [],
				space = false,
				tag_start, tag_end;
			do {
				if (this.pos >= this.input.length) {
					return content.length ? content.join('') : ['', 'TK_EOF'];
				}
				input_char = this.input.charAt(this.pos);
				this.pos++;
				this.line_char_count++;
				if (this.Utils.in_array(input_char, this.Utils.whitespace)) { //don't want to insert unnecessary space
					space = true;
					this.line_char_count--;
					continue;
				}
				if (input_char === "'" || input_char === '"') {
					if (!content[1] || content[1] !== '!') { //if we're in a comment strings don't get treated specially
						input_char += this.get_unformatted(input_char);
						space = true;
					}
				}
				if (input_char === '=') { //no space before =
					space = false;
				}
				if (content.length && content[content.length - 1] !== '=' && input_char !== '>' && space) { //no space after = or before >
					if (this.line_char_count >= this.max_char) {
						this.print_newline(false, content);
						this.line_char_count = 0;
					} else {
						content.push(' ');
						this.line_char_count++;
					}
					space = false;
				}
				if (input_char === '<') {
					tag_start = this.pos - 1;
				}
				content.push(input_char); //inserts character at-a-time (or string)
			} while (input_char !== '>');
			var tag_complete = content.join('');
			var tag_index;
			if (tag_complete.indexOf(' ') != -1) { //if there's whitespace, thats where the tag name ends
				tag_index = tag_complete.indexOf(' ');
			} else { //otherwise go with the tag ending
				tag_index = tag_complete.indexOf('>');
			}
			var tag_check = tag_complete.substring(1, tag_index).toLowerCase();
			if (tag_complete.charAt(tag_complete.length - 2) === '/' || this.Utils.in_array(tag_check, this.Utils.single_token)) { //if this tag name is a single tag type (either in the list or has a closing /)
				this.tag_type = 'SINGLE';
			} else if (tag_check === 'script') { //for later script handling
				this.record_tag(tag_check);
				this.tag_type = 'SCRIPT';
			} else if (tag_check === 'style') { //for future style handling (for now it justs uses get_content)
				this.record_tag(tag_check);
				this.tag_type = 'STYLE';
			} else if (this.Utils.in_array(tag_check, unformatted)) { // do not reformat the "unformatted" tags
				var comment = this.get_unformatted('</' + tag_check + '>', tag_complete); //...delegate to get_unformatted function
				content.push(comment);
				// Preserve collapsed whitespace either before or after this tag.
				if (tag_start > 0 && this.Utils.in_array(this.input.charAt(tag_start - 1), this.Utils.whitespace)) {
					content.splice(0, 0, this.input.charAt(tag_start - 1));
				}
				tag_end = this.pos - 1;
				if (this.Utils.in_array(this.input.charAt(tag_end + 1), this.Utils.whitespace)) {
					content.push(this.input.charAt(tag_end + 1));
				}
				this.tag_type = 'SINGLE';
			} else if (tag_check.charAt(0) === '!') { //peek for <!-- comment
				if (tag_check.indexOf('[if') != -1) { //peek for <!--[if conditional comment
					if (tag_complete.indexOf('!IE') != -1) { //this type needs a closing --> so...
						var comment = this.get_unformatted('-->', tag_complete); //...delegate to get_unformatted
						content.push(comment);
					}
					this.tag_type = 'START';
				} else if (tag_check.indexOf('[endif') != -1) { //peek for <!--[endif end conditional comment
					this.tag_type = 'END';
					this.unindent();
				} else if (tag_check.indexOf('[cdata[') != -1) { //if it's a <[cdata[ comment...
					var comment = this.get_unformatted(']]>', tag_complete); //...delegate to get_unformatted function
					content.push(comment);
					this.tag_type = 'SINGLE'; //<![CDATA[ comments are treated like single tags
				} else {
					var comment = this.get_unformatted('-->', tag_complete);
					content.push(comment);
					this.tag_type = 'SINGLE';
				}
			} else {
				if (tag_check.charAt(0) === '/') { //this tag is a double tag so check for tag-ending
					this.retrieve_tag(tag_check.substring(1)); //remove it and all ancestors
					this.tag_type = 'END';
				} else { //otherwise it's a start-tag
					this.record_tag(tag_check); //push it on the tag stack
					this.tag_type = 'START';
				}
				if (this.Utils.in_array(tag_check, this.Utils.extra_liners)) { //check if this double needs an extra line
					this.print_newline(true, this.output);
				}
			}
			return content.join(''); //returns fully formatted tag
		}
		this.get_unformatted = function(delimiter, orig_tag) { //function to return unformatted content in its entirety
			if (orig_tag && orig_tag.toLowerCase().indexOf(delimiter) != -1) {
				return '';
			}
			var input_char = '';
			var content = '';
			var space = true;
			do {
				if (this.pos >= this.input.length) {
					return content;
				}
				input_char = this.input.charAt(this.pos);
				this.pos++
				if (this.Utils.in_array(input_char, this.Utils.whitespace)) {
					if (!space) {
						this.line_char_count--;
						continue;
					}
					if (input_char === '\n' || input_char === '\r') {
						content += '\n';
/* Don't change tab indention for unformatted blocks. If using code for html editing, this will greatly affect <pre> tags if they are specified in the 'unformatted array'
for (var i=0; i<this.indent_level; i++) {
content += this.indent_string;
}
space = false; //...and make sure other indentation is erased
*/
						this.line_char_count = 0;
						continue;
					}
				}
				content += input_char;
				this.line_char_count++;
				space = true;
			} while (content.toLowerCase().indexOf(delimiter) == -1);
			return content;
		}
		this.get_token = function() { //initial handler for token-retrieval
			var token;
			if (this.last_token === 'TK_TAG_SCRIPT' || this.last_token === 'TK_TAG_STYLE') { //check if we need to format javascript
				var type = this.last_token.substr(7)
				token = this.get_contents_to(type);
				if (typeof token !== 'string') {
					return token;
				}
				return [token, 'TK_' + type];
			}
			if (this.current_mode === 'CONTENT') {
				token = this.get_content();
				if (typeof token !== 'string') {
					return token;
				} else {
					return [token, 'TK_CONTENT'];
				}
			}
			if (this.current_mode === 'TAG') {
				token = this.get_tag();
				if (typeof token !== 'string') {
					return token;
				} else {
					var tag_name_type = 'TK_TAG_' + this.tag_type;
					return [token, tag_name_type];
				}
			}
		}
		this.get_full_indent = function(level) {
			level = this.indent_level + level || 0;
			if (level < 1) return '';
			return Array(level + 1).join(this.indent_string);
		}
		this.printer = function(js_source, indent_character, indent_size, max_char, brace_style) { //handles input/output and some other printing functions
			this.input = js_source || ''; //gets the input for the Parser
			this.output = [];
			this.indent_character = indent_character;
			this.indent_string = '';
			this.indent_size = indent_size;
			this.brace_style = brace_style;
			this.indent_level = 0;
			this.max_char = max_char;
			this.line_char_count = 0; //count to see if max_char was exceeded
			for (var i = 0; i < this.indent_size; i++) {
				this.indent_string += this.indent_character;
			}
			this.print_newline = function(ignore, arr) {
				this.line_char_count = 0;
				if (!arr || !arr.length) {
					return;
				}
				if (!ignore) { //we might want the extra line
					while (this.Utils.in_array(arr[arr.length - 1], this.Utils.whitespace)) {
						arr.pop();
					}
				}
				arr.push('\n');
				for (var i = 0; i < this.indent_level; i++) {
					arr.push(this.indent_string);
				}
			}
			this.print_token = function(text) {
				this.output.push(text);
			}
			this.indent = function() {
				this.indent_level++;
			}
			this.unindent = function() {
				if (this.indent_level > 0) {
					this.indent_level--;
				}
			}
		}
		return this;
	} /*_____________________--------------------_____________________*/
	multi_parser = new Parser(); //wrapping functions Parser
	multi_parser.printer(html_source, indent_character, indent_size, max_char, brace_style); //initialize starting values
	while (true) {
		var t = multi_parser.get_token();
		multi_parser.token_text = t[0];
		multi_parser.token_type = t[1];
		if (multi_parser.token_type === 'TK_EOF') {
			break;
		}
		switch (multi_parser.token_type) {
		case 'TK_TAG_START':
			multi_parser.print_newline(false, multi_parser.output);
			multi_parser.print_token(multi_parser.token_text);
			multi_parser.indent();
			multi_parser.current_mode = 'CONTENT';
			break;
		case 'TK_TAG_STYLE':
		case 'TK_TAG_SCRIPT':
			multi_parser.print_newline(false, multi_parser.output);
			multi_parser.print_token(multi_parser.token_text);
			multi_parser.current_mode = 'CONTENT';
			break;
		case 'TK_TAG_END':
			//Print new line only if the tag has no content and has child
			if (multi_parser.last_token === 'TK_CONTENT' && multi_parser.last_text === '') {
				var tag_name = multi_parser.token_text.match(/\w+/)[0];
				var tag_extracted_from_last_output = multi_parser.output[multi_parser.output.length - 1].match(/<\s*(\w+)/);
				if (tag_extracted_from_last_output === null || tag_extracted_from_last_output[1] !== tag_name) multi_parser.print_newline(true, multi_parser.output);
			}
			multi_parser.print_token(multi_parser.token_text);
			multi_parser.current_mode = 'CONTENT';
			break;
		case 'TK_TAG_SINGLE':
			// Don't add a newline before elements that should remain unformatted.
			var tag_check = multi_parser.token_text.match(/^\s*<([a-z]+)/i);
			if (!tag_check || !multi_parser.Utils.in_array(tag_check[1], unformatted)) {
				multi_parser.print_newline(false, multi_parser.output);
			}
			multi_parser.print_token(multi_parser.token_text);
			multi_parser.current_mode = 'CONTENT';
			break;
		case 'TK_CONTENT':
			if (multi_parser.token_text !== '') {
				multi_parser.print_token(multi_parser.token_text);
			}
			multi_parser.current_mode = 'TAG';
			break;
		case 'TK_STYLE':
		case 'TK_SCRIPT':
			if (multi_parser.token_text !== '') {
				multi_parser.output.push('\n');
				var text = multi_parser.token_text;
				if (multi_parser.token_type == 'TK_SCRIPT') {
					var _beautifier = typeof js_beautify == 'function' && js_beautify;
				} else if (multi_parser.token_type == 'TK_STYLE') {
					var _beautifier = typeof css_beautify == 'function' && css_beautify;
				}
				if (options.indent_scripts == "keep") {
					var script_indent_level = 0;
				} else if (options.indent_scripts == "separate") {
					var script_indent_level = -multi_parser.indent_level;
				} else {
					var script_indent_level = 1;
				}
				var indentation = multi_parser.get_full_indent(script_indent_level);
				if (_beautifier) {
					// call the Beautifier if avaliable
					text = _beautifier(text.replace(/^\s*/, indentation), options);
				} else {
					// simply indent the string otherwise
					var white = text.match(/^\s*/)[0];
					var _level = white.match(/[^\n\r]*$/)[0].split(multi_parser.indent_string).length - 1;
					var reindent = multi_parser.get_full_indent(script_indent_level - _level);
					text = text.replace(/^\s*/, indentation).replace(/\r\n|\r|\n/g, '\n' + reindent).replace(/\s*$/, '');
				}
				if (text) {
					multi_parser.print_token(text);
					multi_parser.print_newline(true, multi_parser.output);
				}
			}
			multi_parser.current_mode = 'TAG';
			break;
		}
		multi_parser.last_token = multi_parser.token_type;
		multi_parser.last_text = multi_parser.token_text;
	}
	return multi_parser.output.join('');
}
/*

CSS Beautifier
---------------

Written by Harutyun Amirjanyan, (amirjanyan@gmail.com)

Based on code initially developed by: Einar Lielmanis, <elfz@laacz.lv>
http://jsbeautifier.org/


You are free to use this in any way you want, in case you find this useful or working for you.

Usage:
css_beautify(source_text);
css_beautify(source_text, options);

The options are:
indent_size (default 4) � indentation size,
indent_char (default space) � character to indent with,

e.g

css_beautify(css_source_text, {
'indent_size': 1,
'indent_char': '\t'
});
*/
// http://www.w3.org/TR/CSS21/syndata.html#tokenization
// http://www.w3.org/TR/css3-syntax/

function css_beautify(source_text, options) {
	options = options || {};
	var indentSize = options.indent_size || 4;
	var indentCharacter = options.indent_char || ' ';
	// compatibility
	if (typeof indentSize == "string") indentSize = parseInt(indentSize);
	// tokenizer
	var whiteRe = /^\s+$/;
	var wordRe = /[\w$\-_]/;
	var pos = -1,
		ch;

	function next() {
		return ch = source_text.charAt(++pos)
	}

	function peek() {
		return source_text.charAt(pos + 1)
	}

	function eatString(comma) {
		var start = pos;
		while (next()) {
			if (ch == "\\") {
				next();
				next();
			} else if (ch == comma) {
				break;
			} else if (ch == "\n") {
				break;
			}
		}
		return source_text.substring(start, pos + 1);
	}

	function eatWhitespace() {
		var start = pos;
		while (whiteRe.test(peek()))
		pos++;
		return pos != start;
	}

	function skipWhitespace() {
		var start = pos;
		do {} while (whiteRe.test(next()))
		return pos != start + 1;
	}

	function eatComment() {
		var start = pos;
		next();
		while (next()) {
			if (ch == "*" && peek() == "/") {
				pos++;
				break;
			}
		}
		return source_text.substring(start, pos + 1);
	}

	function lookBack(str, index) {
		return output.slice(-str.length + (index || 0), index).join("").toLowerCase() == str;
	}
	// printer
	var indentString = source_text.match(/^[\r\n]*[\t ]*/)[0];
	var singleIndent = Array(indentSize + 1).join(indentCharacter);
	var indentLevel = 0;

	function indent() {
		indentLevel++;
		indentString += singleIndent;
	}

	function outdent() {
		indentLevel--;
		indentString = indentString.slice(0, -indentSize);
	}
	var print = {}
	print["{"] = function(ch) {
		print.singleSpace();
		output.push(ch);
		print.newLine();
	}
	print["}"] = function(ch) {
		print.newLine();
		output.push(ch);
		print.newLine();
	}
	print.newLine = function(keepWhitespace) {
		if (!keepWhitespace) while (whiteRe.test(output[output.length - 1]))
		output.pop();
		if (output.length) output.push('\n');
		if (indentString) output.push(indentString);
	}
	print.singleSpace = function() {
		if (output.length && !whiteRe.test(output[output.length - 1])) output.push(' ');
	}
	var output = [];
	if (indentString) output.push(indentString); /*_____________________--------------------_____________________*/
	while (true) {
		var isAfterSpace = skipWhitespace();
		if (!ch) break;
		if (ch == '{') {
			indent();
			print["{"](ch);
		} else if (ch == '}') {
			outdent();
			print["}"](ch);
		} else if (ch == '"' || ch == '\'') {
			output.push(eatString(ch))
		} else if (ch == ';') {
			output.push(ch, '\n', indentString);
		} else if (ch == '/' && peek() == '*') { // comment
			print.newLine();
			output.push(eatComment(), "\n", indentString);
		} else if (ch == '(') { // may be a url
			if (lookBack("url", -1)) {
				output.push(ch);
				eatWhitespace();
				if (next()) {
					if (ch != ')' && ch != '"' && ch != '\'') output.push(eatString(')'));
					else
					pos--;
				}
			} else {
				if (isAfterSpace) print.singleSpace();
				output.push(ch);
				eatWhitespace();
			}
		} else if (ch == ')') {
			output.push(ch);
		} else if (ch == ',') {
			eatWhitespace();
			output.push(ch);
			print.singleSpace();
		} else if (ch == ']') {
			output.push(ch);
		} else if (ch == '[' || ch == '=') { // no whitespace before or after
			eatWhitespace();
			output.push(ch);
		} else {
			if (isAfterSpace) print.singleSpace();
			output.push(ch);
		}
	}
	var sweetCode = output.join('').replace(/[\n ]+$/, '');
	return sweetCode;
}
if (typeof exports !== "undefined") exports.css_beautify = css_beautify;

/*
 * ----------------------------- JSTORAGE -------------------------------------
 * Simple local storage wrapper to save data on the browser side, supporting
 * all major browsers - IE6+, Firefox2+, Safari4+, Chrome4+ and Opera 10.5+
 *
 * Copyright (c) 2010 - 2012 Andris Reinman, andris.reinman@gmail.com
 * Project homepage: www.jstorage.info
 *
 * Licensed under MIT-style license:
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
(function(){function C(){var a="{}";if("userDataBehavior"==h){d.load("jStorage");try{a=d.getAttribute("jStorage")}catch(b){}try{r=d.getAttribute("jStorage_update")}catch(c){}g.jStorage=a}D();x();E()}function u(){var a;clearTimeout(F);F=setTimeout(function(){if("localStorage"==h||"globalStorage"==h)a=g.jStorage_update;else if("userDataBehavior"==h){d.load("jStorage");try{a=d.getAttribute("jStorage_update")}catch(b){}}if(a&&a!=r){r=a;var k=l.parse(l.stringify(c.__jstorage_meta.CRC32)),p;C();p=l.parse(l.stringify(c.__jstorage_meta.CRC32));
var e,y=[],f=[];for(e in k)k.hasOwnProperty(e)&&(p[e]?k[e]!=p[e]&&"2."==String(k[e]).substr(0,2)&&y.push(e):f.push(e));for(e in p)p.hasOwnProperty(e)&&(k[e]||y.push(e));s(y,"updated");s(f,"deleted")}},25)}function s(a,b){a=[].concat(a||[]);if("flushed"==b){a=[];for(var c in j)j.hasOwnProperty(c)&&a.push(c);b="deleted"}c=0;for(var p=a.length;c<p;c++){if(j[a[c]])for(var e=0,d=j[a[c]].length;e<d;e++)j[a[c]][e](a[c],b);if(j["*"]){e=0;for(d=j["*"].length;e<d;e++)j["*"][e](a[c],b)}}}function v(){var a=
(+new Date).toString();"localStorage"==h||"globalStorage"==h?g.jStorage_update=a:"userDataBehavior"==h&&(d.setAttribute("jStorage_update",a),d.save("jStorage"));u()}function D(){if(g.jStorage)try{c=l.parse(String(g.jStorage))}catch(a){g.jStorage="{}"}else g.jStorage="{}";z=g.jStorage?String(g.jStorage).length:0;c.__jstorage_meta||(c.__jstorage_meta={});c.__jstorage_meta.CRC32||(c.__jstorage_meta.CRC32={})}function w(){if(c.__jstorage_meta.PubSub){for(var a=+new Date-2E3,b=0,k=c.__jstorage_meta.PubSub.length;b<
k;b++)if(c.__jstorage_meta.PubSub[b][0]<=a){c.__jstorage_meta.PubSub.splice(b,c.__jstorage_meta.PubSub.length-b);break}c.__jstorage_meta.PubSub.length||delete c.__jstorage_meta.PubSub}try{g.jStorage=l.stringify(c),d&&(d.setAttribute("jStorage",g.jStorage),d.save("jStorage")),z=g.jStorage?String(g.jStorage).length:0}catch(p){}}function q(a){if(!a||"string"!=typeof a&&"number"!=typeof a)throw new TypeError("Key name must be string or numeric");if("__jstorage_meta"==a)throw new TypeError("Reserved key name");
return!0}function x(){var a,b,k,d,e=Infinity,g=!1,f=[];clearTimeout(G);if(c.__jstorage_meta&&"object"==typeof c.__jstorage_meta.TTL){a=+new Date;k=c.__jstorage_meta.TTL;d=c.__jstorage_meta.CRC32;for(b in k)k.hasOwnProperty(b)&&(k[b]<=a?(delete k[b],delete d[b],delete c[b],g=!0,f.push(b)):k[b]<e&&(e=k[b]));Infinity!=e&&(G=setTimeout(x,e-a));g&&(w(),v(),s(f,"deleted"))}}function E(){var a;if(c.__jstorage_meta.PubSub){var b,k=A;for(a=c.__jstorage_meta.PubSub.length-1;0<=a;a--)if(b=c.__jstorage_meta.PubSub[a],
b[0]>A){var k=b[0],d=b[1];b=b[2];if(t[d])for(var e=0,g=t[d].length;e<g;e++)t[d][e](d,l.parse(l.stringify(b)))}A=k}}var n=window.jQuery||window.$||(window.$={}),l={parse:window.JSON&&(window.JSON.parse||window.JSON.decode)||String.prototype.evalJSON&&function(a){return String(a).evalJSON()}||n.parseJSON||n.evalJSON,stringify:Object.toJSON||window.JSON&&(window.JSON.stringify||window.JSON.encode)||n.toJSON};if(!l.parse||!l.stringify)throw Error("No JSON support found, include //cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.js to page");
var c={__jstorage_meta:{CRC32:{}}},g={jStorage:"{}"},d=null,z=0,h=!1,j={},F=!1,r=0,t={},A=+new Date,G,B={isXML:function(a){return(a=(a?a.ownerDocument||a:0).documentElement)?"HTML"!==a.nodeName:!1},encode:function(a){if(!this.isXML(a))return!1;try{return(new XMLSerializer).serializeToString(a)}catch(b){try{return a.xml}catch(c){}}return!1},decode:function(a){var b="DOMParser"in window&&(new DOMParser).parseFromString||window.ActiveXObject&&function(a){var b=new ActiveXObject("Microsoft.XMLDOM");b.async=
"false";b.loadXML(a);return b};if(!b)return!1;a=b.call("DOMParser"in window&&new DOMParser||window,a,"text/xml");return this.isXML(a)?a:!1}};n.jStorage={version:"0.4.3",set:function(a,b,d){q(a);d=d||{};if("undefined"==typeof b)return this.deleteKey(a),b;if(B.isXML(b))b={_is_xml:!0,xml:B.encode(b)};else{if("function"==typeof b)return;b&&"object"==typeof b&&(b=l.parse(l.stringify(b)))}c[a]=b;for(var g=c.__jstorage_meta.CRC32,e=l.stringify(b),j=e.length,f=2538058380^j,h=0,m;4<=j;)m=e.charCodeAt(h)&255|
(e.charCodeAt(++h)&255)<<8|(e.charCodeAt(++h)&255)<<16|(e.charCodeAt(++h)&255)<<24,m=1540483477*(m&65535)+((1540483477*(m>>>16)&65535)<<16),m^=m>>>24,m=1540483477*(m&65535)+((1540483477*(m>>>16)&65535)<<16),f=1540483477*(f&65535)+((1540483477*(f>>>16)&65535)<<16)^m,j-=4,++h;switch(j){case 3:f^=(e.charCodeAt(h+2)&255)<<16;case 2:f^=(e.charCodeAt(h+1)&255)<<8;case 1:f^=e.charCodeAt(h)&255,f=1540483477*(f&65535)+((1540483477*(f>>>16)&65535)<<16)}f^=f>>>13;f=1540483477*(f&65535)+((1540483477*(f>>>16)&
65535)<<16);g[a]="2."+((f^f>>>15)>>>0);this.setTTL(a,d.TTL||0);s(a,"updated");return b},get:function(a,b){q(a);return a in c?c[a]&&"object"==typeof c[a]&&c[a]._is_xml?B.decode(c[a].xml):c[a]:"undefined"==typeof b?null:b},deleteKey:function(a){q(a);return a in c?(delete c[a],"object"==typeof c.__jstorage_meta.TTL&&a in c.__jstorage_meta.TTL&&delete c.__jstorage_meta.TTL[a],delete c.__jstorage_meta.CRC32[a],w(),v(),s(a,"deleted"),!0):!1},setTTL:function(a,b){var d=+new Date;q(a);b=Number(b)||0;return a in
c?(c.__jstorage_meta.TTL||(c.__jstorage_meta.TTL={}),0<b?c.__jstorage_meta.TTL[a]=d+b:delete c.__jstorage_meta.TTL[a],w(),x(),v(),!0):!1},getTTL:function(a){var b=+new Date;q(a);return a in c&&c.__jstorage_meta.TTL&&c.__jstorage_meta.TTL[a]?(a=c.__jstorage_meta.TTL[a]-b)||0:0},flush:function(){c={__jstorage_meta:{CRC32:{}}};w();v();s(null,"flushed");return!0},storageObj:function(){function a(){}a.prototype=c;return new a},index:function(){var a=[],b;for(b in c)c.hasOwnProperty(b)&&"__jstorage_meta"!=
b&&a.push(b);return a},storageSize:function(){return z},currentBackend:function(){return h},storageAvailable:function(){return!!h},listenKeyChange:function(a,b){q(a);j[a]||(j[a]=[]);j[a].push(b)},stopListening:function(a,b){q(a);if(j[a])if(b)for(var c=j[a].length-1;0<=c;c--)j[a][c]==b&&j[a].splice(c,1);else delete j[a]},subscribe:function(a,b){a=(a||"").toString();if(!a)throw new TypeError("Channel not defined");t[a]||(t[a]=[]);t[a].push(b)},publish:function(a,b){a=(a||"").toString();if(!a)throw new TypeError("Channel not defined");
c.__jstorage_meta||(c.__jstorage_meta={});c.__jstorage_meta.PubSub||(c.__jstorage_meta.PubSub=[]);c.__jstorage_meta.PubSub.unshift([+new Date,a,b]);w();v()},reInit:function(){C()}};a:{n=!1;if("localStorage"in window)try{window.localStorage.setItem("_tmptest","tmpval"),n=!0,window.localStorage.removeItem("_tmptest")}catch(H){}if(n)try{window.localStorage&&(g=window.localStorage,h="localStorage",r=g.jStorage_update)}catch(I){}else if("globalStorage"in window)try{window.globalStorage&&(g=window.globalStorage[window.location.hostname],
h="globalStorage",r=g.jStorage_update)}catch(J){}else if(d=document.createElement("link"),d.addBehavior){d.style.behavior="url(#default#userData)";document.getElementsByTagName("head")[0].appendChild(d);try{d.load("jStorage")}catch(K){d.setAttribute("jStorage","{}"),d.save("jStorage"),d.load("jStorage")}n="{}";try{n=d.getAttribute("jStorage")}catch(L){}try{r=d.getAttribute("jStorage_update")}catch(M){}g.jStorage=n;h="userDataBehavior"}else{d=null;break a}D();x();"localStorage"==h||"globalStorage"==
h?"addEventListener"in window?window.addEventListener("storage",u,!1):document.attachEvent("onstorage",u):"userDataBehavior"==h&&setInterval(u,1E3);E();"addEventListener"in window&&window.addEventListener("pageshow",function(a){a.persisted&&u()},!1)}})();
/*
 * jQuery.ajaxQueue - A queue for ajax requests
 * 
 * (c) 2011 Corey Frang
 * Dual licensed under the MIT and GPL licenses.
 *
 * Requires jQuery 1.5+
 */
(function(a){var b=a({});a.ajaxQueue=function(c){function g(b){d=a.ajax(c).done(e.resolve).fail(e.reject).then(b,b)}var d,e=a.Deferred(),f=e.promise();b.queue(g),f.abort=function(h){if(d)return d.abort(h);var i=b.queue(),j=a.inArray(g,i);j>-1&&i.splice(j,1),e.rejectWith(c.context||c,[f,h,""]);return f};return f}})(jQuery);