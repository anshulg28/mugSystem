<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Mailers
 * @property Mailers_Model $mailers_model
 * @property Mugclub_Model $mugclub_model
*/

class Mailers extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('mailers_model');
        $this->load->model('mugclub_model');
	}
	public function index()
	{
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url().'home');
        }

        $data['expiredMugs'] = $this->mugclub_model->getExpiredMugsList();
        $data['expiringMugs'] = $this->mugclub_model->getExpiringMugsList(1,'week');
        
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

       $this->load->view('MailersView',$data);
	}

    public function showMailAdd()
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url().'home');
        }
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('MailAddView',$data);

    }

    public function saveMail()
    {
        $post = $this->input->post();

        $this->mailers_model->saveMailTemplate($post);

    }
    public function sendMail($mailType)
    {
        $data = array();
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url().'home');
        }
        $data['mailType'] = $mailType;

        $mugData = $this->mugclub_model->getCheckInMugClubList();
        $data['mugData'] = $mugData;
        //fetching mail Templates according to mail type

        $mailResult = $this->mailers_model->getAllTemplatesByType($mailType);

        //check What type of mail it is
        if($mailType == EXPIRED_MAIL)
        {
            $expiredMails = $this->mugclub_model->getExpiredMugsList();
            $data['mailMugs'] = $expiredMails;
        }
        elseif($mailType == EXPIRING_MAIL)
        {
            $expiringMails = $this->mugclub_model->getExpiringMugsList(1,'week');
            $data['mailMugs'] = $expiringMails;
        }

        $data['mailList'] = $mailResult;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $this->load->view('MailSendView',$data);
    }

    public function sendAllMails()
    {
        $post = $this->input->post();

        foreach($post['mugNums'] as $key)
        {
            $mugInfo = $this->mugclub_model->getMugDataForMailById($key);
            $newSubject = $this->replaceMugTags($post['mailSubject'],$mugInfo);
            $newBody = $this->replaceMugTags($post['mailBody'],$mugInfo);

            
        }

        echo '<pre>';
        $post['mailSubject'] = str_replace('[mugno]','12',$post['mailSubject']);
        var_dump($post);
        die();
    }

    function replaceMugTags($tagStr,$mugInfo)
    {
        $tagStr = str_replace('[sendername]',$this->userName,$tagStr);
        foreach($mugInfo as $key => $row)
        {
            switch($key)
            {
                case 'mugId':
                    $tagStr = str_replace('[mugno]',$row['mugId'],$tagStr);
                    break;
                case 'firstName':
                    $tagStr = str_replace('[firstname]',$row['firstName'],$tagStr);
                    break;
                case 'lastName':
                    $tagStr = str_replace('[lastname]',$row['lastName'],$tagStr);
                    break;
                case 'birthDate':
                    $d = date_create($row['birthDate']);
                    $tagStr = str_replace('[birthdate]',date_format($d,DATE_FORMAT_UI),$tagStr);
                    break;
                case 'mobileNo':
                    $tagStr = str_replace('[mobno]',$row['mobileNo'],$tagStr);
                    break;
                case 'membershipEnd':
                    $tagStr = str_replace('[expirydate]',$row['membershipEnd'],$tagStr);
                    break;
            }
        }
        return $tagStr;
    }
}
