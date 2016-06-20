<?php

/**
 * Class Mailers_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Mailers_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAll($userName, $userPassword)
    {
        $query = "SELECT userId,ifActive "
            ."FROM mailtemplates "
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
    
    public function saveMailTemplate($post)
    {
        $this->db->insert('mailtemplates', $post);
        return true;
    }

}
