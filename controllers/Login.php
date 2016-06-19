<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property Login_Model $login_model
 * @property Users_Model $users_model
*/

class Login extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
        $this->load->model('users_model');
	}
	public function index()
	{
        $data = array();
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        if(isSessionVariableSet($this->isUserSession) === true)
        {
            redirect(base_url().'home');
        }
        else
        {
            $this->load->view('LoginView', $data);
        }
	}
    public function checkUser($responseType = RESPONSE_RETURN)
    {
        $post = $this->input->post();

        $userResult = $this->login_model->checkUser($post['userName'],md5($post['password']));

        if($userResult['status'] === true && $userResult['userId'] != 0)
        {
            if($userResult['ifActive'] == NOT_ACTIVE)
            {
                $data['errorMsg'] = 'User Account is Disabled!';
                $data['status'] = false;
            }
            else
            {
                $this->login_model->setLastLogin($userResult['userId']);
                $this->generalfunction_library->setUserSession($userResult['userId']);
                $data['status'] = true;
                $data['isUserSession'] = $this->isUserSession;
                $data['userName'] = $this->userName;
            }
        }
        else
        {
            $data['status'] = false;
            $data['errorMsg'] = 'Username and password does not match.';
        }

        if($responseType == RESPONSE_JSON)
        {
            $data['pageUrl'] = $this->pageUrl;
            echo json_encode($data);
        }
        else
        {
            redirect($this->pageUrl);
        }

    }
    function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('user_name');

        redirect(base_url());
    }

    public function changeSetting()
    {
        $data = array();
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);
        
        $data['userData'] = $this->users_model->getUserDetailsByUsername($this->userName);
        if(isSessionVariableSet($this->isUserSession) === false)
        {
            redirect(base_url());
        }
        else
        {
            $this->load->view('ChangePasswordView', $data);
        }
    }

    public function changePassword()
    {
        $post = $this->input->post();

        if(isset($post['userId']))
        {
            $this->login_model->updateUserPass($post);
            redirect($this->pageUrl);
        }
        else
        {
            redirect(base_url().'home');
        }
    }

    public function sendSample()
    {
        $fromEmail = 'anshul@doolally.in';
        $cc        = '';
        $toList= array('anshul@doolally.in','gaurav_07rulz@yahoo.co.in','amarlibra88@gmail.com');
        $fromName  = 'Anshul';
        $subject = 'Breakfast for Mug #';
        $toEmail = '';

        foreach ($toList as $key)
        {
            $toEmail = $key;
            $this->sendemail_library->sendEmail($toEmail, $cc, $fromEmail, $fromName, $subject, '<html><body><p>hi</p></body></html>');
        }
    }
}
