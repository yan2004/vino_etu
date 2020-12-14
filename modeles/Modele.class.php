<?php
/**
 * Class Modele
 * Template de classe modèle. Dupliquer et modifier pour votre usage.
 * 
 * @author Jin Yan, Marianne Soucy et Jonathan Martel
 * @version 1.0
 * @update 2020
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Modele {
	
    protected $_db;
	function __construct ()
	{
		$this->_db = MonSQL::getInstance();
	}

	//fonction de filtre pour les entrées de l'usager
	protected function filtre($var){

		$var = mysqli_real_escape_string($this->_db, $var);
		return $var;
	}
}

?>