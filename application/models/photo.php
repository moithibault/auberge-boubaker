<?php
class Photo extends CI_Model{

	function __construct(){

		parent::__construct();
		// On crée la table photos si elle n'existe pas dans la base de données avec l'admin
		
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `photos`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`title` varchar(255) NOT NULL,
			`description` text NOT NULL,
			`galerie` varchar(64),
			`extension` varchar(4),
			`created_at` int(11) NOT NULL,
			PRIMARY KEY(`id`)
			);');


	}
	//récupérer les noms distincts de galeries présentes
	function getGaleries(){
		//TODO voir le temps d'une requête pour un DISCTINCT et un GROUP BY
		$query = $this->db->query('SELECT galerie FROM photos GROUP BY galerie');
		return $query->result();
	}

		//Pour le listing
	function getByGaleries(){
		//1) onr écupére les galeries
		$galeries = $this->getGaleries();
		foreach($galeries AS $galerie){
			$query = $this->db->query('SELECT id, title, description, galerie, extension, created_at FROM photos WHERE galerie = "'.$galerie->galerie.'"');
			$photos = $query->result();
			foreach($photos AS $photo){
				$galerie->photos[$photo->id] = $photo;
			}
		
		}
		
		return $galeries;
	}

	function getNbPhotos($galerie){
		$query = $this->db->query('SELECT id FROM photos WHERE galerie = "'.$galerie.'"');
		return $query->num_rows();
	}

	//récupere le dernier id + 1
	function getFuturId(){
		$query = $this->db->query('SELECT max(id)+1 AS max FROM photos;');
		$result = $query->row();
		return $result->max;
	}
	

	//Pour le listing
	function get(){
		$query = $this->db->query('SELECT id, title, description, galerie, extension, created_at FROM photos ORDER BY created_at DESC');
		return $query->result();
	}
	
	//Pour la vue et la modification
	function getById($id){
		$query = $this->db->query('SELECT  id, title, description, galerie, extension, created_at FROM photos WHERE id = "'.$id.'"');
		return $query->row();
	}

	//creation d'une entrée
	function create($title, $description , $galerie, $extension){
		$this->db->query('INSERT INTO photos(`id`, `title`, `description`, `galerie`, `extension`, `created_at`) VALUES 
			(0,"'.$title.'", "'.$description.'","'.$galerie.'", "'.$extension.'", '.time().' )');
	}

	//update d'une entrée
	function update($id, $title, $description , $galerie){
		$this->db->query('UPDATE photos SET title = "'.$title.'", description = "'.$description.'",  galerie = "'.$galerie.'" WHERE id = '.$id);
	}

	// Supprime une entrée
	function delete($id){
	
		$photo = $this->getById($id);

		unlink(ABSOLUTE_URL.'assets/upload/'.$photo->id.$photo->extension);
		unlink(ABSOLUTE_URL.'assets/upload/original/'.$photo->id.$photo->extension);
		unlink(ABSOLUTE_URL.'assets/upload/thumbnail/'.$photo->id.$photo->extension);

	    $this->db->query('DELETE FROM photos WHERE id = "'.$id.'"');
	}
   
}