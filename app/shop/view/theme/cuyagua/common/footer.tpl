<div class="container_16">
    <div id="footerWidgets">
        <ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul>
    </div>
    
    <div class="clear">&nbsp;</div>
    
    <footer id="footer">
        <div class="grid_16">
            <p>
                <a href="<?php echo str_replace('&', '&amp;', $home); ?>">Inicio</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $about_us); ?>">Nosotros</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $special); ?>">Ofertas</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $faq); ?>">Preguntas Frecuentes</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $jobs); ?>">Empleos</a>&nbsp;::&nbsp;
                <a href="<?php echo str_replace('&', '&amp;', $contact); ?>">Contacto</a>
            </p>
        </div>
            
        <div class="clear">&nbsp;</div>
            
        <div class="grid_16"><p><?php echo $text_powered_by; ?></p></div>            
    </footer>
</div>
<?php if (count($javascripts) > 0) foreach ($javascripts as $js) { if (empty($js)) continue; ?><script type="text/javascript" src="<?php echo $js; ?>"></script><?php } ?>
<?php if ($scripts) echo $scripts; ?>
<div id="fb-root"></div>
<script type="text/javascript">
    (function(d, debug){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/es_ES/all" + (debug ? "/debug" : "") + ".js";
         ref.parentNode.insertBefore(js, ref);
    }(document, /*debug*/ false));
    
    <?php if ($google_analytics_code) { ?>
    var _gaq=[['_setAccount','<?php echo $google_analytics_code; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    <?php } ?>
    
function signInCallback(authResult) {
  if (authResult['code']) {
    $.ajax({
      type: 'POST',
      url: '<?php echo $Url::createUrl("api/google"); ?>',
      contentType: 'application/octet-stream; charset=utf-8',
      success: function(result) {
        console.log(result);
        if (result['profile'] && result['people']){
          $('#results').html('Hello ' + result['profile']['displayName'] + '. You successfully made a server side call to people.get and people.list');
        } else {
          $('#results').html('Failed to make a server-side call. Check your configuration and console.');
        }
      },
      processData: false,
      code: authResult['code']
    });
  } else if (authResult['error']) {
  }
}
<?php if ($facebook_app_id) { ?>
window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $facebook_app_id; ?>',
      channelUrl : '<?php echo HTTP_HOME; ?>/channel.php',
      status     : true,
      cookie     : true,
      xfbml      : true
    });
    
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            /*
            1. enviar datos al servidor y brabarlos en la sesion
            */
            $.post('<?php echo $Url::createUrl("api/facebook/login"); ?>',
            {
                'accessToken':response.authResponse.accessToken,
                'expiresIn':response.authResponse.expiresIn,
                'signedRequest':response.authResponse.signedRequest,
                'userID':response.authResponse.userID,
            },
            function(response){
                
            });
        } else if (response.status === 'not_authorized') {
            login();
        } else {
            login();
        }
    });
};

function login() {
    /*
    1. mostrar fancybox con el formulario de inicio de sesión
    2. ejecutar callback del login de acuerdo con cual haya iniciado la sesion (fb, twitter, google o nativo)
    3. guardar en sesion que ya se mostro en fancybox para no volverlo a mostrar al menos que se haga click en login
    */
    
    FB.login(function(response) {
        if (response.authResponse) {
            FB.api('/me', function(response) {
                /* enviar datos al servidor para registrar el login en la sesion y en bd */
                $.post('<?php echo $Url::createUrl("api/facebook/login"); ?>',
                {
                    'accessToken':response.authResponse.accessToken,
                    'expiresIn':response.authResponse.expiresIn,
                    'signedRequest':response.authResponse.signedRequest,
                    'userID':response.authResponse.userID,
                },
                function(response){
                    
                });
                console.log('Good to see you, ' + response.name + '.');
            });
        } else {
            alert('Nooo');
        }
    });
}
<?php } ?>

$(function() {
    $('#filter_keyword').on('keydown',function(e){
        var code = e.keyCode || e.which;
        if ($(this).val().length > 0 && code == 13) {
            moduleSearch();
        }
    });
    $('#productsWrapper li').each(function(){ 
        $(this).hoverdir(); 
    });
    $("#productsWrapper img").lazyload();
    
    var self;
    var that;
    $('.nt-dd1 p').on('click',function(e) {
        self = $(this).closest('.nt-dd1');
        that = $(self).find('ul:eq(0)');
        $('.nt-dd1 ul').each(function(){
            if ($(that) != $(this)) 
                $(this).removeClass('on').slideUp("fast");
        });
        $(that).toggleClass('on').slideToggle("fast");
        e.stopPropagation();
    });
    $('body').on('click',function(e){
        father = $(e.target).closest('.nt-dd1');
        if ($(father).length == 0)
            $('.nt-dd1 ul').removeClass('on').slideUp("fast");
    });
    
});
</script>
</body></html>