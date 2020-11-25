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

	public function validerAuthentification($courriel, $password){

		// filtrer les donnees de l'usager
		$courriel = $this->filtre($courriel);

		$requete = $this->_db->query("SELECT mot_de_passe FROM vino__usager WHERE courriel='" . $courriel . "'");

		if($row = mysqli_fetch_assoc($requete)){

			// comparaison du mot de passe avec le hash de la base de données 
			if(password_verify($password, $row["mot_de_passe"])){
				return true;
			}
		}
		return false;
	}

	public function creerCompte($courriel, $nom, $prenom, $password){

		// filtrer les donnees de l'usager
		$courriel = $this->filtre($courriel);
		$nom = $this->filtre($nom);
		$prenom = $this->filtre($prenom);
		
		$requete ="SELECT * FROM vino__usager WHERE courriel = '". $courriel . "'";
		$res = $this->_db->query($requete);
		$row_cnt = $res->num_rows;
		
		// Si le courriel n'existe pas déjà dans la base de données, on créé le compte
		if ($row_cnt == 0) {

			$_SESSION['courriel'] = $courriel;
			$password = password_hash($password, PASSWORD_DEFAULT);
			$requete = $this->_db->query("INSERT INTO vino__usager (courriel, nom, prenom, mot_de_passe) VALUES ('" . $courriel . "', '" . $nom . "', '" . $prenom . "', '" . $password . "')");

			if($requete == 1){
				return true;
			}
			// la requete n'a pas pu être effectuée
			else{
				return false;
			}
		// le courriel existe déjà
		} else {
			return false;
		}
	}
}

?>