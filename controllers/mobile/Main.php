<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Main
*/

class Main extends MY_Controller {

	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
        $data = array();
        $data['mobileStyle'] = $this->dataformatinghtml_library->getMobileStyleHtml($data);
        $data['mobileJs'] = $this->dataformatinghtml_library->getMobileJsHtml($data);

        //$this->returnAllFeeds();
        //$fb = $this->getInstagramFeeds();

        $twitterFeeds = $this->getTwitterFeeds();
        /*$instaFeeds = $this->getInstagramFeeds();
        if(isset($instaFeeds['posts']['items']) && myIsArray($instaFeeds['posts']['items']))
        {
            $instaFeeds = $instaFeeds['posts']['items'];
        }*/
        //$fbFeeds = $this->getFacebookResponse();

        /*echo '<pre>';
        var_dump($fbFeeds);
        die();*/
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
        if(isset($twitterFeeds) && myIsArray($twitterFeeds))
        {
            $data['twitterPosts'] = $twitterFeeds;
        }
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

    public function getFacebookResponse($responseType = RESPONSE_RETURN)
    {
        $params = array(
            'access_token' => FACEBOOK_TOKEN,
            'limit' => '30',
            'fields' => 'message,permalink_url,id,from,name,picture,source,updated_time'
        );
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolallyandheri',$params);
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolallybandra',$params);
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolally',$params);
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($fbFeeds);
        }
        else
        {
            return array_merge($fbFeeds[0]['data'],$fbFeeds[1]['data'],$fbFeeds[2]['data']);
        }
    }
    public function getTwitterFeeds($responseType = RESPONSE_RETURN)
    {
        $twitterFeeds = '';
        $this->twitter->tmhOAuth->reconfigure();
        $parmas = array(
            'count' => '61',
            'exclude_replies' => 'true',
            'screen_name' => 'godoolally'
        );
        $responseCode = $this->twitter->tmhOAuth->request('GET','https://api.twitter.com/1.1/statuses/user_timeline.json',$parmas);
        if($responseCode == 200)
        {
            $twitterFeeds = $this->twitter->tmhOAuth->response['response'];
        }
        $twitterFeeds = json_decode($twitterFeeds,true);
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($twitterFeeds);
        }
        else
        {
            return $twitterFeeds;
        }
    }

    public function getInstagramFeeds($responseType = RESPONSE_RETURN)
    {

        $instaFeeds = $this->curl_library->getInstagramPosts();

        if(!myIsMultiArray($instaFeeds))
        {
            $instaFeeds = null;
        }
        else
        {
            $instaFeeds = $instaFeeds['posts']['items'];
        }
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($instaFeeds);
        }
        else
        {
            return $instaFeeds;
        }
    }

    public function returnAllFeeds($responseType = RESPONSE_RETURN)
    {

        $twitter = $this->getTwitterFeeds();
        $instagram = $this->getInstagramFeeds();
        $facebook = $this->getFacebookResponse();
        $arr1['dataInfo'] = $twitter;
        $arr1['type'] = 't';
        $arr2['dataInfo'] = $instagram;
        $arr2['type']= 'i';

        $allFeeds = $this->sortNjoin($arr1,$arr2);
        echo '<pre>';
        var_dump($allFeeds);
        die();

        if(myIsArray($twitter) && myIsMultiArray($twitter))
        {
            $allFeeds['twitter'] = $twitter;
        }
        if(myIsArray($instagram) && myIsMultiArray($instagram))
        {
            $allFeeds['instagram'] = $instagram;
        }
        if(myIsArray($facebook) && myIsMultiArray($facebook))
        {
            $allFeeds['facebook'] = $facebook;
        }

        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($allFeeds);
        }
        else
        {
            return $allFeeds;
        }
    }

    function sortNjoin($arr1, $arr2)
    {
        $length = count($arr1);
        $sortedArray = array();
        if(count($arr1)>count($arr2))
        {
            $length = count($arr2);
        }

        $date1 ='';
        $date2 = '';
        $all = array_merge($arr1['dataInfo'], $arr2['dataInfo']);
        /*usort($all,
            function($a, $b) {
                $ts_a = strtotime($a['external_created_at']);
                $ts_b = strtotime($b['created_at']);

                return $ts_a > $ts_b;
            }
        );*/
        $sortedArray= $all;
        /*for($i=0;$i<$length;$i++)
        {
            for($j=0;$j<$length;$j++)
            {
                switch($arr1['type'])
                {
                    case 'f':
                        $date1 = date_parse($arr1['dataInfo'][$i]['updated_time']);
                        break;
                    case 't':
                        $date1 = date_parse($arr1['dataInfo'][$i]['created_at']);
                        break;
                    case 'i':
                        $date1 = date_parse($arr1['dataInfo'][$i]['external_created_at']);
                        break;
                }
                switch($arr2['type'])
                {
                    case 'f':
                        $date2 = date_parse($arr2['dataInfo'][$j]['updated_time']);
                        break;
                    case 't':
                        $date2 = date_parse($arr2['dataInfo'][$j]['created_at']);
                        break;
                    case 'i':
                        $date2 = date_parse($arr2['dataInfo'][$j]['external_created_at']);
                        break;
                }
                $date_string1 = date('Y-m-d H:i:s', mktime($date1['hour'], $date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year']));
                $date_string2 = date('Y-m-d H:i:s', mktime($date2['hour'], $date2['minute'], $date2['second'], $date2['month'], $date2['day'], $date2['year']));

                if($date_string1 >= $date_string2)
                {
                    $sortedArray[$i]['dataInfo'] = $arr1['dataInfo'][$i];
                    $sortedArray[$i]['type'] = $arr1['type'];
                }
                else
                {
                    $sortedArray[$i]['dataInfo'] = $arr2['dataInfo'][$j];
                    $sortedArray[$i]['type'] = $arr2['type'];
                }
            }
        }*/

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
