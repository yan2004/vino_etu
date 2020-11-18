<?php 
/**
 * class Usager
 * Cette class permet aux utilisateurs de modifier les informations de compte, telles que les emails
 */
class Usager extends Modele {
    const TABLE = 'vino__usager';

    /**
	 * Cette méthode permet d'obtenir l'information d'usager dans notre DB
	 * @param int $id id de l'usager
	 * @return array toutes les rangées représentant chacune des usagers
	 */
	public function getListeUsager($id)
	{
		
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM '. self::TABLE. ' WHERE id='. $id);
		if($res->num_rows)                                          /* determine number of rows result set */
		{
			while($row = $res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}

		return $rows;
    }
    


    /**
     * Cette méthode modifier les infos du compte
     * @param int $id id de l'usager
     * @param string $pseudo,$nom,$prenom,$mot_de_passe
     * @return Boolean Succès ou échec à modifiér.
     */
    public function modifierUsager($id,$nom,$prenom,$mot_de_passe)
    {
        echo $id. $nom . $prenom. $mot_de_passe;
        $requete = $this->_db->query("UPDATE ". self::TABLE. " SET nom=". $nom. ",prenom=". $prenom. ",mot_de_passe=". $mot_de_passe. " WHERE id=". $id);
        echo $requete;
        $row = mysqli_fetch_assoc($requete);
        
        
    }
	
}

?>