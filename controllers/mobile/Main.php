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
        $twitterFeeds = json_decode($twitterFeeds,true);
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
            'limit' => '10'
        );
        $fbFeeds = $this->curl_library->getFacebookPosts($params);
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($fbFeeds);
        }
        else
        {
            return $fbFeeds;
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


        if($responseType == RESPONSE_JSON)
        {

        }
        else
        {

        }
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
