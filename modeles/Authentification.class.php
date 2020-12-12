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

	/**
	 * Valider l'authentification avec les données entrées par l'usager
	 * @param string $courriel le courriel de l'usager
	 * @param string $password le mot de passe de l'usager
	 * @return boolean si les informations envoyées sont valides ou non
	 */
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

	/**
	 * Fonction permettant d'ajouter un usager dans la bd
	 * @param string $courriel le courriel de l'usager
	 * @param string $nom le nom de l'usager
	 * @param string $prenom le prenom de l'usager
	 * @param string $password le mot de passe de l'usager
	 * @return boolean si on a pu créer l'usager dans la bd ou non
	 */
	public function creerCompte($courriel, $nom, $prenom, $password){

		// filtrer les donnees de l'usager
		$courriel = $this->filtre($courriel);
		$nom = $this->filtre($nom);
		$prenom = $this->filtre($prenom);
		
		// on vérifie si un usager avec ce courriel existe déjà
		$requete ="SELECT * FROM vino__usager WHERE courriel = '". $courriel . "'";
		$res = $this->_db->query($requete);
		$row_cnt = $res->num_rows;
		
		// Si le courriel n'existe pas déjà dans la base de données, on créé le compte
		if ($row_cnt == 0) {

			// on met le courriel dans la session pour usage futur
			$_SESSION['courriel'] = $courriel;
			// on hash le mot de passe avant de l'entrer dans la bd
			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$requete = $this->_db->query("INSERT INTO vino__usager (courriel, nom, prenom, mot_de_passe, admin) VALUES ('" . $courriel . "', '" . $nom . "', '" . $prenom . "', '" . $password . "', false)");

			if($requete == 1){
				$_SESSION['password'] = $password;
				setcookie("courriel", $courriel, time()+(60*60*24*30));
				setcookie("password", $password, time()+(60*60*24*30));
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


	public function adminVerification($courriel) {
		$requete ="SELECT admin FROM vino__usager WHERE courriel = '". $courriel . "'";
		$res = $this->_db->query($requete);
		
		if ($row = mysqli_fetch_assoc($res)) {
			if($row['admin'] == 1){
				return true;
			}else{
				return false;
			};
		}
		
		
	}
}

?>