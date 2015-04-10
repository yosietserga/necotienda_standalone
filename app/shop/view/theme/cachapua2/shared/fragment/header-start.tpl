<style class="webfont"
    data-cache-name="NecoTiendaBaseWeb"
    data-cahce-file-woff="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/fonts/fonts.base.woff.json'; ?>"></style>


<style class="webfont"
       data-cache-name="NecoTiendaAlterWeb"
       data-cahce-file-woff="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/fonts/fonts.alter.woff.json'; ?>"></style>

<script id="neco">
    var neco = {
        isModernBrowser: (
            'querySelector' in document
            && 'addEventListener' in window
            && 'localStorage' in window
            && 'sessionStorage' in window
            && 'bind' in Function
            && (
            ('XMLHttpRequest' in window && 'withCredentials' in new XMLHttpRequest())
            || 'XDomainRequest' in window
            )
        ),
        css: {
            loaded: false
        };
    var baseFontSize;
    var loadFontsAsynchronously;
    var insertFont;

    if('getComputedStyle' in window) {
        baseFontSize = window.getComputedStyle(document.documentElement).getPropertyValue("font-size");
        if(parseInt(baseFontSize, 10) !== 16) {
            document.documentElement.style.fontSize = baseFontSize;
        }
    }


    insertFont = function (value) {
        var style = document.createElement('style');
        style.innerHTML = value;
        document.head.appendChild(style);

    }

    loadFontsAsynchronously = function () {
        var scripts = document.getElementsByTagName('script');
        var currentScript = scripts[scripts.length - 1];
        var fonts = document.createElement('link')
    }

    };
</script>
