<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 * @property generalfunction_library $generalfunction_library
 * @property locations_model $locations_model
 */

class Home extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('locations_model');
    }

    public function index()
	{
/*        if(!isset($this->currentLocation) || isSessionVariableSet($this->currentLocation) === false)
        {
            if($this->userType != GUEST_USER)
            {
                redirect(base_url().'location-select');
            }
        }*/

		$data = array();
		$data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
		$data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
		$data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        if(isSessionVariableSet($this->isUserSession) === true)
        {
            $data['title'] = 'Home :: Doolally';
        }
        else
        {
            $data['title'] = 'Login :: Doolally';
        }
		$this->load->view('HomeView', $data);
	}

    public function main()
    {
        $data = array();
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('MainView', $data);
    }
    public function getLocation()
    {
        $data = array();
        if(isset($this->session->page_url))
        {
            $data['pageUrl']= $this->session->page_url;
            $this->session->unset_userdata('page_url');
        }

        $data['locData'] = $this->locations_model->getAllLocations();
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('LocSelectView', $data);
    }

    public function setLocation()
    {
        $post = $this->input->post();

        $this->generalfunction_library->setSessionVariable("currentLocation",$post['currentLoc']);
        if(isset($post['pageUrl']))
        {
            redirect($post['pageUrl']);
        }
        else
        {
            redirect(base_url());
        }

    }
}
