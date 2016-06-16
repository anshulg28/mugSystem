<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sendemail_library
 */
class Sendemail_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }
    public function signUpWelcomeSendMail($userData)
    {

        $data['mailData'] = $userData;
        $content = $this->CI->load->view('emailtemplates/signUpWelcomeMailView', $userData, true);

        $fromEmail = 'anshul@doolally.in';
        $cc        = '';
        $fromName  = '';
        $subject = 'Breakfast for Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, $content);
    }

    public function sendEmail($to, $cc = '', $from, $fromName, $subject, $content, $attachment = "")
    {
        $CI =& get_instance();
        $CI->load->library('email');
        $config['mailtype'] = 'html';
        $CI->email->initialize($config);
        $CI->email->from($from, FROM_NAME_EMAIL);
        $CI->email->to($to);
        if ($cc != '') {
            $CI->email->cc($cc);
        }
        if($attachment != ""){
            $CI->email->attach($attachment);
        }
        $CI->email->subject($subject);
        $CI->email->message($content);
        return $CI->email->send();
    }

}
/* End of file */