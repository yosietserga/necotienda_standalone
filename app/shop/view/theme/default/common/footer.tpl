<footer>
    <div class="container_16">
        <div class="grid_16"><p><?php echo $text_powered_by; ?></p></div>
    </div>
</footer>

  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's $, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script>window.$ || document.write('<script src="js/libs/jquery-1.8.2.min.js"><\/script>')</script>

  <?php if (count($javascripts) > 0) { ?>
      <?php foreach ($javascripts as $js) { ?>
      <?php if (empty($js)) continue; ?>
      <script type="text/javascript" src="<?php echo $js; ?>"></script> 
      <?php } ?>
   <?php } ?>
    <?php if ($script) echo $script; ?>
    

  <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
  <script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
  </script>
  
<?php echo $google_analytics; ?>

<?php if ($scripts) echo $scripts; ?>
<input type="text" id="sample" value="" onchange="hola(this)" />
{%algo_que_decir%}
<script>
$(function(){
    pattern = /\{%(.*?)\%}/g;
    reg = new RegExp(pattern);
    var matches = $('body').html().match(pattern);
    console.log(matches);
});
</script>
</body></html>