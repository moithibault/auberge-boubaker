<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Le site à proprement parlé !
class Frontoffice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('template'));
        $this->load->helper(array('form', 'url'));
         $this->load->model('section');
    }

    public function index()
    {   
        // On transmet la liste des sections au template (pour le menu)
        $data['sections'] = $this->section->get();
        $this->template->load('frontoffice/template','frontoffice/index', $data);
    }
}   
?>