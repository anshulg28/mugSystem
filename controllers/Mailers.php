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
        $data['birthdayMugs'] = $this->mugclub_model->getBirthdayMugsList();
        
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

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
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

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
        elseif($mailType == BIRTHDAY_MAIL)
        {
            $expiringMails = $this->mugclub_model->getBirthdayMugsList();
            $data['mailMugs'] = $expiringMails;
        }

        $data['mailList'] = $mailResult;

        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        $data['footerView'] = $this->dataformatinghtml_library->getFooterHtml($data);

        $this->load->view('MailSendView',$data);
    }

    public function sendAllMails($responseType = RESPONSE_RETURN)
    {
        $post = $this->input->post();

        $mugNums = $post['mugNums'];
        if($post['mailType'] == CUSTOM_MAIL)
        {
            $mugNums = explode(',',$post['mugNums']);
        }
        foreach($mugNums as $key)
        {
            $mugInfo = $this->mugclub_model->getMugDataForMailById($key);
            $newSubject = $this->replaceMugTags($post['mailSubject'],$mugInfo);
            $newBody = $this->replaceMugTags($post['mailBody'],$mugInfo);
            $cc        = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in';
            $fromName  = 'Doolally';
            if(isset($this->userFirstName))
            {
                $fromName = trim(ucfirst($this->userFirstName));
            }
            $fromEmail = 'priyanka@doolally.in';

            if(isset($this->userEmail))
            {
                $fromEmail = $this->userEmail;
            }

            $this->sendemail_library->sendEmail($mugInfo['mugList'][0]['emailId'],$cc,$fromEmail,$fromName,$newSubject,$newBody);
            $this->mailers_model->setMailSend($key);
        }

        if($responseType == RESPONSE_JSON)
        {
            $data['status'] = true;
            echo json_encode($data);
        }
        else
        {
            return true;
        }
    }

    function replaceMugTags($tagStr,$mugInfo)
    {
        $tagStr = str_replace('[sendername]',trim(ucfirst($this->userName)),$tagStr);
        foreach($mugInfo['mugList'][0] as $key => $row)
        {
            switch($key)
            {
                case 'mugId':
                    $tagStr = str_replace('[mugno]',trim($row),$tagStr);
                    break;
                case 'firstName':
                    $tagStr = str_replace('[firstname]',trim(ucfirst($row)),$tagStr);
                    break;
                case 'lastName':
                    $tagStr = str_replace('[lastname]',trim(ucfirst($row)),$tagStr);
                    break;
                case 'birthDate':
                    $d = date_create($row);
                    $tagStr = str_replace('[birthdate]',date_format($d,DATE_MAIL_FORMAT_UI),$tagStr);
                    break;
                case 'mobileNo':
                    $tagStr = str_replace('[mobno]',trim($row),$tagStr);
                    break;
                case 'membershipEnd':
                    $d = date_create($row);
                    $tagStr = str_replace('[expirydate]',date_format($d,DATE_MAIL_FORMAT_UI),$tagStr);
                    break;
            }
        }
        return $tagStr;
    }
}
