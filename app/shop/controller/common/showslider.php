<?php  
class ControllerCommonShowslider extends Controller {
	public function index() {
        $this->load->model("catalog/slider");
        $this->load->library("image");
        //$this->data['sliders'] = $this->model_catalog_slider->getAll();
        $model = $this->model_catalog_slider->getAll();
        foreach ($model->rows as $slider) {
            $sliders = new stdClass();
            $sliders->slider_id = $slider['slider_id'];
            $sliders->title     = $slider['title'];
            $sliders->link      = $slider['link'];
            $sliders->image     = $slider['image'];
            $sliders->thumb     = NTImage::resizeAndSave($slider['image'],95,64);
            $this->data['sliders'][] = $sliders;
        }
            
        $styles[] = array('media'=>'screen','href'=>'assets/css/sliders/nivo-slider.css');
        $this->styles = array_merge($this->styles, $styles);
        // javascript files
        $jspath = defined("CDN") ? CDN_JS : HTTP_JS;
            
        $javascripts[] = $jspath."necojs/neco.carousel.js";
        $javascripts[] = $jspath."vendor/jquery.nivo.slider.pack.js";
            
        $this->javascripts = array_merge($this->javascripts, $javascripts);
            
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/showslider.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/showslider.tpl';
		} else {
			$this->template = 'default/common/showslider.tpl';
		}
        
		$this->id = 'showslider';
        
		$this->render();
      }
}
