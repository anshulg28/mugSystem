<?php

/**
 * Class Offers_Model
 * @property Mydatafetch_library $mydatafetch_library
 * @property Generalfunction_library $generalfunction_library
 */
class Offers_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('mydatafetch_library');
	}

    public function getAllCodes()
    {
        $query = "SELECT offerCode "
            ."FROM offersmaster ";

        $result = $this->db->query($query)->result_array();

        $data['codes'] = $result;
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
    public function setAllCodes($data)
    {
        $this->db->insert_batch('offersmaster',$data);
        return true;
    }
    public function setSingleCode($data)
    {
        $this->db->insert('offersmaster',$data);
        return true;
    }

    public function getTodayCodes()
    {
        $query = "SELECT offerCode, offerType "
            ."FROM offersmaster"
            ." WHERE date(createDateTime) = CURRENT_DATE()";

        $result = $this->db->query($query)->result_array();

        $data['codes'] = $result;
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

    public function getOfferStats()
    {
        $query = "SELECT o.id, offerCode, offerType, isRedeemed, createDateTime, useDateTime ,l.locName"
                ." FROM offersmaster o "
                ."LEFT JOIN locationmaster l ON l.id = offerLoc";

        $result = $this->db->query($query)->result_array();

        $data['codes'] = $result;
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

    public function deleteOfferRecord($offerId)
    {
        $this->db->where('id', $offerId);
        $this->db->delete('offersmaster');
        return true;
    }

    public function checkOfferCode($offerCode)
    {
        $query = "SELECT offerType, isRedeemed"
                ." FROM offersmaster "
                ."WHERE offerCode = ".$offerCode;

        $result = $this->db->query($query)->row_array();

        $data['codeCheck'] = $result;
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
    public function setOfferUsed($offerData)
    {
        $this->db->where('offerCode', $offerData['offerCode']);
        $this->db->update('offersmaster', $offerData);
        return true;
    }
}
