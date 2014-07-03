<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Gestion de la connexion pour le backoffice
class Login extends CI_Controller {

    public function __construct()
    {
    	parent::__construct();
    	$this->load->library(array('session', 'form_validation', 'template'));
    	$this->load->helper(array('form', 'url'));
    	$this->load->model('user');
    }

	public function index()
	{	
		// L'utilisateur est déjà connecté, on l'emméne au bo
		if($this->session->userdata('logged_in')){
			redirect('backoffice');
			exit(0);
		}
		else{
			$this->template->load('login/template','login/login');
		}
	}

	// reception des données de connexion
	public function post(){
		$this->form_validation->set_rules('username', 'Nom d\'utilisateur', 'required|xss_clean', 'callback_login_check');
		$this->form_validation->set_rules('password', 'Mot de passe', 'required|xss_clean');
		// On change les delimiters poru avoir le style bootstrap
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Erreurs!</strong> ', '</div>');
		// On met en français les messages d'erreurs de type champs obligatoire
		$this->form_validation->set_message('required', 'Le champ %s est requis');

		if ($this->form_validation->run() == TRUE)
		{
		    if($this->user->get($this->input->post('username'), $this->input->post('password')) == TRUE){
		    	//là tout est ok
		    	// on crée la session
		    	$newdata = array(
                   'username'  => $this->input->post('username'),
                   'logged_in' => TRUE
               );
		    	$this->session->set_userdata($newdata);
		    	//On maj la date de connexiond e l'utilisateur
		    	$this->user->update($this->input->post('username'));
		    	//on retourne à l'index avec la session !
		    	$this->index();
		    }
		    else{
		    	$data['errors'] = '<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>Erreurs!</strong> Mauvais identifiants</div>';
		    	$this->template->load('login/template','login/login', $data);
		    }
		}
		else
		{
			$this->template->load('login/template','login/login');
		}
	}

	// deconnexion - on détruit la session
	public function logout(){
		$this->session->sess_destroy();
		$this->index();
	}

}