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
            $this->load->model('photo');
        }
    }

    public function index()
    {   
        $this->template->load('backoffice/template','backoffice/index');
    }

    //ajouter une photo
    public function addPhoto(){
        //Chargement de wysihtml5 pour l'edition du contenu et de typeahead pour l'autocomplete des tags galerie
        $galeries = $this->photo->getGaleries();
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie->galerie.'\'';
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

        $this->template->load('backoffice/template','backoffice/photo/add');


    }


    // Traité les informations d'ajout d'une photo

    public function post_addPhoto(){
        $this->form_validation->set_rules('title', 'Titre', 'required|xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'required|xss_clean');
        $this->form_validation->set_rules('galerie', 'Galerie', 'xss_clean');
        // On change les delimiters poru avoir le style bootstrap
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Erreurs!</strong> ', '</div>');
        // On met en français les messages d'erreurs de type champs obligatoire
        $this->form_validation->set_message('required', 'Le champ %s est requis');

        if($this->form_validation->run() === TRUE){
                //On rentre dans la BDD
                if(!empty($this->input->post('id'))){
                    $this->photo->update($this->input->post('id'), $this->input->post('title'), $this->input->post('description'), $this->input->post('galerie'));
                    $this->viewPhotos();
                }
                else{
                    //On enregistre l'image sur le serveur
                    $config['upload_path'] = ABSOLUTE_URL.'assets/upload/';
                    $config['allowed_types'] = 'gif|jpg|png';

                    $config['file_name']  = $this->photo->getFuturId();
                    $this->load->library('upload', $config);
                    $upload = $this->upload->do_upload();
                    if ( ! $upload){
                      $data['errors'] = array($this->upload->display_errors());
                      $this->template->load('backoffice/template','backoffice/photo/add', $data);
                    }
                  else{
                        $ext = $this->upload->data()['file_ext'];
                        //watermark
                        $config['source_image'] = ABSOLUTE_URL.'assets/upload/'.$config['file_name'].$ext;
                        $config['wm_text'] = 'Copyright 2014 - Auberge Boubaker ';
                        $config['wm_type'] = 'text';
                        $config['wm_font_path'] = ABSOLUTE_URL.'assets/fonts/chocolate.ttf';
                        $config['wm_font_size'] = '15';
                        $config['wm_font_color'] = 'ffffff';
                        $config['wm_vrt_alignment'] = 'bottom';
                        $config['wm_hor_alignment'] = 'center';
                        $config['wm_padding'] = '-20';
                        $this->load->library('image_lib', $config); 
                        $this->image_lib->watermark();

                        //on redimensionne l'image dans le dossier original
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = ABSOLUTE_URL.'assets/upload/'.$config['file_name'].$ext;
                        $config['new_image'] = ABSOLUTE_URL.'assets/upload/original/';
                        $config['width']     = 800;
                        $config['height']   = 600;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        

                        //Maintenant on crée la miniature
                        $config['source_image'] = ABSOLUTE_URL.'assets/upload/original/'.$config['file_name'].$ext;
                        $config['new_image'] = ABSOLUTE_URL.'assets/upload/thumbnail/';
                        $config['width']     = 300;
                        $config['height']   = 225;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();


                        $this->photo->create($this->input->post('title'), $this->input->post('description'), $this->input->post('galerie'), $ext);
                        $this->viewPhotos();
                    }
                
                
       
             }
         }
        else{
            $this->template->load('backoffice/template','backoffice/photo/add');
        }
    }

     // Edite une section
    public function editPhoto($id){
        $galeries = $this->photo->getGaleries();
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie->galerie.'\'';
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
        $data['update'] = $this->photo->getById($id);
        $this->template->load('backoffice/template','backoffice/photo/add', $data);
    }

    // Affiché la liste des photos
    public function viewPhotos(){
        $data['path_original'] = base_url().'assets/upload/original/';
        $data['path_thumbnail'] = base_url().'assets/upload/thumbnail/';
        $data['galeries'] = $this->photo->getByGaleries();
        $this->template->load('backoffice/template','backoffice/photo/view', $data);
    }

    // Supprime une photo
    public function deletePhoto($id){
        $this->photo->delete($id);
        $this->viewPhotos();
    }


    // ajouter une section
    
    public function addSection(){
        // On charge la ue qui permet d'ajouter une section
        //Chargement de wysihtml5 pour l'edition du contenu et de typeahead pour l'autocomplete des tags galerie
        $galeries = $this->photo->getGaleries();
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie->galerie.'\'';
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
        $this->form_validation->set_rules('menu', 'Titre du menu', 'required|xss_clean');
        $this->form_validation->set_rules('content', 'Contenu', 'required|xss_clean');
        $this->form_validation->set_rules('aside', 'Colonne', 'xss_clean');
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
            if(!empty($this->input->post('id'))) $this->section->update($this->input->post('id'), $this->input->post('title'), $this->input->post('menu'), $this->input->post('content'),  $this->input->post('aside'), $this->input->post('galerie'), $this->input->post('visible'));
            else $this->section->create($this->input->post('title'), $this->input->post('menu'), $this->input->post('content'), $this->input->post('aside'),  $this->input->post('galerie'), $this->input->post('visible'));
           
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
        $galeries = $this->photo->getGaleries();
        $galeries_tostring = '';
        $i = 0;
        foreach($galeries AS $galerie){
            if($i != 0) $galeries_tostring .= ',';
            $galeries_tostring .= '\''.$galerie->galerie.'\'';
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