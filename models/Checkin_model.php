<?php

/**
 * Class Login_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Checkin_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAllCheckInList()
    {
        $query = "SELECT m.id,mugId,l.locName,checkinDateTime "
            ."FROM mugcheckinmaster m "
            ."LEFT JOIN locationmaster l ON l.id = m.location "
            ."WHERE DATE(checkinDateTime) = CURRENT_DATE() ORDER BY id DESC";

        $result = $this->db->query($query)->result_array();

        $data['checkInList'] = $result;
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

    public function getCheckInDataById($Id)
    {
        $query = "SELECT * "
            ."FROM mugcheckinmaster "
            ."where id = ".$Id;

        $result = $this->db->query($query)->result_array();

        $data['checkInList'] = $result;
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
    public function filterCheckInParameters($post)
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
                        case 'checkId':
                            $parameter['id'] = $row;
                            break;
                        
                        case 'mugNum':
                            $parameter['mugId'] = $row;
                            break;

                        case 'baseLocation':
                            $parameter['location'] = $row;
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

    public function saveCheckInRecord($post)
    {
        $post['checkinDateTime'] = date('Y-m-d H:i:s');

        $this->db->insert('mugcheckinmaster', $post);
        return true;
    }

    public function updateCheckInRecord($post)
    {
        if(isset($post['checkinDateTime']))
        {
            $post['checkinDateTime'] = date('Y-m-d H:i:s', strtotime($post['checkinDateTime']));
        }

        $this->db->where('id', $post['id']);
        $this->db->update('mugcheckinmaster', $post);
        return true;
    }
    public function deleteCheckInRecord($checkId)
    {
        $this->db->where('id', $checkId);
        $this->db->delete('mugcheckinmaster');
        return true;
    }
}
