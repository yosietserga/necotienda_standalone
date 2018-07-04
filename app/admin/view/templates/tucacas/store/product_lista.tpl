<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo $error_warning; ?></div></div><?php } ?>
<div class="box">
        <h1><?php echo $Language->get('heading_title'); ?></h1>
        
        <script type="text/x-handlebars">
            {{#link-to 'posts'}}Productos{{/link-to}}
            {{outlet}}
        </script>
  <script type="text/x-handlebars" id="posts">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <table class='table'>
            <thead>
              <tr><th>Recent Posts</th></tr>
            </thead>
            {{#each model}}
            <tr>
              <td>
                <a {{bind-attr href="href"}} title="{{name}}"><img {{bind-attr src="thumb"}} alt="{{name}}" /></a>
              </td>
              <td>
                <a {{bind-attr href="href"}} title="{{name}}"><h2>{{name}}</h2></a>

                <p><b>{{price}}</b></p>

                <p>{{overview}}</p>

                <a {{bind-attr href="href"}}>View Details</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a {{bind-attr href="add"}}>Add To Cart</a>
                
              </td>
            </tr>
            {{/each}}
          </table>
        </div>
        <div class="span9">
          {{outlet}}
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-handlebars" id="posts/index">
    <p class="text-warning">Please select a post</p>
  </script>

  <script type="text/x-handlebars" id="post">
    {{#if isEditing}}
      {{partial 'post/edit'}}
      <button {{action 'doneEditing'}}>Done</button>
    {{else}}
      <button {{action 'edit'}}>Edit</button>
    {{/if}}
    <h1>{{title}}</h1>
  </script>

  <script type="text/x-handlebars" id="post/_edit">
    <p>{{input type="text" value=title}}</p>
  </script>

  <script src="js/app/libs/handlebars-1.1.2.js"></script>
  <script src="js/app/libs/ember-1.5.1.js"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.6.0/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/showdown/0.3.1/showdown.min.js"></script>
  
</div>
<div class="sidebar" id="feedbackPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Sugerencias</h2>
        <p style="margin: -10px auto 0px auto;">Tu opini&oacute;n es muy importante, dinos que quieres cambiar.</p>
        <form id="feedbackForm">
            <textarea name="feedback" id="feedback" cols="60" rows="10"></textarea>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo C_CODE; ?>" />
            <input type="hidden" name="domain" id="domain" value="<?php echo HTTP_DOMAIN; ?>" />
            <input type="hidden" name="server_ip" id="server_ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <input type="hidden" name="remote_ip" id="remote_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
            <input type="hidden" name="server" id="server" value="<?php echo serialize($_SERVER); ?>" />
            <div class="clear"></div>
            <br />
            <div class="buttons"><a class="button" onclick="sendFeedback()">Enviar Sugerencia</a></div>
        </form>
    </div>
</div>
<div class="sidebar" id="toolPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Herramientas</h2>
        <p>S&aacute;cale provecho a NecoTienda y aumenta tus ventas.</p>
        <ul>
            <li><a onclick="$('#addsWrapper').slideDown();$('html, body').animate({scrollTop:$('#addsWrapper').offset().top}, 'slow');">Agregar Productos</a></li>
            <li><a class="trends" data-fancybox-type="iframe" href="http://www.necotienda.com/index.php?route=api/trends&q=samsung&geo=VE">Evaluar Palabras Claves</a></li>
            <li><a>Eliminar Esta Categor&iacute;a</a></li>
        </ul>
        <div class="toolWrapper"></div>
    </div>
</div>
<div class="sidebar" id="helpPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Ayuda</h2>
        <p>No entres en p&aacute;nico, todo tiene una soluci&oacute;n.</p>
        <ul>
            <li><a>&iquest;C&oacute;mo se come esto?</a></li>
            <li><a>&iquest;C&oacute;mo relleno este formulario?</a></li>
            <li><a>&iquest;Qu&eacute; significan las figuritas al lado de los campos?</a></li>
            <li><a>&iquest;C&oacute;mo me desplazo a trav&eacute;s de las pesta&ntilde;as?</a></li>
            <li><a>&iquest;Pierdo la informaci&oacute;n si me cambio de pesta&ntilde;a?</a></li>
            <li><a>Preguntas Frecuentes</a></li>
            <li><a>Manual de Usuario</a></li>
            <li><a>Videos Tutoriales</a></li>
            <li><a>Auxilio, por favor ay&uacute;denme!</a></li>
        </ul>
    </div>
</div>
<?php echo $footer; ?>