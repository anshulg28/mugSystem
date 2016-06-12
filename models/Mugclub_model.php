<?php

/**
 * Class Login_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Mugclub_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAllMugClubList()
    {
        $query = "SELECT * "
            ."FROM mugmaster ";

        $result = $this->db->query($query)->result_array();

        $data['mugList'] = $result;
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

    public function getMugDataById($mugId)
    {
        $query = "SELECT * "
            ."FROM mugmaster "
            ."where mugId = ".$mugId;

        $result = $this->db->query($query)->result_array();

        $data['mugList'] = $result;
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

    public function verifyMobileNo($mobNo)
    {
        $query = "SELECT * "
            ."FROM mugmaster "
            ."where mobileNo = '".$mobNo."'";

        $result = $this->db->query($query)->row_array();

        $data['mugList'] = $result;
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
    public function filterMugParameters($post)
    {
        if(myIsArray($post))
        {
            $parameter = array();

            foreach ($post as $key => $row)
            {
                if ($row != '')
                {
                    switch ($key)
                    {
                        case 'mugNum':
                            $parameter['mugId'] = $row;
                            break;

                        case 'baseLocation':
                            $parameter['homeBase'] = $row;
                            break;

                        case 'mobNum':
                            $parameter['mobileNo'] = $row;
                            break;

                        case 'birthdate':
                            $parameter['birthDate'] = $row;
                            break;

                        case 'memberS':
                            $parameter['membershipStart'] = $row;
                            break;

                        case 'memberE':
                            $parameter['membershipEnd'] = $row;
                            break;

                        case 'mugNotes':
                            $parameter['notes'] = $row;
                            break;

                        default:
                            $parameter[$key] = $row;
                            break;
                    }
                }
            }

            return $parameter;
        }
        else
        {
            return false;
        }
    }

    public function saveMugRecord($post)
    {
        $post['birthDate'] = date('Y-m-d', strtotime($post['birthDate']));
        $post['invoiceDate'] = date('Y-m-d', strtotime($post['invoiceDate']));
        $post['membershipStart'] = date('Y-m-d', strtotime($post['membershipStart']));
        $post['membershipEnd'] = date('Y-m-d', strtotime($post['membershipEnd']));
        $post['notes'] = trim($post['notes']);
        $post['ifActive'] = '1';

        $this->db->insert('mugmaster', $post);
        return true;
    }

    public function updateMugRecord($post)
    {
        $post['birthDate'] = date('Y-m-d', strtotime($post['birthDate']));
        $post['invoiceDate'] = date('Y-m-d', strtotime($post['invoiceDate']));
        $post['membershipStart'] = date('Y-m-d', strtotime($post['membershipStart']));
        $post['membershipEnd'] = date('Y-m-d', strtotime($post['membershipEnd']));
        $post['notes'] = trim($post['notes']);
        $post['ifActive'] = '1';

        $this->db->where('mugId', $post['mugId']);
        $this->db->update('mugmaster', $post);
        return true;
    }
    public function deleteMugRecord($mugId)
    {
        $this->db->where('mugId', $mugId);
        $this->db->delete('mugmaster');
        return true;
    }
}
