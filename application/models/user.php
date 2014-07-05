<?php
class User extends CI_Model{

	function __construct(){

		parent::__construct();
		// On crée la table users si elle n'existe pas dans la base de données avec l'admin
		/*
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `users`(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`username` varchar(64) NOT NULL,
			`password` varchar(255) NOT NULL,
			`created_at` int(11) NOT NULL,
			`log_at` int(11),
			PRIMARY KEY(`id`,`username`));
		');

		$this->db->query('INSERT INTO `users`(`id`, `username`, `password`, `created_at`, `log_at`) VALUES
			(0, "admin", "'.sha1("admin").'", '.time().', '.time().')');
			*/

	}
	// Renvoie vrai si l'utilisateur existe dans la BDD
	function get($username, $password){
		$query = $this->db->query('SELECT username FROM users WHERE username = "'.$username.'" AND password = "'.sha1($password).'"');
		return ($query->num_rows() > 0);
	}
	
	function update($username){
		$this->db->query('UPDATE users SET log_at = '.time().' WHERE username = "'.$username.'"');
	}
   
}