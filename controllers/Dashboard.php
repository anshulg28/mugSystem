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
        ini_set('memory_limit', "256M");
        ini_set('upload_max_filesize', "50M");
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

        $feedbacks = $this->dashboard_model->getAllFeedbacks($locArray);

        foreach($feedbacks['feedbacks'][0] as $key => $row)
        {
            $keySplit = explode('_',$key);
            switch($keySplit[0])
            {
                case 'total':
                    $total[$keySplit[1]] = (int)$row;
                    break;
                case 'promo':
                    $promo[$keySplit[1]] = (int)$row;
                    break;
                case 'de':
                    $de[$keySplit[1]] = (int)$row;
                    break;
            }
        }
        
        $data['feedbacks']['overall'] = (int)(($promo['overall']/$total['overall'])*100 - ($de['overall']/$total['overall'])*100);
        $data['feedbacks']['bandra'] = (int)(($promo['bandra']/$total['bandra'])*100 - ($de['bandra']/$total['bandra'])*100);
        $data['feedbacks']['andheri'] = (int)(($promo['andheri']/$total['andheri'])*100 - ($de['andheri']/$total['andheri'])*100);


        //$data['feedbacks'];
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

    public function setInstamojoDone($responseType = RESPONSE_JSON,$id)
    {
        $details = array("isApproved"=>1);
        $this->dashboard_model->updateInstaMojoRecord($id,$details);

        $data['status'] = true;
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($data);
        }
        else
        {
            return $data;
        }
    }

    public function saveFeedback($responseType = RESPONSE_RETURN)
    {
        $post = $this->input->post();

        if(isSessionVariableSet($this->isUserSession) === false || $this->userType == SERVER_USER)
        {
            if($responseType == RESPONSE_JSON)
            {
                $data['status'] = false;
                $data['pageUrl'] = base_url();
            }
            else
            {
                redirect(base_url());
            }

        }
        $post['overallRating'] = array_values($post['overallRating']);
        $post['userGender'] = array_values($post['userGender']);
        $post['userAge'] = array_values($post['userAge']);
        $post['feedbackLoc'] = array_values($post['feedbackLoc']);

        $insert_values = array();
        for($i=0;$i<count($post['overallRating']);$i++)
        {
            if($post['overallRating'][$i] != '')
            {
                $insert_values[] = array(
                    'overallRating' => $post['overallRating'][$i],
                    'userGender' => $post['userGender'][$i],
                    'userAge' => $post['userAge'][$i],
                    'feedbackLoc' => $post['feedbackLoc'][$i],
                    'insertedDateTime' => date('Y-m-d H:i:s')
                );
            }
        }
        $this->dashboard_model->insertFeedBack($insert_values);

        if($responseType == RESPONSE_JSON)
        {
            $data['status'] = true;
            echo json_encode($data);
        }
        else
        {
            redirect(base_url().'dashboard');
        }

    }

    public function savefnb()
    {
        $post = $this->input->post();

        $details = array(
            'itemType'=> $post['itemType'],
            'itemName' => $post['itemName'],
            'itemDescription' => $post['itemDescription'],
            'priceFull' => $post['priceFull'],
            'priceHalf' => $post['priceHalf'],
            'insertedBy' => $this->userId
        );
        $fnbId = $this->dashboard_model->saveFnbRecord($details);

        $img_names = explode(',',$post['attachment']);
        foreach($img_names as $key)
        {
            $attArr = array(
                'fnbId' => $fnbId,
                'filename'=> $key,
                'attachmentType' => $post['attType']
            );
            $this->dashboard_model->saveFnbAttachment($attArr);
        }

        redirect(base_url().'dashboard');

    }
    public function uploadFiles()
    {
        $attchmentArr = '';
        $this->load->library('upload');
        if(isset($_FILES))
        {
            if($_FILES['attachment']['error'] != 1)
            {
                $config = array();
                $config['upload_path'] = './uploads/food/';
                if(isset($_POST['itemType']) && $_POST['itemType'] == '3')
                {
                    $config['upload_path'] = './uploads/beverage/';
                }
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '0';
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                $this->upload->do_upload('attachment');
                $upload_data = $this->upload->data();

                //$attchmentArr = $upload_data['full_path'];
                $attchmentArr= $this->image_thumb($upload_data['file_path'],$upload_data['file_name']);
                echo $attchmentArr;
            }
            else
            {
                echo 'Some Error Occurred!';
            }
        }
    }
    function image_thumb( $image_path, $img_name )
    {
        $image_thumb = $image_path.'thumb/'.$img_name;

        if ( !file_exists( $image_thumb ) ) {
            // LOAD LIBRARY
            $this->load->library( 'image_lib' );

            // CONFIGURE IMAGE LIBRARY
            $config['image_library']    = 'gd2';
            $config['source_image']     = $image_path.$img_name;
            $config['new_image']        = $image_thumb;
            $config['maintain_ratio']   = TRUE;
            $config['quality']          = 80;
            $config['height']           = 480;
            $config['width']            = 690;
            $this->image_lib->initialize( $config );
            $this->image_lib->resize();
            $this->image_lib->clear();
        }

        return $img_name;
    }
}
