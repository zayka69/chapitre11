<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>NewsLetter</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
<body>
	<?php date_default_timezone_set('Europe/Paris');?>
	<h2>Envoi de la newsletter le <?php echo date("Y-m-d H:i:s");?></h2>
	<hr />
	<?php
	$connect = mysqli_connect("127.0.0.1", "root", "", "NewsLetter");

	/* Vérification de la connexion */
	if (!$connect) {
		echo "Échec de la connexion : ".mysqli_connect_error();
		exit();
	}

	$requete = "SELECT * FROM Client order by Nom";
	if ($resultat = mysqli_query($connect,$requete)) {
		/* fetch le tableau associatif */
		while ($ligne = mysqli_fetch_assoc($resultat)) {
			echo "Nom:".$ligne['Nom'].", ";
			echo "Email:".$ligne['Email'];
			echo "<br />";
			//message au format HTML
			$message = 'Bonjour Mr/Mme '.$ligne['Nom'].' ! <br />Email : '.$ligne['Email'].'<br />'; 
			$message = $message.'Le message de la newletters est:'; 
			$message = $message.'A bientôt !'; 

			$from = "From: Jean Dupont <newsletter@monsite.fr>\n"; 
			$from = $from."Mime-Version: 1.0\nContent-Type: text/html; charset=ISO-8859-1\n"; 
			// envoie du mail 
			mail($ligne['Email'],'Newsletter',$message,$from); 

			//mise à jour de la date d'envoi dans la base de données
			$requeteMAJ = "UPDATE Client set Date_envoi=NOW() where Id=".$ligne['Id'];
			$resultatMAJ = mysqli_query($connect,$requeteMAJ);
		}
	}
	?>

</body>
</html>