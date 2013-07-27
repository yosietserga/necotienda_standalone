<?php 
class ControllerMarketingCampaign extends Controller {
	public function index() {
	   $this->trace();
	   $this->redirect(HTTP_HOME);
	}
    
	public function trace() {
	   $campaign_id = ($this->request->hasQuery('campaign_id')) ? $this->request->getQuery('campaign_id') : null;
	   $contact_id = ($this->request->hasQuery('contact_id')) ? $this->request->getQuery('contact_id') : null;
       if ($campaign_id && $contact_id) {
            $this->load->model('marketing/campaign');
            $this->modelCampaign->trackEmail($campaign_id, $contact_id);
       }
	}
    
	public function link() {
	   $campaign_id = ($this->request->hasQuery('campaign_id')) ? $this->request->getQuery('campaign_id') : null;
	   $contact_id = ($this->request->hasQuery('contact_id')) ? $this->request->getQuery('contact_id') : null;
	   $link_index = ($this->request->hasQuery('link_index')) ? $this->request->getQuery('link_index') : null;
       if ($campaign_id && $contact_id) {
            $this->load->model('marketing/campaign');
            $this->modelCampaign->trackLink($campaign_id, $contact_id, $link_index);
            $this->redirect($this->modelCampaign->getLink($link_index));
       }
	}
}
