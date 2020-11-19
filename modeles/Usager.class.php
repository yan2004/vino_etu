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
     * @param string $pseudo,$nom,$prenom,$mot_de_passe
     * @return Boolean Succès ou échec à modifiér.
     */
    
    public function sauvegardeModificationCompte($id,$nom,$prenom,$mot_de_passe)
    {
       
        $pwd = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $reponseObj = new stdClass();
        $requete = "UPDATE ". self::TABLE. " SET nom='". $nom. "',prenom='". $prenom. "',mot_de_passe='". $pwd. "' WHERE id=". $id;
        $res = $this->_db->query($requete);
        
        //echo $requete;
        
      
    }
    
	
}

?>