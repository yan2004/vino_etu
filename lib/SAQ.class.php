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
		$s = curl_init();
		$url = "https://www.saq.com/fr/produits/vin/vin-rouge?p=1&product_list_limit=24&product_list_order=name_asc";
		//curl_setopt($s, CURLOPT_URL, "http://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?searchType=&orderBy=&categoryIdentifier=06&showOnly=product&langId=-2&beginIndex=".$debut."&tri=&metaData=YWRpX2YxOjA8TVRAU1A%2BYWRpX2Y5OjE%3D&pageSize=". $nombre ."&catalogId=50000&searchTerm=*&sensTri=&pageView=&facet=&categoryId=39919&storeId=20002");
		//curl_setopt($s, CURLOPT_URL, "https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?categoryIdentifier=06&showOnly=product&langId=-2&beginIndex=" . $debut . "&pageSize=" . $nombre . "&catalogId=50000&searchTerm=*&categoryId=39919&storeId=20002");
		curl_setopt($s, CURLOPT_URL, $url);
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
			var_dump($noeud -> getAttribute('class')) ;
			//if ("resultats_product" == str$noeud -> getAttribute('class')) {
			if (strpos($noeud -> getAttribute('class'), "product-item") !== false) {

				//echo $this->get_inner_html($noeud);

				// récupérer les informations pertinentes des "li"
				$info = self::recupereInfo($noeud);
				echo "<p>".$info->nom;

				// ajouter les produits récupérés à la bd
				$retour = $this -> ajouteProduit($info);
				echo "<br>Code de retour : " . $retour -> raison . "<br>";
				if ($retour -> succes == false) {
					echo "<pre>";
					var_dump($info);
					echo "</pre>";
					echo "<br>";
				} else {
					$i++;
				}
				echo "</p>";
			}
		}

		return $i;
	}

	/**
	 * Récupérer le contenu des nodes
	 * 
	 * @param object $node
	 * 
	 * @return string contenu textuel du node
	 */
	// private function get_inner_html($node) {
	// 	$innerHTML = '';
	// 	$children = $node -> childNodes;
	// 	foreach ($children as $child) {
	// 		$innerHTML .= $child -> ownerDocument -> saveXML($child);
	// 	}

	// 	return $innerHTML;
	// }

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
		$info -> img = $noeud -> getElementsByTagName("img") -> item(0) -> getAttribute('src'); //TODO : Nettoyer le lien
		
		$a_titre = $noeud -> getElementsByTagName("a") -> item(0);
		$info -> url_saq = $a_titre->getAttribute('href');
		
		$info -> nom = self::nettoyerEspace(trim($a_titre -> textContent));	//TODO : Retirer le format de la bouteille du titre.
		
		// Type, format et pays
		$aElements = $noeud -> getElementsByTagName("strong");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'product product-item-identity-format') {
				$info -> desc = new stdClass();
				$info -> desc -> texte = $node -> textContent;
				$info->desc->texte = self::nettoyerEspace($info->desc->texte);
				$aDesc = explode("|", $info->desc->texte); // Type, Format, Pays
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

		// *********************************************************************************************************
		// prix !! Problème du prix tronqué est potentiellement ici - NON JE NE PENSE PAS FINALEMENT VOIR LIGNE 203
		$aElements = $noeud -> getElementsByTagName("span");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'price') {

				$info -> prix = trim($node -> textContent);
			}
		}
		// *********************************************************************************************************

		//var_dump($info);
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

		//var_dump($bte);

		// Récupérer l'id du type de la bouteille
		$rows = $this -> _db -> query("select id from vino__type where type = '" . $bte -> desc -> type . "'");
		
		// si le type existe dans la base de données
		if ($rows -> num_rows == 1) {
			$type = $rows -> fetch_assoc();
			//var_dump($type);
			$type = $type['id'];

			// Récupérer l'id de la bouteille qui a le code de la SAQ qu'on lui envoi
			$rows = $this -> _db -> query("select id from vino__bouteille where code_saq = '" . $bte -> desc -> code_SAQ . "'");

			// si le code de la bouteille (SAQ) n'existe pas déjà dans la bd (nouvelle bouteille), on ajoute la bouteille dans vino__bouteille
			if ($rows -> num_rows < 1) {
				
				// **************************************************************************************************************************************
				// bug du prix_saq ici, je pense que c'est réglé (à suivre lorsqu'on testera Update.SAQ), c'était indiqué "i" au lieu de "d" pour double 
				// **************************************************************************************************************************************

				// TODO : TESTER POUR SAVOIR S'IL FAUT MODIFIER LE TYPE DE LA BD EN "DOUBLE" AU LIEU DE "FLOAT"
				// Je ne pense pas parce qu'ils représentent tous 2 semblablement la même chose au final

				$this -> stmt -> bind_param("sssssdssi", $bte -> nom, $bte -> img, $bte -> desc -> code_SAQ, $bte -> desc -> pays, $bte -> desc -> texte, $bte -> prix, $bte -> url_saq, $bte -> desc -> format, $type);
				$retour -> succes = $this -> stmt -> execute();
				$retour -> raison = self::INSERE;
				//var_dump($this->stmt);
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