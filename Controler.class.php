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
				    break;
				case 'modifierCompte':
					$this->modifierCompte();
					break;
				case 'creerCompte':
					$this->creerCompte();
					break;
				case 'sauvegardeCompte':
					$this->sauvegardeCompte();
					break;
				case 'deconnexion':
					$this->deconnexion();
					break;
				default:
					$this->accueil();
					break;
			}

		
			
		}

		private function authentification()
		{

			$auth = new Authentification();

			$valide = $auth->validerAuthentification($_POST['pseudo'], $_POST['password']);

			if($valide) {

				// sauvegarde de l'usager authentifié
				$_SESSION["pseudo"] = $_POST["pseudo"];
				
				$this->accueilUsager();
			}else {
				$this->accueil();
			}
		}

		private function creerCompte()
		{
			$auth = new Authentification();

			$resultat = $auth->creerCompte($_POST['pseudo'], $_POST['nom'], $_POST['prenom'], $_POST['password']);

			/**
			 * Redirection à la page d'accueil suite à la création de compte avec message d'erreur au besoin
			 */
			
			$this->accueil($resultat);
		}

		// accueil publique (usager qui n'est pas encore authentifié)
		private function accueil($data=null)
		{
			include("vues/welcome.php");     
		}

		// cette méthode se nommait "accueil" avant
		private function accueilUsager()
		{
			if(isset($_SESSION['pseudo'])){

				$bte = new Bouteille();
				$data = $bte->getListeBouteilleCellier();
				include("vues/entete.php");
				include("vues/cellier.php");
				include("vues/pied.php");  
			}else{

				$this->accueil();
			}
			    
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

			$body = json_decode(file_get_contents('php://input'));

            $listeBouteille = $bte->autocomplete($body->nom);
            
            echo json_encode($listeBouteille);    
		}

		private function ajouterNouvelleBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));

			if(!empty($body)){
				$bte = new Bouteille();

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
			$usager = new Usager();
			$data = $usager->getUserByPseudo($_SESSION['pseudo']);
			
			include("vues/entete.php");
			include("vues/compte.php");
			include("vues/pied.php");

		}

		private function sauvegardeCompte()
		{
			/**
			 * *******************
			 * To Do
			 * récupérer id d'usager quand authentification
			 * *******************
			 */
			$usager = new Usager();
			$usager->sauvegardeModificationCompte($_POST['userId'], $_POST['nom'],$_POST['prenom'], $_POST['mot_de_passe']); 

			$bte = new Bouteille();
			$data = $bte->getListeBouteilleCellier();
			include("vues/entete.php");
			include("vues/cellier.php");
			include("vues/pied.php"); 
		}
		
		private function getCurrentUser()
		{

		}

		private function deconnexion(){

			//fermer la session usager
			session_destroy();

			$this->accueil();
		}
}
?>















