<?php
class ControllerCommonFooter extends Controller {   
	protected function index() {
		$this->load->language('common/footer');
		
		$this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);
		
		$this->id       = 'footer';
		$this->template = 'common/footer.tpl';
	
        // SCRIPTS
        $scripts[] = array('id'=>'footer','method'=>'function','script'=>
            "function sendFeedback() {
                $.post('". Url::createAdminUrl("support/feedback") ."',$('#feedbackForm').serialize(),function(response) {
                    var data = $.parseJSON(response);
                    if (data.success) {
                        alert(data.msg);
                    }
                    if (data.error) {
                        alert(data.msg);
                    }
                });
            }");
        $scripts[] = array('id'=>'footerScripts','method'=>'ready','script'=>
            "$('#formFilter').hide();
            
            setTimeout(function(){
                $('.message').fadeOut('slow');
            },5000);
            
            var preloader = $('#gridPreloader');
            
            if (preloader.length > 0) {
                var cl = new CanvasLoader('gridPreloader');
          		cl.setColor('#858585');
          		cl.setDiameter(72);
          		cl.setDensity(78);
          		cl.setRange(1);
          		cl.show();
            }
            
            $('#filters').on('click',function(){
                if ($(this).hasClass('show')) {
                    $('#formFilter').slideUp();
                    $(this).removeClass('show').addClass('hidded').text('[ Mostrar ]');
                } else {
                    $('#formFilter').slideDown();
                    $(this).removeClass('hidded').addClass('show').text('[ Ocultar ]');
                }
            });");
        $this->scripts = array_merge($this->scripts,$scripts);
        
        $r_output = $w_output = $s_output = $f_output = "";
        $script_keys = array();
        foreach ($this->scripts as $k => $script) { 
            if (in_array($script['id'],$script_keys)) continue;
            $script_keys[$k] = $script['id'];
            switch($script['method']) {
                case 'ready':
                default:
                    $r_output .= $script['script'];
                    break;
                case 'window':
                    $w_output .= $script['script'];
                    break;
                case 'function':
                    $f_output .= $script['script'];
                    break;
            }
        } 
        
        $this->data['scripts'] = ($r_output) ? "<script>$(function() { ".$r_output." });</script>" : "";
        $this->data['scripts'] .= ($w_output) ? "<script>window.onload = function() { ".$w_output."  };</script>" : "";
        $this->data['scripts'] .= ($f_output) ? "<script>".$f_output."</script>" : "";
        
        // javascript files
        
        $javascripts[] = "js/plugins.js";
        $javascripts[] = "js/main.js";
        $javascripts[] = "js/necojs/neco.form.js";
        
        $this->data['javascripts'] = $this->javascripts = array_merge($javascripts,$this->javascripts);
        
    	$this->render();
  	}
}