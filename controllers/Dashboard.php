<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property generalfunction_library $generalfunction_library
 * @property Dashboard_Model $dashboard_model
 * @property Mugclub_Model $mugclub_model
 * @property Users_Model $users_model
 * @property  Locations_Model $locations_model
 */

class Dashboard extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->model('mugclub_model');
        $this->load->model('users_model');
        $this->load->model('locations_model');
    }

    public function index()
	{
        if(isSessionVariableSet($this->isUserSession) === false || $this->userType == SERVER_USER)
        {
            redirect(base_url());
        }

		$data = array();

        $locArray = $this->locations_model->getAllLocations();
        $data['locations'] = $locArray;
        if($this->userType == EXECUTIVE_USER)
        {
            $userInfo = $this->users_model->getUserDetailsById($this->userId);
            $allLocs = explode(',',$userInfo['userData'][0]['assignedLoc']);

            foreach($allLocs as $key)
            {
                $data['userInfo'][$key] = $this->locations_model->getLocationDetailsById($key);
            }
        }
        //Dashboard Data
        $startDate = date('Y-m-d', strtotime('-1 month'));
        $endDate = date('Y-m-d');
        $data['totalMugs'] = $this->mugclub_model->getAllMugsCount();
        $data['avgChecks'] = $this->dashboard_model->getAvgCheckins($startDate,$endDate,$locArray);
        $data['Regulars'] = $this->dashboard_model->getRegulars($startDate,$endDate,$locArray);
        $data['Irregulars'] = $this->dashboard_model->getIrregulars($startDate,$endDate,$locArray);
        $data['lapsers'] = $this->dashboard_model->getLapsers($startDate,$endDate,$locArray);

        $graphData = $this->dashboard_model->getAllDashboardRecord();
        if($graphData['status'] === true)
        {
            foreach($graphData['dashboardPoints'] as $key => $row)
            {
                $data['graph']['avgChecks'][$key] = $row['avgCheckins'];
                $data['graph']['regulars'][$key] = $row['regulars'];
                $data['graph']['irregulars'][$key] = $row['irregulars'];
                $data['graph']['lapsers'][$key] = $row['lapsers'];
                $d = date_create($row['insertedDate']);
                $data['graph']['labelDate'][$key] = date_format($d,DATE_FORMAT_GRAPH_UI);
            }
        }

        //Instamojo Records
        $data['instamojo'] = $this->dashboard_model->getAllInstamojoRecord();

		$data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
		$data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
		$data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);


		$this->load->view('DashboardView', $data);
	}

    public function getCustomStats()
    {
        $post = $this->input->post();

        $locArray = $this->locations_model->getAllLocations();

        $startDate = $post['startDate'];
        $endDate = $post['endDate'];

        $data['totalMugs'] = $this->mugclub_model->getAllMugsCount();
        $data['avgChecks'] = $this->dashboard_model->getAvgCheckins($startDate,$endDate,$locArray);
        $data['Regulars'] = $this->dashboard_model->getRegulars($startDate,$endDate,$locArray);
        $data['Irregulars'] = $this->dashboard_model->getIrregulars($startDate,$endDate,$locArray);
        $data['lapsers'] = $this->dashboard_model->getLapsers($startDate,$endDate,$locArray);

        echo json_encode($data);

    }

    public function saveRecord()
    {
        $post = $this->input->post();

        $gotData = $this->dashboard_model->getDashboardRecord();
        if($gotData['status'] === false)
        {
            $this->dashboard_model->saveDashboardRecord($post);
        }
        $data['status'] = true;
        echo json_encode($data);
    }

    public function instaMojoRecord()
    {
        $post = $this->input->post();
        // Get the MAC from the POST data
        if(isset($post['mac']))
        {
            $mac_provided = $post['mac'];
            unset($post['mac']);
            $ver = explode('.', phpversion());
            $major = (int) $ver[0];
            $minor = (int) $ver[1];
            if($major >= 5 and $minor >= 4){
                ksort($post, SORT_STRING | SORT_FLAG_CASE);
            }
            else{
                uksort($post, 'strcasecmp');
            }

            $mac_calculated = hash_hmac("sha1", implode("|", $post), "34e1f545c8f7745c624752d319ae9b26");
            if($mac_provided == $mac_calculated){
                if($post['status'] == "Credit"){

                    $mugNum = '';
                    $custom_array = json_decode($post['custom_fields'],true);
                    foreach($custom_array as $key => $row)
                    {
                        $mugNum = $row['value'];
                    }

                    $details = array(
                        "mugId" => $mugNum,
                        "buyerName" => $post['buyer_name'],
                        "buyerEmail" => $post['buyer'],
                        "price" => $post['amount'],
                        "paymentId" => $post['payment_id'],
                        "status" => 1,
                        "isApproved" => 0,
                        "insertedDT" => date('Y-m-d H:i:s')
                    );
                    $this->dashboard_model->saveInstaMojoRecord($details);
                    echo 'Saved with success';
                }
                else{
                    $mugNum = '';
                    $custom_array = json_decode($post['custom_fields'],true);
                    foreach($custom_array as $key => $row)
                    {
                        $mugNum = $row['value'];
                    }

                    $details = array(
                        "mugId" => $mugNum,
                        "buyerName" => $post['buyer_name'],
                        "buyerEmail" => $post['buyer'],
                        "price" => $post['amount'],
                        "paymentId" => $post['payment_id'],
                        "status" => 1,
                        "isApproved" => 0,
                        "insertedDT" => date('Y-m-d H:i:s')
                    );
                    $this->dashboard_model->saveInstaMojoRecord($details);
                    echo 'Saved with failed';
                }
            }
            else{
                echo "MAC mismatch";
            }
        }
        else
        {
            echo "MAC Not Found!";
        }
    }

}
