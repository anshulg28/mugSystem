<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Mobile
 * @property Login_Model $login_model
*/

class Mobile extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
	}
	public function index()
	{
        $data = array();
        $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
        $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);

        $this->load->view('MobileHomeView', $data);
	}

    public function about()
    {
        $data = array();
/*        $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
        $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);*/

        $aboutView = $this->load->view('AboutUsView', $data);
        echo json_encode($aboutView);
    }
}
