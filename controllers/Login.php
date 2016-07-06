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
        $userResult='';
        $isPinUsed = 0;

        if(isset($post['userName']) && $post['userName'] != '' && isset($post['password']) && $post['password'] != '')
        {
            $userResult = $this->login_model->checkUser($post['userName'],md5($post['password']));
        }
        else
        {
            $loginPin = '';

            if(!isset($post['loginPin1']))
            {
                $post['loginPin1'] = '0';
            }
            if(!isset($post['loginPin2']))
            {
                $post['loginPin2'] = '0';
            }
            if(!isset($post['loginPin3']))
            {
                $post['loginPin3'] = '0';
            }
            if(!isset($post['loginPin4']))
            {
                $post['loginPin4'] = '0';
            }
            $loginPin .= $post['loginPin1'] . $post['loginPin2'] . $post['loginPin3'] . $post['loginPin4'];
            $isPinUsed = 1;
            $userResult = $this->login_model->checkUserByPin(md5($loginPin));
        }
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
            if($isPinUsed == 1)
            {
                $data['status'] = false;
                $data['errorMsg'] = 'Login Pin Not Found!';
            }
            else
            {
                $data['status'] = false;
                $data['errorMsg'] = 'Username and password does not match.';
            }
        }

        if($responseType == RESPONSE_JSON)
        {
            if($userResult['status'] === true && $isPinUsed == 1 && $userResult['isPinChanged'] == '0')
            {
                $data['pageUrl'] = base_url().'login/pinChange/'.$userResult['userId'];
            }
            else
            {
                $data['pageUrl'] = $this->pageUrl;
            }
            echo json_encode($data);
        }
        else
        {
            if($userResult['status'] === true && $isPinUsed == 1 && $userResult['isPinChanged'] == '0')
            {
                redirect(base_url().'login/pinChange/'.$userResult['userId']);
            }
            else
            {
                redirect($this->pageUrl);
            }
        }

    }
    function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_firstname');

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

    public function pinChange($userId)
    {
        $data = array();
        $data['globalStyle'] = $this->dataformatinghtml_library->getGlobalStyleHtml($data);
        $data['globalJs'] = $this->dataformatinghtml_library->getGlobalJsHtml($data);
        $data['headerView'] = $this->dataformatinghtml_library->getHeaderHtml($data);

        $data['userId'] = $userId;

        $this->load->view('ChangePinView', $data);
    }

    public function changePin()
    {
        $post = $this->input->post();

        if(isset($post['userId']))
        {
            $post['isPinChanged'] = '1';
            $this->login_model->updateUserPin($post);
            redirect(base_url());
        }
        else
        {
            redirect(base_url().'home');
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
        $userData = array(
            'mugId' => '10',
            'emailId' => 'anshulgupta@rocketmail.com',
            'firstName' => 'Anshul'
        );
        $this->sendemail_library->sendEmail($userData['emailId'],'','anshul@doolally.in',$userData['firstName'],'hi','hi');
    }
}
