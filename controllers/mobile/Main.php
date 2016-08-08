<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
 * @property cron_model $cron_model
*/

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('cron_model');
	}
	public function index()
	{
        $data = array();
        $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
        $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);

        $data['myFeeds'] = $this->returnAllFeeds();
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
