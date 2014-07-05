<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Le site à proprement parlé !
class Frontoffice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('template'));
        $this->load->helper(array('form', 'url'));
        $this->load->model('section');
        $this->load->model('photo');
    }

    public function index()
    {   
        // On transmet la liste des sections au template (pour le menu)
        
    }

    public function view($id){
        $section = $this->section->getById($id);
        $photos = $this->photo->getByGalerie($section->galerie);
        $data['section'] = $section;
        $data['photos'] = $photos;
        
        $this->template->set('js', '<script src="'.base_url().'assets/swipebox/js/jquery.swipebox.js"></script>
            <script>;( function( $ ) {$( \'.swipebox\' ).swipebox();} )( jQuery );</script>');

         

        $this->template->set('css', '<link href="'.base_url().'assets/swipebox/css/swipebox.css" rel="stylesheet">');
        $data['title'] = 'Auberge Boubaker';
        $this->template->set('sections', $this->section->getVisible());
        $this->template->load('frontoffice/template','frontoffice/index', $data);

    }
}   
?>