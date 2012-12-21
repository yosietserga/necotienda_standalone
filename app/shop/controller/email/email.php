<?php

/**
 * @author Inversiones Necoyoad, C.A.
 * @copyright 2010
 */

class ControllerEmailEmail extends Controller {
    public function index() {
        echo "<a href='mailto:".$this->config->get('config_email')."'>".$this->config->get('config_email')."</a>";
    }
}

