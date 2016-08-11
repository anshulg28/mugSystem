<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sendemail_library
 * @property Offers_model $offers_model
 */
class Sendemail_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('offers_model');
    }
    public function signUpWelcomeSendMail($userData)
    {
        $data['mailData'] = $userData;
        $data['breakfastCode'] = $this->generateBreakfastCode();

        $content = $this->CI->load->view('emailtemplates/signUpWelcomeMailView', $data, true);

        $fromEmail = 'priyanka@doolally.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in,shweta@doolally.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Breakfast for Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function membershipRenewSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/membershipRenewMailView', $data, true);

        $fromEmail = 'priyanka@doolally.in';

        if(isset($this->CI->userEmail))
        {
            $fromEmail = $this->CI->userEmail;
        }
        $cc        = 'priyanka@doolally.in,tresha@doolally.in,daksha@doolally.in,shweta@doolally.in';
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Renewal Mug Mail';
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function generateBreakfastCode()
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