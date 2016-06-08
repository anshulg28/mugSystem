<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Generalfunction_library
 */
class Generalfunction_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }
    public function setUserSession($id)
    {
        $data = $this->CI->mydatafetch_library->getUserDetailsByUserId($id);

        $this->CI->session->set_userdata('user_id', $data['userId']);
        $this->CI->userId = $data['userId'];
        $this->CI->session->set_userdata('user_type', ADMIN_USER);
        $this->CI->userType = ADMIN_USER;
    }

    public function setSessionVariable($key, $value)
    {
        $this->CI->session->set_userdata($key, $value);
    }

}
/* End of file */