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

		// TODO : FILTRER LES DONNÉES REÇUES DE L'USAGER

		

		$requete = $this->_db->query("SELECT mot_de_passe FROM vino__usager WHERE pseudo='" . $user . "'");

		if($row = mysqli_fetch_assoc($requete)){

			// comparaison du mot de passe avec le hash de la base de données 
			if(password_verify($password, $row["mot_de_passe"])){

				return true;
			}
		}
		return false;
	}

	public function creerCompte($pseudo, $nom, $prenom, $password){

		// TODO : FILTRER LES DONNÉES REÇUES DE L'USAGER

		
		$requete ="SELECT * FROM vino__usager WHERE pseudo = '". $pseudo . "'";
		$res = $this->_db->query($requete);
		$row_cnt = $res->num_rows;
		
		/**
		 * Si il n'y a pas de pseudo déjà exsité dans base de donnée
		 */
		if ($row_cnt == 0) {

			$_SESSION['pseudo'] = $pseudo;

			$password = password_hash($password, PASSWORD_DEFAULT);

			$requete = $this->_db->query("INSERT INTO vino__usager (pseudo, nom, prenom, mot_de_passe) VALUES ('" . $pseudo . "', '" . $nom . "', '" . $prenom . "', '" . $password . "')");

			// echo $requete;
			if($requete == 1){
				return true;
			}
			return false;
		} else {
			return false;
		}

	}


	// //fonction de filtre pour les entrées de l'usager
	// private function filtre($var){

	// 	$var = mysqli_real_escape_string($this->_db, $var);
	// 	return $var;
	// }
}

?>