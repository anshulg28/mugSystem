<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dataformatinghtml_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    public function getGlobalStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/GlobalstyleView', $data, true);
        return $htmlPage;
    }
    public function getMobileStyleHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/MobilestyleView', $data, true);
        return $htmlPage;
    }

    public function getGlobalJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/GlobaljsView', $data, true);
        return $htmlPage;
    }
    public function getMobileJsHtml($data)
    {
        $htmlPage = $this->CI->load->view('common/MobilejsView', $data, true);
        return $htmlPage;
    }
    public function getHeaderHtml($data)
    {
        $htmlPage = $this->CI->load->view('HeaderView', $data, true);
        return $htmlPage;
    }
    public function getFooterHtml($data)
    {
        $htmlPage = $this->CI->load->view('FooterView', $data, true);
        return $htmlPage;
    }
}
/* End of file */