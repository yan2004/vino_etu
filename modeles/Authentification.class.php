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

		// filtrer les donnees de l'usager
		$user = $this->filtre($user);
		
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

		// filtrer les donnees de l'usager
		$pseudo = $this->filtre($pseudo);
		$nom = $this->filtre($nom);
		$prenom = $this->filtre($prenom);
		

		// creation de l'objet de la reponse
        $reponseObj = new stdClass();
		
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

			if($requete == 1){
				$reponseObj->success = true;
				$reponseObj->msgSuccess = "Succès! Vous pouvez maintenant vous connecter.";
			}
			else{
				$reponseObj->success = false;
				$reponseObj->msgErreur = "";
			}
		} else {
			$reponseObj->success = false;
			$reponseObj->msgErreur = "Ce pseudo est déjà pris.";
		}
		return $reponseObj;
	}
}

?>