<?php

/**
 * @author Inversiones Necoyoad, C.A.
 * @copyright 2010
 */

class ControllerEmailAddress extends Controller {
    public function index() {
        echo "<div><h3>".$this->config->get('config_name')."</h3>";
        echo "<p>".$this->config->get('config_rif')."</p>";
        echo "<p>".$this->config->get('config_address')."</p>";
        echo "<p>".$this->config->get('config_telephone')."</p>";
        echo "<a href='".$this->config->get('config_url')."index.php?'>".$this->config->get('config_url')."</a><br>";
        echo "<a href='http://twitter.com/".$this->config->get('twitter_time')."'>Twitter</a><br>";
        echo "<a href='http://www.facebook.com/profile.php?id=".$this->config->get('fblike_pageid')."'>Facebook</a><br>";
        echo "<a href='mailto:".$this->config->get('config_email')."'>".$this->config->get('config_email')."</a><br>";
        echo "</div>";
    }
    public function sign() {
        echo "<div><b>".$this->config->get('config_name')."</b>";
        echo "<p>".$this->config->get('config_address')." ";
        echo "Telf: ".$this->config->get('config_telephone')."</p>";
        echo "<a href='".$this->config->get('config_url')."index.php?'>".$this->config->get('config_url')."</a> ";
        echo "| <a href='http://twitter.com/".$this->config->get('twitter_time')."'>Twitter</a> ";
        echo "| <a href='http://www.facebook.com/profile.php?id=".$this->config->get('fblike_pageid')."'>Facebook</a> ";
        echo "| <a href='mailto:".$this->config->get('config_email')."'>".$this->config->get('config_email')."</a> ";
        echo "</div>";
    }
}

