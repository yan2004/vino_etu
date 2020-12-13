<?php
/**
 * Class SAQ
 * Classe qui permet d'aller récupérer des données du site de la SAQ
 *
 * @author Jonathan Martel
 * @version 1.0
 *
 */
class SAQ extends Modele {

	const DUPLICATION = 'duplication';
	const ERREURDB = 'erreurdb';
	const INSERE = 'Nouvelle bouteille insérée';

	private static $_webpage;
	private static $_status;
	private $stmt;

	public function __construct() {
		parent::__construct();
		if (!($this -> stmt = $this -> _db -> prepare("INSERT INTO vino__bouteille(nom, url_image, code_saq, pays, description, prix_saq, url_saq, format, id_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
			// echo "Echec de la préparation : (" . $mysqli -> errno . ") " . $mysqli -> error;
		}
	}

	/**
	 * Obtenir les informations des produits sur le site de la SAQ via requetes http avec curl
	 * @param int $nombre
	 * @param int $page
	 * 
	 * @return int nombre de produits qui ont été récupérés
	 */
	public function getProduits($nombre = 24, $page = 1) {

		// TEST
		// echo "getProduits</br></br>";

		$s = curl_init();
		$url = "https://www.saq.com/fr/produits/vin/vin-rouge?p=".$page."&product_list_limit=".$nombre."&product_list_order=name_asc";
		// $url = "http://www.saq.com/fr/produits/vin/vin-rouge?p=1&product_list_limit=24&product_list_order=name_asc";
		//curl_setopt($s, CURLOPT_URL, "http://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?searchType=&orderBy=&categoryIdentifier=06&showOnly=product&langId=-2&beginIndex=".$debut."&tri=&metaData=YWRpX2YxOjA8TVRAU1A%2BYWRpX2Y5OjE%3D&pageSize=". $nombre ."&catalogId=50000&searchTerm=*&sensTri=&pageView=&facet=&categoryId=39919&storeId=20002");
		//curl_setopt($s, CURLOPT_URL, "https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?categoryIdentifier=06&showOnly=product&langId=-2&beginIndex=" . $debut . "&pageSize=" . $nombre . "&catalogId=50000&searchTerm=*&categoryId=39919&storeId=20002");
		curl_setopt($s, CURLOPT_URL, $url);

		// pour pouvoir conserver la valeur de retour (en string) au lieu de l'output
		curl_setopt($s, CURLOPT_RETURNTRANSFER, true); 

		//curl_setopt($s, CURLOPT_FOLLOWLOCATION, 1);

		self::$_webpage = curl_exec($s);
		self::$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);
		curl_close($s);


		// création d'un DOM avec les infos récupérées du sites
		$doc = new DOMDocument();
		$doc -> recover = true;
		$doc -> strictErrorChecking = false;
		@$doc -> loadHTML(self::$_webpage);
		$elements = $doc -> getElementsByTagName("li");
		$i = 0;

		
		// aller chercher tous les éléments "li" qui contiennent la classe "product-item" pour traiter les informations des produits
		foreach ($elements as $key => $noeud) {

			if (strpos($noeud -> getAttribute('class'), "product-item") !== false) {

				// récupérer les informations pertinentes des "li"
				$info = self::recupereInfo($noeud);
				echo "<div><h3>".$info->nom . "</h3>";

				// ajouter les produits récupérés à la bd
				$retour = $this -> ajouteProduit($info);
				echo "<p>Code de retour : " . $retour -> raison . "</p>";
				if ($retour -> succes == false) {
					// echo "<pre>";
					// echo "</pre>";
					// echo "<br>";
				} else {
					$i++;
				}

				echo "</div>";
			}
		}
		return $i;
	}


	/**
	 * Supprimer les espaces dans une chaine
	 * @param string $chaine
	 */
	private function nettoyerEspace($chaine)
	{
		return preg_replace('/\s+/', ' ',$chaine);
	}

	/**
	 * Récupérer les informations d'une bouteille (provenant d'un "li") utiles à l'affichage
	 * 
	 * @param object $noeud
	 * 
	 * @return object les informations d'une bouteille
	 */
	private function recupereInfo($noeud) {

		$info = new stdClass();

		// $info -> img = $noeud -> getElementsByTagName("img") -> item(0) -> getAttribute('src'); // NON!

		// récupération des éléments "span"
		$eSpans = $noeud -> getElementsByTagName("span");
		foreach ($eSpans as $node){
			// on récupère l'image
			if ($node -> getAttribute('class') === 'product-image-wrapper'){
				$info -> img = $node -> getElementsByTagName("img") -> item(0) -> getAttribute('src');
			}
		}
		
		
		
		$a_titre = $noeud -> getElementsByTagName("a") -> item(0);

		$info -> url_saq = $a_titre->getAttribute('href');

		// Type, format et pays
		$aElements = $noeud -> getElementsByTagName("strong");
		foreach ($aElements as $node) {

			// on récupère le nom de la bouteille
			if ($node -> getAttribute('class') == 'product name product-item-name'){
				$info -> nom = self::nettoyerEspace(trim($node -> textContent));
			}

			// on récupère les autres informations : type, format, pays
			if ($node -> getAttribute('class') == 'product product-item-identity-format') {
				$info -> desc = new stdClass();
				$info -> desc -> texte = $node -> textContent;
				$info->desc->texte = self::nettoyerEspace($info->desc->texte);
				$aDesc = explode("|", $info->desc->texte);
				if (count ($aDesc) == 3) {
					
					$info -> desc -> type = trim($aDesc[0]);
					$info -> desc -> format = trim($aDesc[1]);
					$info -> desc -> pays = trim($aDesc[2]);
				}
				
				$info -> desc -> texte = trim($info -> desc -> texte);
			}
		}

		// Code de la SAQ d'une bouteille
		$aElements = $noeud -> getElementsByTagName("div");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'saq-code') {
				if(preg_match("/\d+/", $node -> textContent, $aRes))
				{
					$info -> desc -> code_SAQ = trim($aRes[0]);
				}
			}
		}


		// prix
		$aElements = $noeud -> getElementsByTagName("span");
		foreach ($aElements as $node) {

			// traitement de la chaine pour envoi à la bd
			if ($node -> getAttribute('class') == 'price') {

				$info -> prix = trim($node -> textContent);
				// on enlève le signe de $
				$info -> prix = rtrim($info -> prix, "$");
				// on remplace la virgule par un point
				$info -> prix = str_replace(",", ".", $info -> prix);

			}
		}
		return $info;
	}

	/**
	 * Rajouter les informations récupérées d'une bouteille à la base de données si elle n'y est pas déjà
	 * 
	 * @param object $bte
	 * 
	 * @return object réponse à savoir si on a pu ajouter le produit (bool), et si non pourquoi (string)
	 */
	private function ajouteProduit($bte) {

		$retour = new stdClass();
		$retour -> succes = false;
		$retour -> raison = '';

		// Récupérer l'id du type de la bouteille
		$rows = $this -> _db -> query("select id from vino__type where type = '" . $bte -> desc -> type . "'");
		
		// si le type existe dans la base de données
		if ($rows -> num_rows == 1) {
			$type = $rows -> fetch_assoc();
			$type = $type['id'];

			// Récupérer l'id de la bouteille qui a le code de la SAQ qu'on lui envoi
			$rows = $this -> _db -> query("select id from vino__bouteille where code_saq = '" . $bte -> desc -> code_SAQ . "'");

			// si le code de la bouteille (SAQ) n'existe pas déjà dans la bd (nouvelle bouteille), on ajoute la bouteille dans vino__bouteille
			if ($rows -> num_rows < 1) {
				
				$this -> stmt -> bind_param("sssssdssi", $bte -> nom, $bte -> img, $bte -> desc -> code_SAQ, $bte -> desc -> pays, $bte -> desc -> texte, $bte -> prix, $bte -> url_saq, $bte -> desc -> format, $type);
				$retour -> succes = $this -> stmt -> execute();
				$retour -> raison = self::INSERE;
			} else {
				$retour -> succes = false;
				$retour -> raison = self::DUPLICATION;
			}
		} else {
			$retour -> succes = false;
			$retour -> raison = self::ERREURDB;

		}
		return $retour;
	}
}


?>