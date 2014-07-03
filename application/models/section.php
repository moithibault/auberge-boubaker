<?php
class Section extends CI_Model{

	function __construct(){

		parent::__construct();
		// On crée la table user si elle n'existe pas dans la base de données avec l'admin
		/*
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `sections`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`content` text NOT NULL,
			`visible` smallint(1) DEFAULT 0,
			`created_at` int(11) NOT NULL,
			PRIMARY KEY(`id`)
			);');

		$this->db->query('INSERT INTO `sections`(`id`, `title`, `content`, `visible`, `created_at`) VALUES
			(0, "Ma première section", "Lorem ipsum Dolor dolor dolor !", 1, '.time().')');
			*/

	}

	//Pour le menu et le listing
	function get(){
		$query = $this->db->query('SELECT id, title, content, visible, created_at FROM sections ORDER BY visible, created_at DESC');
		return $query->result();
	}
	
	//Pour la vue et la modification
	function getById($id){
		$query = $this->db->query('SELECT id, title, content, visible, created_at FROM sections WHERE id = "'.$id.'"');
		return $query->row();
	}

	//creation d'une entrée
	function create($title, $content, $visible, $galerie){
		if($visible == 1){
			$v = 1;
		}else{
			$v = 0;
		}
		$this->db->query('INSERT INTO sections(`id`, `title`, `content`, `visible`, `created_at`) VALUES 
			(0,"'.$title.'", "'.$content.'", '.$v.', '.time().' )');
	}

	// Supprime une entrée
	function delete($id){
		$this->db->query('DELETE FROM sections WHERE id = "'.$id.'"');
	}
   
}