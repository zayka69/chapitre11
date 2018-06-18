<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<?php
$connect = mysqli_connect("127.0.0.1", "root", "", "formation");

/* Vérification de la connexion */
if (!$connect) {
    echo "Échec de la connexion : ".mysqli_connect_error();
    exit();
}

?>
<head>
	<title>Exerice formation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
	
</head>

<body>


<?php
if (isset($_POST['suppression'])) {

	foreach ($_POST['suppression'] as $valeur) {
		$requete = "DELETE from stagiaire_formateur where Id_stagiaire = ".$valeur;
		$resultat = mysqli_query($connect,$requete);
		$requete = "DELETE from stagiaire where Id = ".$valeur;
		$resultat = mysqli_query($connect,$requete);
	}
}
/* Fermeture de la connexion */
mysqli_close($connect);
header('location:liste_stagiaire_a_supprimer.php');
?>
</body>
</html>