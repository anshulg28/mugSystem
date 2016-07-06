<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property generalfunction_library $generalfunction_library
 * @property Dashboard_Model $dashboard_model
 * @property Mugclub_Model $mugclub_model
 */

class Dashboard extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('mugclub_model');
    }

    public function index()
	{
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

		$data = array();

        //Dashboard Data
        $data['totalMugs'] = $this->mugclub_model->getAllMugsCount();
        $data['avgChecks'] = $this->dashboard_model->getAvgCheckins();
        

		$data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
		$data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
		$data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);


		$this->load->view('DashboardView', $data);
	}


}
