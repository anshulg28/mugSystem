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
        $data['feedbacks']['kemps-corner'] = (int)(($promo['kemps-corner']/$total['kemps-corner'])*100 - ($de['kemps-corner']/$total['kemps-corner'])*100);

        $events = $this->dashboard_model->getAllEvents();

        if(isset($events) && myIsMultiArray($events))
        {
            foreach($events as $key => $row)
            {
                $loc = $this->locations_model->getLocationDetailsById($row['eventPlace']);
                $row['locData'] = $loc['locData'];
                $data['eventDetails'][$key]['eventData'] = $row;
                $data['eventDetails'][$key]['eventAtt'] = $this->dashboard_model->getEventAttById($row['eventId']);
            }
        }
        $data['completedEvents'] = $this->dashboard_model->findCompletedEvents();

        $fnb = $this->dashboard_model->getAllFnB();

        if(isset($fnb) && myIsMultiArray($fnb))
        {
            foreach($fnb['fnbItems'] as $key => $row)
            {
                $data['fnbData'][$key]['fnb']= $row;
                $data['fnbData'][$key]['fnbAtt'] = $this->dashboard_model->getFnbAttById($row['fnbId']);
            }
        }
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

        if(isset($post['attachment']) && isStringSet($post['attachment']))
        {
            $img_names = explode(',',$post['attachment']);
            for($i=0;$i<count($img_names);$i++)
            {
                $attArr = array(
                    'fnbId' => $fnbId,
                    'filename'=> $img_names[$i],
                    'attachmentType' => $post['itemType']
                );
                $this->dashboard_model->saveFnbAttachment($attArr);
            }
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
                $config['upload_path'] = './'.FOOD_PATH_THUMB; //'uploads/food/';
                if(isset($_POST['itemType']) && $_POST['itemType'] == '2')
                {
                    $config['upload_path'] = './'.BEVERAGE_PATH_THUMB; //uploads/beverage/';
                }
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '0';
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                $this->upload->do_upload('attachment');
                $upload_data = $this->upload->data();

                //$attchmentArr = $upload_data['full_path'];
                $attchmentArr= $upload_data['file_name'];// $this->image_thumb($upload_data['file_path'],$upload_data['file_name'], false);
                echo $attchmentArr;
            }
            else
            {
                echo 'Some Error Occurred!';
            }
        }
    }
    function image_thumb( $image_path, $img_name, $ifEvent)
    {
        $image_thumb = $image_path.'thumb/'.$img_name;

        //if ( !file_exists( $image_thumb ) ) {
            // LOAD LIBRARY
            $this->load->library( 'image_lib' );

            // CONFIGURE IMAGE LIBRARY
            $config['image_library']    = 'gd2';
            $config['source_image']     = $image_path.$img_name;
            $config['new_image']        = $image_thumb;
            $config['quality']          = 80;
            if($ifEvent === true)
            {
                $config['maintain_ratio']   = TRUE;
                $config['height']           = 480;
                $config['width']            = 690;
            }
            else
            {
                $config['maintain_ratio']   = FALSE;
                $config['height']           = 480;
                $config['width']            = 480;
            }
            $this->image_lib->initialize( $config );
            $this->image_lib->resize();
            $this->image_lib->clear();
        //}

        return $img_name;
    }
    public function uploadEventFiles()
    {
        $attchmentArr = '';
        $this->load->library('upload');
        if(isset($_FILES))
        {
            if($_FILES['attachment']['error'] != 1)
            {
                $config = array();
                $config['upload_path'] = './uploads/events/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '0';
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                $this->upload->do_upload('attachment');
                $upload_data = $this->upload->data();

                //$attchmentArr = $upload_data['full_path'];
                $attchmentArr= $this->image_thumb($upload_data['file_path'],$upload_data['file_name'], true);
                echo $attchmentArr;
            }
            else
            {
                echo 'Some Error Occurred!';
            }
        }
    }

    function saveEvent()
    {
        $post = $this->input->post();

        if(isset($post['attachment']))
        {
            $attachement = $post['attachment'];
            unset($post['attachment']);
        }
        $post['userId'] = $this->userId;
        $eventId = $this->dashboard_model->saveEventRecord($post);

        $eventShareLink = base_url().'mobile?page/events/EV-'.$eventId.'/'.encrypt_data('EV-'.$eventId);

        $details = array(
          'eventShareLink'=> $eventShareLink
        );
        $this->dashboard_model->updateEventRecord($details,$eventId);

        if(isset($attachement))
        {
            $img_names = explode(',',$attachement);
            for($i=0;$i<count($img_names);$i++)
            {
                $attArr = array(
                    'eventId' => $eventId,
                    'filename'=> $img_names[$i],
                    'attachmentType' => '1'
                );
                $this->dashboard_model->saveEventAttachment($attArr);
            }
        }

        redirect(base_url().'dashboard');

    }
    
    function editEvent($eventId)
    {
        $data = array();
        $events = $this->dashboard_model->getEventById($eventId);
        if(isset($events) && myIsMultiArray($events))
        {
            foreach($events as $key => $row)
            {
                $data['eventInfo'][$key]['eventData'] = $row;
                $data['eventInfo'][$key]['eventAtt'] = $this->dashboard_model->getEventAttById($row['eventId']);
            }
        }

        $locArray = $this->locations_model->getAllLocations();
        $data['locations'] = $locArray;
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

        $this->load->view('EventEditView', $data);
    }

    function updateEvent()
    {
        $post = $this->input->post();

        if(isset($post['attachment']))
        {
            $attachement = $post['attachment'];
            unset($post['attachment']);
        }
        $eventId = $post['eventId'];
        unset($post['eventId']);
        $this->dashboard_model->updateEventRecord($post,$eventId);

        if(isset($attachement) && $attachement != '')
        {
            $img_names = explode(',',$attachement);
            for($i=0;$i<count($img_names);$i++)
            {
                $attArr = array(
                    'eventId' => $eventId,
                    'filename'=> $img_names[$i],
                    'attachmentType' => '1'
                );
                $this->dashboard_model->saveEventAttachment($attArr);
            }
        }

        redirect(base_url().'dashboard');

    }

    function eventEmailApprove($sName, $sEmail, $eventId)
    {
        $this->userName = $sName;
        $this->userEmail = $sEmail;
        $this->eventApprove($eventId);
        $data['msg'] = 'Event Approved!';
        $this->load->view('PageThankYouView',$data);
    }
    function eventEmailDecline($sName, $sEmail, $eventId)
    {
        $this->userName = $sName;
        $this->userEmail = $sEmail;
        $this->eventDecline($eventId);
        $data['msg'] = 'Event Declined!';
        $this->load->view('PageThankYouView',$data);
    }
    function eventApproved($eventId)
    {
        $this->eventApprove($eventId);
        redirect(base_url().'dashboard');
    }
    function eventDeclined($eventId)
    {
        $this->eventDecline($eventId);
        redirect(base_url().'dashboard');
    }

    function eventApprove($eventId)
    {
        $eventDetail = $this->dashboard_model->getFullEventInfoById($eventId);

        if(isset($eventDetail[0]['eventPaymentLink']) && isStringSet($eventDetail[0]['eventPaymentLink']))
        {
            $this->dashboard_model->ApproveEvent($eventId);
            $senderName = 'Doolally';
            $senderEmail = 'events@doolally.in';
            if(isStringSet($this->userEmail) && isStringSet($this->userName))
            {
                $senderEmail = $this->userEmail;
                $senderName = $this->userName;
            }
            $eventDetail['senderName'] = $senderName;
            $eventDetail['senderEmail'] = $senderEmail;
            $this->sendemail_library->eventApproveMail($eventDetail);
        }
        else
        {
            $instaImgLink = $this->curl_library->getInstaImageLink();
            $donePost = array();
            if($instaImgLink['success'] === true)
            {
                $coverImg =  $this->curl_library->uploadInstaImage($instaImgLink['upload_url'],$eventDetail[0]['filename']);
                if(isset($coverImg) && myIsMultiArray($coverImg) && isset($coverImg['url']))
                {
                    $postData = array(
                        'title' => $eventDetail[0]['eventName'],
                        'description' => $eventDetail[0]['eventDescription'],
                        'currency' => 'INR',
                        'base_price' => $eventDetail[0]['eventPrice'],
                        'start_date' => $eventDetail[0]['eventDate'].' '.$eventDetail[0]['startTime'],
                        'end_date' => $eventDetail[0]['eventDate'].' '.$eventDetail[0]['endTime'],
                        'venue' => $eventDetail[0]['locName'].', Doolally Taproom',
                        'redirect_url' => base_url().'mobile?event='.$eventDetail[0]['eventId'].'&hash='.encrypt_data('EV-'.$eventDetail[0]['eventId']),
                        'cover_image_json' => json_encode($coverImg),
                        'timezone' => 'Asia/Kolkata'
                    );
                    $donePost = $this->curl_library->createInstaLink($postData);
                }
            }

            if(!myIsMultiArray($donePost))
            {
                $postData = array(
                    'title' => $eventDetail[0]['eventName'],
                    'description' => $eventDetail[0]['eventDescription'],
                    'currency' => 'INR',
                    'base_price' => $eventDetail[0]['eventPrice'],
                    'start_date' => $eventDetail[0]['eventDate'].' '.$eventDetail[0]['startTime'],
                    'end_date' => $eventDetail[0]['eventDate'].' '.$eventDetail[0]['endTime'],
                    'venue' => $eventDetail[0]['locName'].', Doolally Taproom',
                    'redirect_url' => base_url().'mobile?event='.$eventDetail[0]['eventId'].'&hash='.encrypt_data('EV-'.$eventDetail[0]['eventId']),
                    'timezone' => 'Asia/Kolkata'
                );
                $donePost = $this->curl_library->createInstaLink($postData);
            }
            $this->dashboard_model->ApproveEvent($eventId);
            $senderName = 'Doolally';
            $senderEmail = 'events@doolally.in';
            if(isStringSet($this->userEmail) && isStringSet($this->userName))
            {
                $senderEmail = $this->userEmail;
                $senderName = $this->userName;
            }
            $eventDetail['senderName'] = $senderName;
            $eventDetail['senderEmail'] = $senderEmail;
            $this->sendemail_library->eventApproveMail($eventDetail);
            $details = array();
            if(isset($donePost['link']['shorturl']))
            {
                $details = array(
                    'eventPaymentLink' => $donePost['link']['shorturl'],
                    'eventSlug' => $donePost['link']['slug']
                );
            }
            else
            {
                $details = array(
                    'eventPaymentLink' => $donePost['link']['url'],
                    'eventSlug' => $donePost['link']['slug']
                );
            }
            $this->dashboard_model->updateEventRecord($details, $eventDetail[0]['eventId']);
        }

    }
    function eventDecline($eventId)
    {
        $eventDetail = $this->dashboard_model->getFullEventInfoById($eventId);
        $this->dashboard_model->DeclineEvent($eventId);
        $senderName = 'Doolally';
        $senderEmail = 'events@doolally.in';
        if(isStringSet($this->userEmail) && isStringSet($this->userName))
        {
            $senderName = $this->userName;
            $senderEmail = $this->userEmail;
        }
        $eventDetail['senderName'] = $senderName;
        $eventDetail['senderEmail'] = $senderEmail;
        $this->sendemail_library->eventDeclineMail($eventDetail);
    }
    function setEventDeActive($eventId)
    {
        $this->dashboard_model->deActivateEventRecord($eventId);
        redirect(base_url().'dashboard');
    }
    function setEventActive($eventId)
    {
        $this->dashboard_model->activateEventRecord($eventId);
        redirect(base_url().'dashboard');
    }
    function deleteEvent($eventId)
    {
        $this->dashboard_model->eventDelete($eventId);
        redirect(base_url().'dashboard');
    }
    function deleteCompEvent($eventId)
    {
        $this->dashboard_model->eventCompDelete($eventId);
        redirect(base_url().'dashboard');
    }
    function deleteEventAtt()
    {
        $post = $this->input->post();
        $picId = $post['picId'];
        $this->dashboard_model->eventAttDelete($picId);
        $data['status'] = true;
        echo json_encode($data);
    }

    //For Fnb Section
    function setFnbActive($fnbId)
    {
        $this->dashboard_model->activateFnbRecord($fnbId);
        redirect(base_url().'dashboard');
    }
    function setFnbDeActive($fnbId)
    {
        $this->dashboard_model->DeActivateFnbRecord($fnbId);
        redirect(base_url().'dashboard');
    }
    function deleteFnb($fnbId)
    {
        $this->dashboard_model->fnbDelete($fnbId);
        redirect(base_url().'dashboard');
    }
    function editFnb($fnbId)
    {
        $data = array();
        $fnb = $this->dashboard_model->getFnBById($fnbId);
        if(isset($fnb) && myIsMultiArray($fnb))
        {
            foreach($fnb as $key => $row)
            {
                $data['fnbInfo'][$key]['fnbData'] = $row;
                $data['fnbInfo'][$key]['fnbAtt'] = $this->dashboard_model->getFnbAttById($row['fnbId']);
            }
        }
        
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

        $this->load->view('FnbEditView', $data);
    }
    function deleteFnbAtt()
    {
        $post = $this->input->post();
        $picId = $post['picId'];
        $this->dashboard_model->fnbAttDelete($picId);
        $data['status'] = true;
        echo json_encode($data);
    }
    public function updatefnb()
    {
        $post = $this->input->post();
        $details = array(
            'itemType'=> $post['itemType'],
            'itemName' => $post['itemName'],
            'itemDescription' => $post['itemDescription'],
            'priceFull' => $post['priceFull'],
            'priceHalf' => $post['priceHalf']
        );
        $this->dashboard_model->updateFnbRecord($details,$post['fnbId']);

        if(isset($post['attachment']) && isStringSet($post['attachment']))
        {
            $img_names = explode(',',$post['attachment']);
            for($i=0;$i<count($img_names);$i++)
            {
                $attArr = array(
                    'fnbId' => $post['fnbId'],
                    'filename'=> $img_names[$i],
                    'attachmentType' => $post['itemType']
                );
                $this->dashboard_model->saveFnbAttachment($attArr);
            }
        }
        redirect(base_url().'dashboard');

    }
}
