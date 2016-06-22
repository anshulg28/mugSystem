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

    public function getAllTemplatesByType($mailType)
    {
        $query = "SELECT mailSubject, mailBody, mailType "
            ."FROM mailtemplates "
            ."where mailType = ".$mailType;

        $result = $this->db->query($query)->result_array();

        $data['mailData'] = $result;
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
