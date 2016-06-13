<?php

/**
 * Class Login_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Login_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function checkUser($userName, $userPassword)
    {
        $query = "SELECT userId,ifActive "
            ."FROM doolally_usersmaster "
            ."where userName = '".$userName."' "
            ."AND password = '".$userPassword."' ";

        $result = $this->db->query($query)->row_array();

        $data = $result;
        if(myIsArray($result))
        {
            $data['status'] = true;
        }
        else
        {
            $data['status'] = false;
        }

        return $data;
    }
}
