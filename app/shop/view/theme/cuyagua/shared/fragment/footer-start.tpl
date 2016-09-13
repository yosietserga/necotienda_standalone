<?php if (count($javascripts) > 0) foreach ($javascripts as $js) { if (empty($js)) continue; ?>
<script type="text/javascript" src="<?php echo $js; ?>"></script>
<?php } ?>
<?php if ($scripts) echo $scripts; ?>

<script>
$(function() {
    var $actionLogin = $('[data-action="login"]');
    var $cartOverview = $('[data-component="cart-overview"]');
    var actionLoginResource = $actionLogin.attr('data-resource');
    var actionCartOverviewResource = $cartOverview.attr('data-resource');

    $("[data-request='cart']").one('click',function(e){
        var $target = $(e.target);
        $target.siblings('[data-component="cart-overview"]').html('<i class="icon">' + actionCartOverviewResource + '</i>&nbsp;&nbsp;<span><?php echo $Language->get('cart_loading');?></span>').load('<?php echo $Url::createUrl("checkout/cart/callback"); ?>');
    });

    $actionLogin.on('click', function () {
        var $homeLoginUserValue = $('[data-entry="homeLoginUser"]').val();
        var $homeLoginTokenValue = $('[data-entry="homeLoginToken"]').val();
        var $homeLoginPasswordValue = $('[data-entry="homeLoginPassword"]').crypt({method:'md5'});
        $(this).html('<i class="icon" style="display: block;">' + actionLoginResource + '</i>');

        $.post('<?php echo $Url::createUrl("account/login/header"); ?>',
           {
            email: $homeLoginUserValue,
            password: $homeLoginPasswordValue,
            token: $homeLoginTokenValue
           }, function (response) {
               var data = $.parseJSON(response);
               if (data.error) {
                   return window.location.href = '<?php echo $Url::createUrl("account/login"); ?>&error=true'
               }
               window.location.reload();
           }
        );
        return false;
    });

    /*slideContent(".filter-heading", ".filter-options");*/

    if (window.matchMedia("only screen and (max-width: 64em)").matches) {
        $("*[data-action='call']").attr("href", "<?php echo 'callto://' . preg_replace('/\D+/', '', $Config->get('config_telephone'));?>");
        slideContent(".heading-dropdown", ".widget-content");
        slideContent("[data-trigger='dropdown']", "[data-wrapper='dropdown']");
    } else {
        $("*[data-action='call']").attr("href", "<?php echo 'tel:+58' . preg_replace('/\D+/', '', $Config->get('config_telephone')); ?>");
    }

    $().UItoTop();
});
</script>

