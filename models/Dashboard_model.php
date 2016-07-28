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

    public function getAvgCheckins($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(DISTINCT mugId, location) "
                ."FROM  mugcheckinmaster "
                ."WHERE checkinDateTime BETWEEN '$dateStart' AND '$dateEnd' AND location != 0) as overall";

            if(isset($locations))
            {
                $length = count($locations)-1;
                $counter = 0;
                foreach($locations as $key => $row)
                {
                    if(isset($row['id']))
                    {
                        $counter++;
                        if($counter <= $length)
                        {
                            $query .= ",";
                        }
                        $query .= "(SELECT count(DISTINCT mugId, location)"
                            ." FROM  mugcheckinmaster "
                            ."WHERE checkinDateTime BETWEEN '$dateStart' AND '$dateEnd' AND location =". $row['id'].")"
                            ." as ".$row['locUniqueLink'];

                    }
                }
            }
        $query .= " FROM mugcheckinmaster";


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

    public function getRegulars($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                Where date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
				GROUP BY mc.mugId HAVING count(*) > 2) as tbl) as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                                Where homeBase = ".$row['id']." AND date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
                                GROUP BY mc.mugId HAVING count(*) > 2) as tbl) as ".$row['locUniqueLink'];
                }
            }
        }
        $query .= " FROM mugcheckinmaster";

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

    public function getIrregulars($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                Where date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
				GROUP BY mc.mugId HAVING count(*) <= 1) as tbl) as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM (SELECT m.mugId,homeBase FROM  mugmaster m
                                LEFT JOIN mugcheckinmaster mc ON m.mugId = mc.mugId
                                Where homeBase = ".$row['id']." AND date(mc.checkinDateTime) BETWEEN '$dateStart' AND '$dateEnd'
                                GROUP BY mc.mugId HAVING count(*) <= 1) as tbl) as ".$row['locUniqueLink'];
                }
            }
        }

        $query .= " FROM mugcheckinmaster";

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

    public function getLapsers($dateStart, $dateEnd, $locations)
    {
        $query = "SELECT DISTINCT (SELECT count(*) FROM mugmaster 
                 WHERE membershipEnd BETWEEN '$dateStart' AND '$dateEnd' AND membershipEnd != '0000-00-00') as overall";

        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT count(*) FROM mugmaster 
                             WHERE homeBase = ".$row['id']." AND membershipEnd BETWEEN '$dateStart' AND '$dateEnd'
                              AND membershipEnd != '0000-00-00') as ".$row['locUniqueLink'];
                }
            }
        }
        $query .= " FROM mugmaster";

        $result = $this->db->query($query)->row_array();

        $data['lapsers'] = $result;
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

    public function saveDashboardRecord($details)
    {
        $details['insertedDate'] = date('Y-m-d');

        $this->db->insert('dashboardmaster', $details);
        return true;
    }
    public function getDashboardRecord()
    {
        $query = "SELECT * "
                ." FROM dashboardmaster WHERE insertedDate = CURRENT_DATE()";

        $result = $this->db->query($query)->result_array();
        $data['todayStat'] = $result;
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
    public function getAllDashboardRecord()
    {
        $query = "SELECT * "
            ." FROM dashboardmaster ORDER BY insertedDate DESC LIMIT 30";

        $result = $this->db->query($query)->result_array();
        $data['dashboardPoints'] = array_reverse($result);
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

    public function saveInstaMojoRecord($details)
    {
        $this->db->insert('instamojomaster', $details);
        return true;
    }
    public function updateInstaMojoRecord($id,$details)
    {
        $this->db->where('id', $id);
        $this->db->update('instamojomaster', $details);
        return true;
    }

    public function getAllInstamojoRecord()
    {
        $query = "SELECT * "
            ." FROM instamojomaster"
            ." WHERE status = 1 AND isApproved = 0";

        $result = $this->db->query($query)->result_array();
        $data['instaRecords'] = $result;
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
    public function getAllFeedbacks($locations)
    {
        $query = "SELECT DISTINCT (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0) as total_overall,
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc = 1) as total_bandra,
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc = 2) as total_andheri,
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0 AND overallRating >= 9) as promo_overall,
                 (SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                 WHERE feedbackLoc != 0 AND overallRating < 7) as de_overall";
        if(isset($locations))
        {
            $length = count($locations)-1;
            $counter = 0;
            foreach($locations as $key => $row)
            {
                if(isset($row['id']))
                {
                    $counter++;
                    if($counter <= $length)
                    {
                        $query .= ",";
                    }
                    $query .= "(SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                              WHERE feedbackLoc = ".$row['id']." AND overallRating >= 9) as promo_".$row['locUniqueLink'].",";
                    $query .= "(SELECT COUNT(overallRating) FROM usersfeedbackmaster 
                              WHERE feedbackLoc = ".$row['id']." AND overallRating < 7) as de_".$row['locUniqueLink'];
                }
            }
        }

        $result = $this->db->query($query)->result_array();
        $data['feedbacks'] = $result;
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

    public function insertFeedBack($details)
    {
        $this->db->insert_batch('usersfeedbackmaster', $details);
        return true;
    }
}
