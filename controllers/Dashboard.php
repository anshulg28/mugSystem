<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Home
 * @property generalfunction_library $generalfunction_library
 * @property Offers_Model $offers_model
 */

class Home extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('offers_model');
    }

    public function index()
	{
        if(!isset($this->currentLocation) || isSessionVariableSet($this->currentLocation) === false)
        {
            redirect(base_url().'location-select');
        }

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


}
