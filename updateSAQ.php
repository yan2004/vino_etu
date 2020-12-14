<!DOCTYPE HTML>
<html>
	
	<head>
		<meta charset="UTF-8" />	
	</head>
	<body>
	<?php
		
		$saq = new SAQ();

		// importation séquentielle de plisieurs pages selon les paramètres envoyés
		for($i=1; $i<=$nbrPages; $i++)
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