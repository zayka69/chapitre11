<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Blog</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
<body>
	<h2>Blog</h2>
	<hr />
	<?php
	include('Blog.class.php');
	include('Manager.class.php');
	try
	{
		// Connexion à la base de données
		$base = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', '');
		$base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		$manager = new Manager($base);
		$tableau_retour = $manager->getContenuParDate();
		if (empty($tableau_retour))
		{
			echo 'Aucun message.';
		}			
		else {
			date_default_timezone_set('Europe/Paris');
			foreach ($tableau_retour as $valeur) { //$valeur contient l'objet blog
				$dt_debut = date_create_from_format('Y-m-d H:i:s', $valeur->getDate());
				echo "<h3>".$valeur->getTitre()."</h3>";
				echo "<h4>Le ".$dt_debut->format('d/m/Y H:i:s')."</h4>";
				echo "<div style='width:400px'>".$valeur->getCommentaire()."</div>";
				if ($valeur->getPhoto() != "") {
					echo "<img src='photos/".$valeur->getPhoto()."' width='200px' height='200px'/>";
				}
				echo "<hr />";
			}
		}
		
	}	
	catch(Exception $e)
	{
		// message en cas d'erreur
		die('Erreur : '.$e->getMessage());
	}

	?>
	<br />
	<a href="formulaire_ajout.php" >retour à la page d'insertion</a>
</body>
</html>
