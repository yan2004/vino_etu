<?php
/**
 * Class Bouteille
 * Cette classe possède les fonctions de gestion des bouteilles dans le cellier et des bouteilles dans le catalogue complet.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d'utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Bouteille extends Modele {

	const TABLE = 'vino__bouteille';
	
	/**
	 * Cette méthode permet d'obtenir la liste de toutes les bouteilles de notre catalogue
	 * 
	 * @return array toutes les rangées représentant chacune des bouteilles
	 */
	public function getListeBouteille()
	{
		
		$rows = Array();
		$res = $this->_db->query('Select * from '. self::TABLE);
		if($res->num_rows)		
		{
			while($row = $res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}

		return $rows;
	}
	
	/**
	 * Cette méthode permet d'obtenir la liste des bouteilles d'un cellier (en ce moment un seul)
	 * 
	 * @throws Exception Erreur de requête sur la base de données
	 * 
	 * @return array toutes les rangées représentant chacune des bouteilles du cellier
	 */
	public function getListeBouteilleCellier()
	{
		
		$rows = Array();
		$requete ='SELECT 
						c.id as id_bouteille_collection,
						c.id_bouteille, 
						c.date_achat, 
						c.garde_jusqua, 
						c.notes, 
						c.prix, 
						c.quantite,
						c.millesime,
						c.id_usager,
						b.id,
						b.nom,
						b.url_image,
						b.code_saq,
						b.pays,
						b.description,
						b.url_saq,
						b.id_type,
						t.type 
						from vino__bouteille__collection c 
						INNER JOIN vino__bouteille b ON c.id_bouteille = b.id
						INNER JOIN vino__type t ON t.id = b.id_type 
						INNER JOIN vino__usager u ON u.id = c.id_usager
						WHERE u.courriel = "' . $_SESSION["courriel"] . '" ORDER BY id_bouteille_collection
						'; 
		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$row['nom'] = trim(utf8_encode($row['nom']));
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
	 * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de l'ajout des bouteilles dans le cellier
	 * 
	 * @param string $nom La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array id et nom de la bouteille trouvée dans le catalogue
	 */

	public function autocomplete($nom, $nb_resultat=10)
	{
		
		$rows = Array();
		$nom = $this->_db->real_escape_string($nom);
		$nom = preg_replace("/\*/","%" , $nom);
		
		$requete ='SELECT id, nom, prix_saq FROM vino__bouteille where LOWER(nom) like LOWER("%'. $nom .'%") LIMIT 0,'. $nb_resultat; 

		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$row['nom'] = trim(utf8_encode($row['nom']));
					$rows[] = $row;
					
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de données", 1);
			 
		}

		return $rows;
	}
    
    
    /**
     * Cette méthode ajoute une ou des bouteilles au cellier avec les données provenant de l'utilisateur
     * 
     * @param Object $data Tableau des données représentants la bouteille.
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
    public function ajouterBouteilleCellier($data)
    {
		
		$requete = "SELECT id FROM vino__usager WHERE courriel ='" . $data->courriel . "'";
		$res = $this->_db->query($requete);
		if($res->num_rows == 1)
		{
			$row = $res->fetch_assoc();
			$id_usager = $row["id"];

			if(empty($data->millesime)) $data->millesime = 'NULL';

			$requete = "INSERT INTO vino__bouteille__collection(id_bouteille, date_achat, garde_jusqua, notes, prix, quantite, millesime, id_usager) VALUES (".
			"'".$data->id_bouteille."',".
			"'".$data->date_achat."',".
			"'".$data->garde_jusqua."',".
			"'".$data->notes."',".
			"'".$data->prix."',".
			"'".$data->quantite."',".
			// "'".$data->millesime."',".
			$data->millesime.",".
			"'".$id_usager."')";

			
			$res = $this->_db->query($requete);
			
			return $res;
		}

		return false;

    }
    
    
    /**
     * Cette méthode change la quantité d'une bouteille en particulier dans le cellier
     * 
     * @param int $id id de la bouteille
     * @param int $nombre Nombre de bouteille a ajouter ou retirer
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
    public function modifierQuantiteBouteilleCellier($id, $nombre)
    {
		
		// filtrer les donnees de l'usager
		$id = $this->filtre($id);
		$nombre = $this->filtre($nombre);

        // creation de l'objet de la reponse
        $reponseObj = new stdClass();

        $requete = "UPDATE vino__bouteille__collection SET quantite = GREATEST(quantite + ". $nombre. ", 0) WHERE id = ". $id;

        $res = $this->_db->query($requete);

        if($res){

            // si l'update a fonctionné on construit un objet avec la réponse
            $reponseObj->success = true;

            $requete = "SELECT quantite FROM vino__bouteille__collection WHERE id =" . $id;

            $reponse = $this->_db->query($requete);

            if($reponse->num_rows){

                $row = $reponse->fetch_assoc();
                $quantite = $row['quantite'];

                // si le select a fonctionné, on ajoute la nouvelle quantité à l'objet réponse
                $reponseObj->quantite = $quantite;              
            }
        } else {
            $reponseObj->success = false;
        }

        return $reponseObj;
	}
	

    /**
     * Cette méthode change l'information d'une bouteille en particulier dans le cellier
     * 
     * @param int $id id de la bouteille
     * @param int $nombre Nombre de bouteille a ajouter ou retirer
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
	public function modificationInfoBtl($id,$date_achat,$garde_jusqua,$notes,$prix,$quantite,$millesime)
	{
		// vu que le type de millesime est un INT, on doit mettre NULL si le champs d'est pas rempli (sinon "" est une erreur, car ça reste un string même si vide)
		if(empty($millesime)) $millesime = 'NULL';

		$requete = "UPDATE vino__bouteille__collection SET date_achat='". $date_achat. "',garde_jusqua='". $garde_jusqua. "',notes='". $notes. "',prix='". $prix. "',quantite='". $quantite. "',millesime=". $millesime ." WHERE id=". $id;
		//echo $requete;
		$res = $this->_db->query($requete);
		return $res;
	}

	public function getListeBouteilleCellierById($id)
	{
		$rows = Array();
		$requete = "SELECT c.*, b.nom FROM vino__bouteille__collection c
					INNER JOIN vino__bouteille b ON c.id_bouteille = b.id
					WHERE c.id ='". $id . "'";
		//echo $requete;
		$res = $this->_db->query($requete);
		if($res->num_rows)		
		{
			while($row = $res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}

		return $rows;
	}

	/**
     * Cette méthode supprime une bouteille (tuile entière) du cellier
     * 
     * @param Object $data Tableau des données représentants la bouteille.
     * 
     * @return Boolean Succès ou échec de l'ajout.
     */
    public function supprimerBouteilleCellier($data){

		// filtrer les donnees de l'usager
		$data->id = $this->filtre($data->id);

		// recuperation de l'id de l'usager en session
		$requete = "SELECT id FROM vino__usager WHERE courriel ='" . $_SESSION["courriel"] . "'";
		$res = $this->_db->query($requete);
		
		if($res->num_rows == 1){
			$row = $res->fetch_assoc();
			$id_usager = $row["id"];

			// echo $id_usager;
			// echo $data->id;

			$requete = "DELETE FROM vino__bouteille__collection WHERE id =" . $data->id . " AND id_usager =" . $id_usager;

			$res = $this->_db->query($requete);

			return $res == 1;

		}
		
		
	}
	
}

?>