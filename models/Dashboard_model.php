<?php

/**
 * Class Dashboard_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Dashboard_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAvgCheckins()
    {
        $query = "SELECT DISTINCT (SELECT count(DISTINCT mugId, location) "
                ."FROM  mugcheckinmaster "
                ."WHERE checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH ) AND location != 0) as overall,"
                ."(SELECT count(DISTINCT mugId, location)"
                ." FROM  mugcheckinmaster "
                ."WHERE checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH ) AND location = 1) as bandra,"
                ."(SELECT count(DISTINCT mugId, location) "
                ."FROM  mugcheckinmaster "
                ."WHERE checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH ) AND location = 2) as andheri
                 from mugcheckinmaster";

        $result = $this->db->query($query)->row_array();

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
}
