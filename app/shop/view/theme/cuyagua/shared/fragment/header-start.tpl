<!--<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="only x">-->
<link href="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/fonts/fonts.stylesheet.css'; ?>" rel='stylesheet' type='text/css' media="only x">
<link rel="stylesheet" href="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/css/theme.css'; ?>" media="all">

<noscript>
    <link rel="stylesheet" type="text/css" href="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/css/theme.css'; ?>"/>
</noscript>


<script>

    /* @@cc_on
     @@if (@@_jscript_version <= 6)
     (function (f) {window.setTimeout = f(window.setTimeout)})(function (f) {
     return function (c, t) {
     var a = [].slice.call(arguments, 2);
     return f(function () {
     c.apply(this, a)
     }, t);
     }
     }
     );
     @@end
     @@*/


    /**
     *  Chequea si el link css con el atributo media igual a "only x" ya este coleccionado en
     *  document.window.document.styleSheets y lo pone en "all", de manera de carga el css
     *  asincrónicamente y si bloquear la reproducción. Todo esto es para que cuando por alguna razón
     *  el css no se cargue la página no quede en blanco y siga funcional
     */

    (function (styleSheetLinks, documentStyleSheets) {
        'use strict';

        function setMedia (styleSheet) {
            var sheet;
            var i;
            var totalSheets;
            for (i = 0, totalSheets = documentStyleSheets.length; i < totalSheets ; i++) {
                sheet = documentStyleSheets[i];
                if (sheet.href && sheet.href.indexOf(styleSheet.href) > -1) {
                    styleSheet.media = "all";
                    return true;
                }
            }
            /* Garantiza que la función corra luego de procesar */
            setTimeout(setMedia, null, styleSheet);
        }
        function useCss () {
            var i;
            var totalStyleSheetLinks;
            for (i = 0, totalStyleSheetLinks = styleSheetLinks.length; i < totalStyleSheetLinks ; i++) {
                if (styleSheetLinks[i].getAttribute('media') === 'only x') {
                    setMedia(styleSheetLinks[i]);
                }
            }
        }
        useCss();
    })(document.getElementsByTagName('link'), window.document.styleSheets)
</script>

