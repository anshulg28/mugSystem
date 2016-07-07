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

    public function getRegulars()
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location != 0 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) > 1) as tbl) as overall,
                
                (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location = 2 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) > 1) as tbl1) as andheri,
                
                (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location = 1 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) > 1) as tbl2) as bandra
                FROM mugcheckinmaster";

        $result = $this->db->query($query)->row_array();

        $data['regularCheckins'] = $result;
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

    public function getIrregulars()
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location != 0 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) <= 1) as tbl) as overall,
                
                (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location = 2 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) <= 1) as tbl1) as andheri,
                
                (SELECT count(*) FROM (SELECT mugId,location FROM  mugcheckinmaster
                WHERE location = 1 AND checkinDateTime >= ( CURRENT_DATE( ) - INTERVAL 1 MONTH)
                GROUP BY mugId HAVING count(*) <= 1) as tbl2) as bandra
                FROM mugcheckinmaster";

        $result = $this->db->query($query)->row_array();

        $data['irregularCheckins'] = $result;
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
