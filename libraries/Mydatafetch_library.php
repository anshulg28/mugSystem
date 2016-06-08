<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Mydatafetch_library
 */
class Mydatafetch_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    /*
    * user related function
    */
    public function getUserDetailsByUserId($userId)
    {
        $this->CI->db->select('userName, userId');
        $this->CI->db->from('doolally_usersmaster');
        $this->CI->db->where('userId', $userId);
        $this->CI->db->where('userType', 1);

        $result = $this->CI->db->get()->row_array();

        return $result;
    }
}