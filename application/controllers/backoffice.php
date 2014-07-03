<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Gestion de la connexion pour le backoffice
class Backoffice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'template'));
        $this->load->helper(array('form', 'url'));
        // Zone protégée, c'est le BO ;)
        // Si l'utilisateur n'est pas connecté on le redirige vers le login
        if(!$this->session->userdata('logged_in')){
            redirect('login', 'refresh');
            exit(0);
        }
        else{
               $this->load->model('section');
        }
    }

    public function index()
    {   
     
        // On transmet la liste des sections au template (pour le menu)
        $data['sections'] = $this->section->get();
        $this->template->load('backoffice/template','backoffice/index', $data);
    }

    // ajouter une section
    
    public function addSection(){
        // On charge la ue qui permet d'ajouter une section
        //Chargement de wysihtml5 pour l'edition du contenu et de typeahead pour l'autocomplete des tags galerie
        $galeries = array('numero uno', 'dos', 'tres');
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie.'\'';
            $i++;
        }

        $this->template->set('js', '<script src="'.base_url().'assets/wysihtml5/wysihtml5-0.3.0.js"></script>
            <script src="'.base_url().'assets/wysihtml5/bootstrap-wysihtml5.js"></script>            <script>$(\'.textarea\').wysihtml5();</script>
            <script src="'.base_url().'assets/typeahead/typeahead.bundle.js"></script>
            <script>
            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                    var matches, substringRegex;
                    matches = [];
                    substrRegex = new RegExp(q, \'i\');
                    $.each(strs, function(i, str) {
                        if (substrRegex.test(str)) {
                            matches.push({ value: str });
                        }
                    });
                    cb(matches);
                };
            };
            var galeries = ['.$galeries_tostring.'];
            $(\'#galerie .typeahead\').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: \'galeries\',
                displayKey: \'value\',
                source: substringMatcher(galeries)
            }); </script>');
        $this->template->set('css', '<link href="'.base_url().'assets/wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
            <link href="'.base_url().'assets/typeahead/typeahead.css" rel="stylesheet">');

        $this->template->load('backoffice/template','backoffice/section/add');

    }

    // Traité les informations d'ajout d'une section
    public function post_addSection(){
        $this->form_validation->set_rules('title', 'Titre', 'required|xss_clean');
        $this->form_validation->set_rules('content', 'Contenu', 'required|xss_clean');
        $this->form_validation->set_rules('visible', 'Visible', 'xss_clean');
        $this->form_validation->set_rules('galerie', 'Galerie', 'xss_clean');
        // On change les delimiters poru avoir le style bootstrap
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Erreurs!</strong> ', '</div>');
        // On met en français les messages d'erreurs de type champs obligatoire
        $this->form_validation->set_message('required', 'Le champ %s est requis');

        if($this->form_validation->run() === TRUE){
            //On rentre tout dans la BDD
            if(!empty($this->input->post('id'))) $this->section->update($this->input->post('id'), $this->input->post('title'), $this->input->post('content'), $this->input->post('galerie'), $this->input->post('visible'));
            else $this->section->create($this->input->post('title'), $this->input->post('content'), $this->input->post('galerie'), $this->input->post('visible'));
           
            $this->viewSections();
        }
        else{
            $this->template->load('backoffice/template','backoffice/section/add');
        }
    }

    // Affiché la liste des sections
    public function viewSections(){
        $data['sections'] = $this->section->get();
        $this->template->load('backoffice/template','backoffice/section/view', $data);
    }

    // Edite une section
    public function editSection($id){
          $galeries = array('numero uno', 'dos', 'tres');
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie.'\'';
            $i++;
        }

        $this->template->set('js', '<script src="'.base_url().'assets/wysihtml5/wysihtml5-0.3.0.js"></script>
            <script src="'.base_url().'assets/wysihtml5/bootstrap-wysihtml5.js"></script>            <script>$(\'.textarea\').wysihtml5();</script>
            <script src="'.base_url().'assets/typeahead/typeahead.bundle.js"></script>
            <script>
            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                    var matches, substringRegex;
                    matches = [];
                    substrRegex = new RegExp(q, \'i\');
                    $.each(strs, function(i, str) {
                        if (substrRegex.test(str)) {
                            matches.push({ value: str });
                        }
                    });
                    cb(matches);
                };
            };
            var galeries = ['.$galeries_tostring.'];
            $(\'#galerie .typeahead\').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: \'galeries\',
                displayKey: \'value\',
                source: substringMatcher(galeries)
            }); </script>');
        $this->template->set('css', '<link href="'.base_url().'assets/wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
            <link href="'.base_url().'assets/typeahead/typeahead.css" rel="stylesheet">');
        $data['update'] = $this->section->getById($id);
        $this->template->load('backoffice/template','backoffice/section/add', $data);
    }

    // Supprime une section
    public function deleteSection($id){
        $this->section->delete($id);
        $this->viewSections();
    }

/*


    // une section precise
    public function getSection($id){
        $data['sections'] = $this->section->get($id);
        // si la requête renvoie un resultat
        if(!empty($data['sections']){

        }

    }

    // toutes les sections
    public function getSections(){
        $data['sections'] = $this->section->get();

    }

    // ajouter une/des photo(s)
    public function addPhotos(){
        // On charge la vue qui permet d\'ajouter des photos

    }

    // une photo précise
    public function getPhoto($id){
        
    }

    // toutes les photos
    public function getPhotos(){

    }*/

}