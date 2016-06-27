<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Checkin
 * @property checkin_model $checkin_model
 * @property mugclub_model $mugclub_model
 */

class Checkin extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('checkin_model');
        $this->load->model('mugclub_model');
    }

	public function index()
	{
		$data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

        //Getting All Mug Check-Ins List
        if($this->userType == SERVER_USER)
        {
            $mugData = $this->checkin_model->getAllTodayCheckInList();
        }
        else
        {
            $mugData = $this->checkin_model->getAllCheckInList();
        }

        $data['mugData'] = $mugData;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
		$data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
		$data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

		$this->load->view('MugCheckInView', $data);
	}

    public function addNewCheckIn()
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

        //Getting All Mug List
        $mugData = $this->mugclub_model->getCheckInMugClubList();

        /*if(isset($mugData['mugList']) && myIsArray($mugData['mugList']))
        {
            foreach($mugData['mugList'] as $key => $row)
            {
                if(myIsArray($row))
                {
                    $mugData['mugList'][$key]['locationName'] = $this->mydatafetch_library->getBaseLocationsById($row['homeBase']);
                }
            }
        }*/

        $data['mugData'] = $mugData;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

        $this->load->view('CheckInAddView', $data);
    }

    public function editExistingCheckin($id)
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }

        $muginfo = $this->checkin_model->getCheckInDataById($id);

        $data['mugInfo'] = $muginfo;

        $locations = $this->mydatafetch_library->getBaseLocations();
        $data['baseLocations'] = $locations;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

        $this->load->view('CheckInEditView', $data);
    }
    public function saveOrUpdateCheckIn($responseType = RESPONSE_RETURN)
    {
        $post = $this->input->post();

        if(!isset($post['baseLocation']))
        {
            $post['baseLocation'] = $this->currentLocation;
        }
        $params = $this->checkin_model->filterCheckInParameters($post);

        if(isset($post['checkId']))
        {
            $this->checkin_model->updateCheckInRecord($params);
        }
        else
        {
            $this->checkin_model->saveCheckInRecord($params);
        }

        if($responseType == RESPONSE_RETURN)
        {
            redirect(base_url().'check-ins');
        }
        else
        {
            $data['status'] = true;
            $data['pageUrl'] = base_url().'check-ins';
            echo json_encode($data);
        }

    }

    public function deleteMugCheckIn($Id)
    {
        $mugExists = $this->checkin_model->getCheckInDataById($Id);

        if($mugExists['status'] === false)
        {
            redirect(base_url().'check-ins');
        }
        else
        {
            $this->checkin_model->deleteCheckInRecord($Id);
        }
        redirect(base_url().'check-ins');
    }

    public function verifyCheckIn()
    {
        $post = $this->input->post();

        if(isset($post['mugNum']))
        {
            $verifyMugData = $this->mugclub_model->getMugDataById($post['mugNum']);

            echo json_encode($verifyMugData);
        }
        elseif(isset($post['mobNum']))
        {
            $verifyMugData = $this->mugclub_model->verifyMobileNo($post['mobNum']);

            echo json_encode($verifyMugData);
        }
    }
}
