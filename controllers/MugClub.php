<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Mugclub
 * @property mugclub_model $mugclub_model
 */

class Mugclub extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('mugclub_model');
    }
	public function index()
	{
        $data = array();
		if(isSessionVariableSet($this->isUserSession) === false)
		{
			redirect(base_url());
		}

        //Getting All Mug List
        $mugData = $this->mugclub_model->getAllMugClubList();

        if(isset($mugData['mugList']) && myIsArray($mugData['mugList']))
        {
            foreach($mugData['mugList'] as $key => $row)
            {
                if(myIsArray($row))
                {
                    $mugData['mugList'][$key]['locationName'] = $this->mydatafetch_library->getBaseLocationsById($row['homeBase']);
                }
            }
        }

        $data['mugData'] = $mugData;


		$data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
		$data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
		$data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        
		$this->load->view('MugClubView', $data);
	}

    public function addNewMug()
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

        $locations = $this->mydatafetch_library->getBaseLocations();
        $data['baseLocations'] = $locations;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('MugAddView', $data);
    }

    public function editExistingMug($mugId)
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

        $muginfo = $this->mugclub_model->getMugDataById($mugId);

        $data['mugInfo'] = $muginfo;

        $locations = $this->mydatafetch_library->getBaseLocations();
        $data['baseLocations'] = $locations;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('MugEditView', $data);
    }

    public function saveOrUpdateMug()
    {
        $post = $this->input->post();

        $mugExists = $this->mugclub_model->getMugDataById($post['mugNum']);

        $params = $this->mugclub_model->filterMugParameters($post);
        
        if($mugExists['status'] === false)
        {
            $this->mugclub_model->saveMugRecord($params);
        }
        else
        {
            $this->mugclub_model->updateMugRecord($params);
        }
        redirect(base_url().'mugclub');
    }

    public function deleteMugData($mugId)
    {
        $mugExists = $this->mugclub_model->getMugDataById($mugId);

        if($mugExists['status'] === false)
        {
            redirect(base_url().'mugclub');
        }
        else
        {
            $this->mugclub_model->deleteMugRecord($mugId);
        }
        redirect(base_url().'mugclub');
    }

    public function MugAvailability($responseType = RESPONSE_JSON, $mugid)
    {
        $data = array();
        if(isset($mugid))
        {
            $result = $this->mugclub_model->getMugDataById($mugid);
            if($result['status'] === true)
            {
                $data['status'] = false;
                $data['errorMsg'] = 'Mug Number Already Exists';
            }
            else
            {
                $data['status'] = true;
            }
        }

        //returning the response
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($data);
        }
        else
        {
            return $data;
        }
    }

    public function CheckMobileNumber($responseType = RESPONSE_JSON, $mobNo)
    {
        $data = array();
        if(isset($mobNo))
        {
            $result = $this->mugclub_model->verifyMobileNo($mobNo);
            if($result['status'] === true)
            {
                $data['status'] = false;
                $data['errorMsg'] = 'Mobile Number Already Exists';
            }
            else
            {
                $data['status'] = true;
            }
        }

        //returning the response
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($data);
        }
        else
        {
            return $data;
        }
    }
}
