<?php
/**
 * Class Authentification
 * Cette classe possède les fonctions de gestion de l'authentification d'un usager sur l'application
 * 
 * @author Marianne Soucy
 * @version 1.0
 * 
 */
class Authentification extends Modele {


	public function validerAuthentification($user, $password){

		// TODO : filtrer les donnees
		// TODO : HASHER LE PASSWORD


		$requete = $this->_db->query("SELECT mot_de_passe FROM vino__usager WHERE pseudo='" . $user . "'");

		if($row = mysqli_fetch_assoc($requete)){

			// echo $row["mot_de_passe"];

			
			// // comparaison du mot de passe avec le hash de la base de données 
			// if(password_verify($password, $row["mot_de_passe"])){

			// 	// rediriger vers l'action de controller pour accueilUsager
			// 	return true;
			// }

			// test temporaire pour debug de la fonctionnalité
			if($password == $row["mot_de_passe"]) return true;
		}
		return false;
	}


	// //fonction de filtre pour les entrées de l'usager
	// private function filtre($var){

	// 	$var = mysqli_real_escape_string($this->_db, $var);
	// 	return $var;
	// }
}

?>