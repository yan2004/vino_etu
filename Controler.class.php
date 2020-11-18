<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
/*
if(isset($_REQUEST["commande"]))
{
	$commande = $_REQUEST["commande"];
	
}

switch($commande)
{
	case "ModifierCompte":
		//faire afficher le formulaire de login
		require_once('./dataconf.php');
	    require_once("./config.php");
		if(isset($_REQUEST["nom"], $_REQUEST["prenom"]))
		{
			
			$user  = new Usager();
			$user->modifierUsager(1,$_REQUEST["nom"],$_REQUEST["prenom"],$_REQUEST["mot_de_passe"]);

			include("vues/entete.php");
		    include("vues/compte.php");
		    include("vues/pied.php");	
			
		}
		
		
		break;
}
*/

class Controler 
{
	
		/**
		 * Traite la requête
		 * @return void
		 */
		public function gerer()
		{
			switch ($_GET['requete']) {
				case 'authentification':
					$this->authentification();
					break;
				case 'listeBouteille':
					$this->listeBouteille();
					break;
				case 'autocompleteBouteille':
					$this->autocompleteBouteille();
					break;
				case 'ajouterNouvelleBouteilleCellier':
					$this->ajouterNouvelleBouteilleCellier();
					break;
				case 'ajouterBouteilleCellier':
					$this->ajouterBouteilleCellier();
					break;
				case 'boireBouteilleCellier':
					$this->boireBouteilleCellier();
					break;
				case 'accueilUsager':
					$this->accueilUsager();
				case 'modifierCompte':
					$this->modifierCompte();
					break;
				default:
					$this->accueil();
					break;
			}

		
			
		}

		private function authentification()
		{
			// echo "controller-auth";

			$auth = new Authentification();


			// 1- test option 1 infos via ajax
			$valide = $auth->validerAuthentification($_POST['pseudo'], $_POST['password']);


			if($valide) {

				// TODO : sauvegarde de l'usager authentifié
				// $_SESSION["username"] = $_REQUEST["username"];
				
				$this->accueilUsager();

			}


		}

		// accueil publique (usager qui n'est pas encore authentifié)
		private function accueil()
		{
			// include("vues/entete.php");
			include("vues/welcome.php");
			// include("vues/pied.php");      
		}

		// cette méthode se nommait "accueil" avant
		private function accueilUsager()
		{
			$bte = new Bouteille();
			$data = $bte->getListeBouteilleCellier();
			include("vues/entete.php");
			include("vues/cellier.php");
			include("vues/pied.php");      
		}

		private function listeBouteille()
		{
			$bte = new Bouteille();
            $cellier = $bte->getListeBouteilleCellier();
            
            echo json_encode($cellier);
                  
		}
		
		private function autocompleteBouteille()
		{
			$bte = new Bouteille();
			//var_dump(file_get_contents('php://input'));
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
            $listeBouteille = $bte->autocomplete($body->nom);
            
            echo json_encode($listeBouteille);    
		}

		private function ajouterNouvelleBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
			if(!empty($body)){
				$bte = new Bouteille();
				//var_dump($_POST['data']);
				
				//var_dump($data);
				$resultat = $bte->ajouterBouteilleCellier($body);
				echo json_encode($resultat);
			}
			else{
				include("vues/entete.php");
				include("vues/ajouter.php");
				include("vues/pied.php");
			}
		}
		
		private function boireBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
			echo json_encode($resultat);
		}

		private function ajouterBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
			echo json_encode($resultat);
		}

		private function modifierCompte()
		{
			//$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);

			$usager = new Usager();
			$usager->modifierUsager($_POST['id'], $_POST['nom'],$_POST['prenom'], $_POST['mot_de_passe']);
			
			include("vues/entete.php");
			include("vues/compte.php");
			include("vues/pied.php");	
		}
		
		private function getCurrentUser()
		{

		}

}
?>















