<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sendemail_library
 * @property Offers_model $offers_model
 * @property Users_Model $users_model
 */
class Sendemail_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('offers_model');
        $this->CI->load->model('users_model');
    }
    public function signUpWelcomeSendMail($userData)
    {
        $data['mailData'] = $userData;
        $data['breakfastCode'] = $this->generateBreakfastCode($userData['mugId']);

        $content = $this->CI->load->view('emailtemplates/signUpWelcomeMailView', $data, true);

        $fromEmail = 'priyanka@brewcrafts.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@brewcrafts.in,tresha@brewcrafts.in,daksha@brewcrafts.in,shweta@brewcrafts.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Breakfast for Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function memberWelcomeMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/memberWelcomeMailView', $data, true);

        $fromEmail = 'events@doolally.in';

        $cc        = 'events@doolally.in';
        $fromName  = 'Doolally';

        $subject = 'Welcome to Doolally';
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventVerifyMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);
        $senderName = 'Doolally';
        $senderEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventVerifyMailView', $data, true);

        $fromEmail = 'events@doolally.in';

        $cc        = 'tresha@brewcraftsindia.com';
        $fromName  = 'Doolally';

        $subject = 'Event Details';
        $toEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function eventApproveMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[$userData['senderName']];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventApproveMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $fromEmail = $userData['senderEmail'];
        }
        $cc        = 'events@doolally.in';
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = $userData['senderName'];
        }

        $subject = 'Event Approved';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }
    public function eventDeclineMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[$userData['senderName']];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventDeclineMailView', $data, true);

        $fromEmail = 'events@doolally.in';
        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $fromEmail = $userData['senderEmail'];
        }

        $cc        = 'events@doolally.in';
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = $userData['senderName'];
        }

        $subject = 'Event Declined';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function newEventMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $senderName = 'Tresha';
        $senderEmail = 'events@doolally.in';
        $senderPhone = $phons[$senderName];

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
            $senderPhone = $phons[$senderName];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;
        $userData['senderPhone'] = $senderPhone;
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/newEventMailView', $data, true);

        $fromEmail = $senderEmail;

        $cc        = 'events@doolally.in';
        $fromName  = $senderName;

        $subject = 'Event Details';
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function membershipRenewSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/membershipRenewMailView', $data, true);

        $fromEmail = 'priyanka@brewcrafts.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@brewcrafts.in,tresha@brewcrafts.in,daksha@brewcrafts.in,shweta@brewcrafts.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Renewal of Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function generateBreakfastCode($mugId)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'DO-'.$newCode;
    }

    public function sendEmail($to, $cc = '', $from, $fromName, $subject, $content, $attachment = array())
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $config['mailtype'] = 'html';
        $CI->email->clear(true);
        $CI->email->initialize($config);
        $CI->email->from($from, $fromName);
        $CI->email->to($to);
        if ($cc != '') {
            $CI->email->bcc($cc);
        }
        if(isset($attachment) && myIsArray($attachment))
        {
            foreach($attachment as $key)
            {
                $CI->email->attach($key);
            }
        }
        /*if($attachment != ""){
            $CI->email->attach($attachment);
        }*/
        $CI->email->subject($subject);
        $CI->email->message($content);
        return $CI->email->send();
    }

}
/* End of file */