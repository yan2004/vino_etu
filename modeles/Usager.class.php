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
    
    public function sauvegardeModificationCompte($id, $nom, $prenom, $mot_de_passe)
    {

        // filtrer les donnees de l'usager
        $id = $this->filtre($id);
        $nom = $this->filtre($nom);
        $prenom = $this->filtre($prenom);
        $mot_de_passe = $this->filtre($mot_de_passe);
        
        $pwd = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $reponseObj = new stdClass();
        $requete = "UPDATE ". self::TABLE. " SET nom='". $nom. "',prenom='". $prenom. "',mot_de_passe='". $pwd. "' WHERE id=". $id;
        $res = $this->_db->query($requete);
      
    }


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