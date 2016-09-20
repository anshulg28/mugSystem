<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
 * @property cron_model $cron_model
 * @property dashboard_model $dashboard_model
 * @property locations_model $locations_model
 * @property login_model $login_model
 * @property users_model $users_model
*/

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('cron_model');
        $this->load->model('dashboard_model');
        $this->load->model('locations_model');
        $this->load->model('users_model');
	}
	public function index()
	{
        $data = array();

        $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
        $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);

        $data['myFeeds'] = $this->returnAllFeeds();
        $newFnb = $this->dashboard_model->getAllActiveFnB();
        if($newFnb['status'] === true)
        {
            foreach($newFnb['fnbItems'] as $key => $row)
            {
                $data['fnb'][$key]['item'] = $row;
                $data['fnb'][$key]['att'] = $this->dashboard_model->getFnbAttById($row['fnbId']);
            }
        }
        $events = $this->dashboard_model->getAllApprovedEvents();
        usort($events,
            function($a, $b) {
                $ts_a = strtotime($a['eventDate']);
                $ts_b = strtotime($b['eventDate']);

                return $ts_a > $ts_b;
            }
        );

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
        if(isStringSet($_SERVER['QUERY_STRING']))
        {
            $query = explode('/',$_SERVER['QUERY_STRING']);
            if(isset($query[1]) && $query[1] == 'events')
            {
                if(isset($query[2]))
                {
                    $event = explode('-',$query[2]);
                    $eventData = $this->dashboard_model->getEventById($event[1]);
                    $eventAtt = $this->dashboard_model->getEventAttById($event[1]);
                    $data['meta']['title'] = $eventData[0]['eventName'];
                    $truncated_RestaurantName = (strlen(strip_tags($eventData[0]['eventDescription'])) > 140) ? substr(strip_tags($eventData[0]['eventDescription']), 0, 140) . '..' : strip_tags($eventData[0]['eventDescription']);
                    $data['meta']['description'] = $truncated_RestaurantName;
                    $data['meta']['link'] = $eventData[0]['eventShareLink'];
                    $data['meta']['img'] = $eventAtt[0]['filename'];

                }
            }
        }
        /*if ($this->mobile_detect->isAndroidOS()) {

            $data['androidStyle'] = $this->dataformatinghtml_library->getAndroidStyleHtml($data);
            $data['androidJs'] = $this->dataformatinghtml_library->getAndroidJsHtml($data);
            $this->load->view('mobile/android/MobileHomeView', $data);
        }
        else
        {
            $data['iosStyle'] = $this->dataformatinghtml_library->getIosStyleHtml($data);
            $data['iosJs'] = $this->dataformatinghtml_library->getIosJsHtml($data);
            $this->load->view('mobile/ios/MobileHomeView', $data);
        }*/
        $data['iosStyle'] = $this->dataformatinghtml_library->getIosStyleHtml($data);
        $data['iosJs'] = $this->dataformatinghtml_library->getIosJsHtml($data);
        $this->load->view('mobile/ios/MobileHomeView', $data);
	}

    public function about()
    {
        $data = array();

        if($this->session->userdata('osType') == 'android')
        {
            $aboutView = $this->load->view('mobile/ios/AboutUsView', $data);
        }
        else
        {
            $aboutView = $this->load->view('mobile/android/AboutUsView', $data);
        }
        echo json_encode($aboutView);
    }
    public function eventFetch($eventId, $evenHash)
    {
        $data = array();

        if(hash_compare(encrypt_data($eventId),$evenHash))
        {
            $decodedS = explode('-',$eventId);
            $eventId = $decodedS[count($decodedS)-1];
            $events = $this->dashboard_model->getEventById($eventId);
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

            $aboutView = $this->load->view('mobile/ios/EventView', $data);

            echo json_encode($aboutView);
        }
        else
        {
            $pgError = $this->load->view('mobile/ios/EventView', $data);
            echo json_encode($pgError);
        }
    }

    public function createEvent()
    {
        $data = array();

        $data['eventTc'] = $this->config->item('eventTc');// $this->load->view('mobile/ios/EventTcView', $data);
        $data['locData'] = $this->locations_model->getAllLocations();
        
        $aboutView = $this->load->view('mobile/ios/EventAddView', $data);

        echo json_encode($aboutView);

    }

    public function myEvents()
    {
        $data = array();
        if(isSessionVariableSet($this->isMobUserSession) === false)
        {
            $data['status'] = false;
        }
        else
        {
            $data['status'] = true;
            $data['userEvents'] = $this->dashboard_model->getEventsByUserId($this->userMobId);
        }

        $eventView = $this->load->view('mobile/ios/MyEventsView', $data);

        echo json_encode($eventView);

    }
    public function checkUser()
    {
        $this->load->model('login_model');
        $post = $this->input->post();

        $data = array();
        $userInfo = $this->login_model->checkAppUser($post['username'], md5($post['password']));

        if($userInfo['status'] === true)
        {
            if($userInfo['userData']['ifActive'] == NOT_ACTIVE)
            {
                $data['status'] = false;
                $data['errorMsg'] = 'User Account is Disabled!';
            }
            else
            {
                $data['status'] = true;
                $userId = $userInfo['userData']['userId'];
                $this->login_model->setLastLogin($userId);
                $this->generalfunction_library->setMobUserSession($userId);
            }
        }
        else
        {
            $data['status'] = false;
            $data['errorMsg'] = 'Email or Password is wrong!';
        }
        echo json_encode($data);
    }

    public function appLogout()
    {
        $this->session->unset_userdata('user_mob_id');
        $this->session->unset_userdata('user_mob_type');
        $this->session->unset_userdata('user_mob_name');
        $this->session->unset_userdata('user_mob_email');
        $this->session->unset_userdata('user_mob_firstname');

        $data['status'] = true;
        echo json_encode($data);
    }
    public function saveEvent()
    {
        $this->load->model('login_model');
        $post = $this->input->post();
        $userId = '';

        if(isset($post['creatorPhone']) && isset($post['creatorEmail']))
        {
            $userStatus = $this->checkPublicUser($post['creatorEmail'],$post['creatorPhone']);

            if($userStatus['status'] === false)
            {
                $userId = $userStatus['userData']['userId'];
            }
            else
            {
                $userName = explode(' ',$post['creatorName']);
                if(count($userName)< 2)
                {
                    $userName[1] = '';
                }

                $user = array(
                    'userName' => $post['creatorEmail'],
                    'firstName' => $userName[0],
                    'lastName' => $userName[1],
                    'password' => md5($post['creatorPhone']),
                    'LoginPin' => null,
                    'isPinChanged' => null,
                    'emailId' => $post['creatorEmail'],
                    'mobNum' => $post['creatorPhone'],
                    'userType' => '4',
                    'assignedLoc' => null,
                    'ifActive' => '1',
                    'insertedDate' => date('Y-m-d H:i:s'),
                    'updateDate' => date('Y-m-d H:i:s'),
                    'updatedBy' => $post['creatorName'],
                    'lastLogin' => date('Y-m-d H:i:s')
                );

                $userId = $this->users_model->savePublicUser($user);
                $mailData= array(
                    'creatorName' => $post['creatorName'],
                    'creatorEmail' => $post['creatorEmail']
                );
                $this->sendemail_library->memberWelcomeMail($mailData);
            }

            //Save event
            if(isset($post['attachment']))
            {
                $attachement = $post['attachment'];
                unset($post['attachment']);
            }
            $post['userId'] = $userId;
            if(isset($post['ifMicRequired']) && myIsArray($post['ifMicRequired']))
            {
                $post['ifMicRequired'] = $post['ifMicRequired'][0];
            }
            if(isset($post['ifProjectorRequired']) && myIsArray($post['ifProjectorRequired']))
            {
                $post['ifProjectorRequired'] = $post['ifProjectorRequired'][0];
            }
            $eventId = $this->dashboard_model->saveEventRecord($post);

            $eventShareLink = base_url().'mobile?page/events/EV-'.$eventId.'/'.encrypt_data('EV-'.$eventId);

            $details = array(
                'eventShareLink'=> $eventShareLink
            );
            $this->dashboard_model->updateEventRecord($details,$eventId);

            $img_names = array();
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
            $mailEvent= array(
                'creatorName' => $post['creatorName'],
                'creatorEmail' => $post['creatorEmail']
            );
            $loc = $this->locations_model->getLocationDetailsById($post['eventPlace']);
            $mailVerify = $this->dashboard_model->getEventById($eventId);
            $mailVerify[0]['locData'] = $loc['locData'];
            $mailVerify[0]['attachment'] = $img_names[0];
            $post['locData'] = $loc['locData'];
            $this->sendemail_library->newEventMail($mailEvent);
            $this->sendemail_library->eventVerifyMail($mailVerify);
            $data['status'] = true;
            $this->login_model->setLastLogin($userId);
            $this->generalfunction_library->setMobUserSession($userId);
            echo json_encode($data);
        }
        elseif(isSessionVariableSet($this->userMobId))
        {
            $userId = $this->userMobId;
            $userD = $this->users_model->getUserDetailsById($userId);
            if($userD['status'] === true)
            {
                $post['creatorName'] = $userD['userData'][0]['firstName'] . ' ' . $userD['userData'][0]['lastName'];
                $post['creatorEmail'] = $userD['userData'][0]['emailId'];
                $post['creatorPhone'] = $userD['userData'][0]['mobNum'];
            }
            else
            {
                $post['creatorName'] = '';
                $post['creatorEmail'] = '';
                $post['creatorPhone'] = '';
            }
            //Save event
            if(isset($post['attachment']))
            {
                $attachement = $post['attachment'];
                unset($post['attachment']);
            }
            $post['userId'] = $userId;
            if(isset($post['ifMicRequired']) && myIsArray($post['ifMicRequired']))
            {
                $post['ifMicRequired'] = $post['ifMicRequired'][0];
            }
            if(isset($post['ifProjectorRequired']) && myIsArray($post['ifProjectorRequired']))
            {
                $post['ifProjectorRequired'] = $post['ifProjectorRequired'][0];
            }
            $eventId = $this->dashboard_model->saveEventRecord($post);

            $eventShareLink = base_url().'mobile?page/events/EV-'.$eventId.'/'.encrypt_data('EV-'.$eventId);

            $details = array(
                'eventShareLink'=> $eventShareLink
            );
            $this->dashboard_model->updateEventRecord($details,$eventId);

            $img_names = array();
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
            $mailEvent= array(
                'creatorName' => $post['creatorName'],
                'creatorEmail' => $post['creatorEmail']
            );
            $loc = $this->locations_model->getLocationDetailsById($post['eventPlace']);
            $mailVerify = $this->dashboard_model->getEventById($eventId);
            $mailVerify[0]['locData'] = $loc['locData'];
            $mailVerify[0]['attachment'] = $img_names[0];
            $this->sendemail_library->newEventMail($mailEvent);
            $this->sendemail_library->eventVerifyMail($mailVerify);
            $data['status'] = true;
            $this->login_model->setLastLogin($userId);
            $this->generalfunction_library->setMobUserSession($userId);
            echo json_encode($data);
        }
        else
        {
            $data['status'] = false;
            $data['errorMsg'] = 'Error in Account Creation';
            echo json_encode($data);
        }

    }
    public function returnAllFeeds($responseType = RESPONSE_RETURN)
    {
        $feedData = $this->cron_model->getAllFeeds();
        $facebook = array();
        $twitter = array();
        $instagram = array();

        $allFeeds = null;

        if($feedData['status'] === true)
        {
            foreach($feedData['feedData'] as $key => $row)
            {
                switch($row['feedType'])
                {
                    case "1":
                        $facebook = json_decode($row['feedText'],true);
                        break;
                    case "2":
                        $twitter = json_decode($row['feedText'],true);
                        break;
                    case "3":
                        $instagram  = json_decode($row['feedText'],true);
                        break;
                }
            }

            $allFeeds = $this->sortNjoin($twitter,$instagram, $facebook);
        }

        //die();
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($allFeeds);
        }
        else
        {
            return $allFeeds;
        }
    }

    function sortNjoin($arr1 = array(), $arr2 = array(), $arr3 = array())
    {
        $all = array();
        $arrs[] = $arr1;
        $arrs[] = $arr2;
        $arrs[] = $arr3;
        foreach($arrs as $arr) {
            if(is_array($arr)) {
                $all = array_merge($all, $arr);
            }
        }
        //$all = array_merge($arr1, $arr2,$arr3);

        $sortedArray = array_map(function($fb) {
            $arr = $fb;
            if(isset($arr['updated_time']))
            {
                $arr['socialType'] = 'f';
                $arr['created_at'] = $arr['updated_time'];
                unset($arr['updated_time']);
            }
            elseif (isset($arr['external_created_at']))
            {
                $arr['socialType'] = 'i';
                $arr['created_at'] = $arr['external_created_at'];
                unset($arr['external_created_at']);
            }
            elseif (isset($arr['created_at']))
            {
                $arr['socialType'] = 't';
            }
            return $arr;
        },$all);

        usort($sortedArray,
            function($a, $b) {
                $ts_a = strtotime($a['created_at']);
                $ts_b = strtotime($b['created_at']);

                return $ts_a < $ts_b;
            }
        );
        return $sortedArray;

    }

    public function renderLink()
    {
        $this->load->library('OpenGraph');
        $post = $this->input->post();
        $graph = OpenGraph::fetch($post['url']);
        $array = array();

        foreach($graph as $key => $value) {
            $array[$key] = $value;
        }

        echo json_encode($array);
    }

    public function checkPublicUser($email, $mob)
    {
        $uData = array();
        $userExists = $this->users_model->checkUserDetails($email, $mob);

        if($userExists['status'] === true)
        {
            $uData['status'] = false;
            $uData['userData'] = $userExists['userData'];
        }
        else
        {
            $uData['status'] = true;
        }
        return $uData;
    }
}
