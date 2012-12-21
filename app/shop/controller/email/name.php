<?php    
class ControllerEmailName extends Controller { 
    public function index() {
        echo "<a href='".$this->config->get('config_url')."index.php?'>".$this->config->get('config_name')."</a>";
    }
}

