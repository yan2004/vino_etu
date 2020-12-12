<!DOCTYPE HTML>
<html>
	
	<head>
		<meta charset="UTF-8" />	
	</head>
	<body>
	<?php
		//require("dataconf.php");
		//require("config.php");
		// $nbrPages = $_POST['nbrPages'];
		// $nombreItems = $_POST['nbrItems']; //48 ou 96	

		echo $nbrPages;
		echo $nombreItems;
		echo "test";
		
		$saq = new SAQ();
		for($i=1; $i<=$nbrPages; $i++)	//permet d'importer séquentiellement plusieurs pages.
		{
			echo "<h2>PAGE ". ($i)."</h2>";
			echo '<div class="bouteillesImport">';

			$nombre = $saq->getProduits($nombreItems,$i);

			echo '<h3 class="nbrImport">IMPORTATION : '. $nombre. '</h3>';
			echo "</div>";
		}

	?>
	</body>
</html>