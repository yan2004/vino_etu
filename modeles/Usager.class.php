<?php 
/**
 * class Usager
 * Cette class permet aux utilisateurs de modifier les informations de compte, telles que les emails
 */
class Usager extends Modele {
    const TABLE = 'vino__usager';

    /**
     * Cette méthode modifier les infos du compte
     * @param int $id id de l'usager
     * @param string $courriel, $nom, $prenom, $mot_de_passe
     * @return Boolean Succès ou échec à modifiér.
     */

    public function sauvegardeModificationCompte($nom, $prenom, $mot_de_passe)
    {

        // filtrer les donnees de l'usager
        $id = $this->filtre($id);
        $nom = $this->filtre($nom);
        $prenom = $this->filtre($prenom);
        // pas le mot_de_passe car il est hashé

        // recuperation de l'id de l'usager en session
		$requete = "SELECT id FROM vino__usager WHERE courriel ='" . $_SESSION["courriel"] . "'";
		$res = $this->_db->query($requete);
		
		if($res->num_rows == 1){
			$row = $res->fetch_assoc();
            $id_usager = $row["id"];
            
            if(isset($mot_de_passe) && !empty($mot_de_passe)){
                $pwd = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                $requete = "UPDATE ". self::TABLE. " SET nom='". $nom. "',prenom='". $prenom. "',mot_de_passe='". $pwd. "' WHERE id=". $id_usager;
                $res = $this->_db->query($requete);
            }
            else{
                $requete = "UPDATE ". self::TABLE. " SET nom='". $nom. "',prenom='". $prenom. "' WHERE id=". $id_usager;
                $res = $this->_db->query($requete);
            }
            return $res;
        }
        return false;
    }
    
    // public function sauvegardeModificationCompte($id, $nom, $prenom, $mot_de_passe)
    // {

    //     // filtrer les donnees de l'usager
    //     $id = $this->filtre($id);
    //     $nom = $this->filtre($nom);
    //     $prenom = $this->filtre($prenom);
        
        
    //     $pwd = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    //     $reponseObj = new stdClass();
    //     $requete = "UPDATE ". self::TABLE. " SET nom='". $nom. "',prenom='". $prenom. "',mot_de_passe='". $pwd. "' WHERE id=". $id;
    //     $res = $this->_db->query($requete);
      
    // }



 


    /**
     * Cette méthode récupère les valeurs de table vino_usager
     */
    public function getUserByCourriel($courriel)
    {
        // filtrer les donnees de l'usager
        $courriel = $this->filtre($courriel);

        $rows = Array();
        $requete = "SELECT * FROM ". self::TABLE. " WHERE courriel= '". $courriel. "'";

        if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de donnée", 1);
		}
		return $rows;
    }
}

?>