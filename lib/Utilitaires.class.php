<?php
/**
 * Classe template pour l'affichage d'une table de datas dans le cadre d'un test unitaire
 *
 *
 */
class Utilitaires {
	
	/**
	 * 
	 * @param array $data 
	 * @return string table html des données
	 */
	public static function afficheTable($data) {
		$res = '';
		$header = '';
		foreach ($data as $cle => $enregistrement) 
		{
			$res .= '<tr>';
			$header = '';
			foreach ($enregistrement as $colonne => $valeur) {
				$header .= '<td>'. $colonne.'</td>';
				$res .= '<td>'. $valeur .'</td>';
			}
			$res .= '</tr>';
			$header = '<tr>' . $header .'</tr>';
		}
		$res = '<table>'. $header . $res . '</table>';
		return $res;
	}

}
?>