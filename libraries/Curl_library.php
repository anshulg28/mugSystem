<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * curl Library
 */
class curl_library
{
	public function getApiData($url, $time_out, $optHeaders)
	{
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		if($time_out != 0)
		{
			curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		if($optHeaders != '')
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
		}
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec ($curl);
		curl_close ($curl);
        return $result;
	}

	public function getApiDataByPost($url, $data, $time_out, $optHeaders)
	{
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		if($time_out != 0)
		{
			curl_setopt($curl, CURLOPT_TIMEOUT, $time_out);
		}
		if($optHeaders != '')
		{
			curl_setopt($curl, CURLOPT_HTTPHEADER, $optHeaders);
		}
		curl_setopt($curl, CURLOPT_POST, true);  // tell curl you want to post something
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($curl);
		curl_close ($curl);
		return $result;
	}

	private function getDataByGet($url, $timeOut = 0, $headers = '')
	{
		$detailsTemp = $this->getApiData($url, $timeOut, $headers);
		$details = json_decode($detailsTemp, true);
		return $details;
	}

	private function getDataByPost($url, $parameters, $timeOut = 0, $headers = '')
	{
		$detailsTemp = $this->getApiDataByPost($url, $parameters, $timeOut, $headers);
		$details = json_decode($detailsTemp, true);
		return $details;
	}

	/*public function banquetGetList($filters)
	{
		$url = API_BASE.'productbanquet/getList?'.http_build_query(array('bypass' => API_AUTH_TOKEN));
		return $this->getDataByPost($url, $filters);
	}*/

    public function getFacebookPosts($params)
    {
        $url = FACEBOOK_API.'godoolallybandra/feed?'.http_build_query($params);
        return $this->getDataByGet($url, 30);
    }
    public function getInstagramPosts()
    {
        $url = 'https://www.juicer.io/api/feeds/24816';
        return $this->getDataByGet($url, 30);
    }
}