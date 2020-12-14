<?php 
/**
 * class Admin
 * Cette class permet à Administrateur de gérér les Usager
 */
class Admin extends Modele 
{
    public function getListeUsagers(){
        $rows    = Array();
        $requete = "SELECT * FROM vino__usager WHERE admin = 0";

        if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					//$row['nom'] = trim(utf8_encode($row['nom']));
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

    /**
     * Fonction pour supprimer un usager de la bd
     * @param int $idUsagerSupr id de l'usager
	 * @return boolean si la requête a fonctionné ou non
     */
    public function supprimerUsager($idUsagerSupr){

        // filtrer les donnees de l'usager
        $idUsagerSupr = $this->filtre($idUsagerSupr);
        
        $requete = "SELECT * FROM vino__bouteille__collection WHERE id_usager=" . $idUsagerSupr;
        $res = $this->_db->query($requete);

        //S'il y a des bouteilles dans son cellier 
        if($res->num_rows > 0){
            $requete = "DELETE FROM vino__bouteille__collection WHERE id_usager = ". $idUsagerSupr;
            $res = $this->_db->query($requete);

            //Si réussir de supprimer les bouteilles de cellier
            if($res->affected_rows > 0){
                $requete = "DELETE FROM vino__usager WHERE id = ". $idUsagerSupr;
                $res = $this->_db->query($requete);
                return $res == 1;
            }
        }else{
            $requete = "DELETE FROM vino__usager WHERE id = ". $idUsagerSupr;
            $res = $this->_db->query($requete);
			return $res == 1;
        }
        return false;
    }
}
?>