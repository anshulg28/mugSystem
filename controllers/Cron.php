<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller
{
    /**
     * Class Cron
     * @property Cron_model $cron_model
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('cron_model');
    }
    public function index()
    {
        $this->load->view('Page404View');
    }

    public function feedsFetch()
    {

        $twitter = $this->getTwitterFeeds();

        $instagram = $this->getInstagramFeeds();

        $facebook =  $this->getFacebookResponse();

        //facebook
        $fbData = $this->cron_model->checkFeedByType("1");

        $fbPost = array(
            'feedText' => json_encode($facebook),
            'feedType' => '1'
        );
        if($fbData['status'] === true)
        {
            $this->cron_model->updateFeedByType($fbPost,"1");
        }
        else
        {
            $this->cron_model->insertFeedByType($fbPost);
        }

        //twitter
        $fbData = $this->cron_model->checkFeedByType("2");

        $fbPost = array(
            'feedText' => json_encode($twitter),
            'feedType' => '2'
        );
        if($fbData['status'] === true)
        {
            $this->cron_model->updateFeedByType($fbPost, "2");
        }
        else
        {
            $this->cron_model->insertFeedByType($fbPost);
        }

        //Instagram
        $fbData = $this->cron_model->checkFeedByType("3");

        $fbPost = array(
            'feedText' => json_encode($instagram),
            'feedType' => '3'
        );
        if($fbData['status'] === true)
        {
            $this->cron_model->updateFeedByType($fbPost, "3");
        }
        else
        {
            $this->cron_model->insertFeedByType($fbPost);
        }
    }
    public function getTwitterFeeds()
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

        return $twitterFeeds;
    }
    public function getInstagramFeeds()
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

        return $instaFeeds;
    }

    public function getFacebookResponse()
    {
        $params = array(
            'access_token' => FACEBOOK_TOKEN,
            'limit' => '30',
            'fields' => 'message,permalink_url,id,from,name,picture,source,updated_time'
        );
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolallyandheri',$params);
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolallybandra',$params);
        $fbFeeds[] = $this->curl_library->getFacebookPosts('godoolally',$params);

        return array_merge($fbFeeds[0]['data'],$fbFeeds[1]['data'],$fbFeeds[2]['data']);
    }

}
