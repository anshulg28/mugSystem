<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
 * @property cron_model $cron_model
 * @property dashboard_model $dashboard_model
 * @property locations_model $locations_model
*/

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('cron_model');
        $this->load->model('dashboard_model');
        $this->load->model('locations_model');
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
}
