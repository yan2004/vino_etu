<!DOCTYPE HTML>
<html>
	
	<head>
		<meta charset="UTF-8" />	
	</head>
	<body>
<?php
	//require("dataconf.php");
	//require("config.php");
	$page = 1;
	$nombreProduit = 24; //48 ou 96	
	
	$saq = new SAQ();
	for($i=0; $i<1;$i++)	//permet d'importer séquentiellement plusieurs pages. Pour l'instant, une seule.
	{
		
		echo "<h2>PAGE ". ($page+$i)."</h2>";
		echo '<div class="bouteillesImport">';
		$nombre = $saq->getProduits($nombreProduit,$page+$i);
		echo '<h3 class="nbrImport">IMPORTATION : '. $nombre. '</h3>';
		echo "</div>";
	}

?>
</body>
</html>