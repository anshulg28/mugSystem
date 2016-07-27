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
        //$twitterFeeds = $this->getTwitterFeeds();
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

    public function getFacebookResponse()
    {
        $post = $this->input->post();
        //var_dump($post);
    }
    public function getTwitterFeeds($responseType = RESPONSE_RETURN)
    {
        $params = array(
            'screen_name' => 'Apple_Coder',
            'count' => '50',
            'exclude_replies' => 'true'
        );
        $twitterFeeds = $this->curl_library->getTwitterPosts($params);
        if($responseType == RESPONSE_JSON)
        {
            echo json_encode($twitterFeeds);
        }
        else
        {
            return $twitterFeeds;
        }
    }
}
