<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property Login_Model $login_model
*/

class Login extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
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
}
