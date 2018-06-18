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

<h2>Réception des données du stagiaire à insérer</h2><br />

nom: <?php echo $_POST['nom'];?><br /><br />
prénom: <?php echo $_POST['prenom'];?><br /><br />
nationalité: <?php echo $_POST['nationalite'];?><br /><br />
type de la formation: <?php echo $_POST['type_formation'];?><br /><br />
<?php
$requete = "INSERT INTO stagiaire (Nom, Prenom, Id_nationalite, Id_type_formation) VALUES ('".htmlentities(addslashes($_POST['nom']))."','".htmlentities(addslashes($_POST['prenom']))."',".$_POST['nationalite'].",".$_POST['type_formation'].")";
$resultat = mysqli_query($connect,$requete);
$identifiant=mysqli_insert_id($connect);

if (isset($_POST['formateur'])) {?>
	formateurs par date:<?php print_r($_POST['formateur']);?><br />
<?php	//définie la zone en France pour la date
	date_default_timezone_set('Europe/Paris');

	foreach ($_POST['formateur'] as $valeur) {
		$dt_debut = date_create_from_format('d/m/Y', $_POST['debut'.$valeur]);
		$dt_fin = date_create_from_format('d/m/Y', $_POST['fin'.$valeur]);
		$requete = "INSERT INTO stagiaire_formateur (Id_stagiaire, Id_formateur, Date_debut, Date_fin) VALUES (".$identifiant.",".$valeur.",'".$dt_debut->format('Y/m/d')."','".$dt_fin->format('Y/m/d')."')";
		$resultat = mysqli_query($connect,$requete);
	}
}
/* Fermeture de la connexion */
mysqli_close($connect);

?>
<br />
Ajout du stagiaire réussi !
<br /><br />
<a href="formation.php">Retour sur l'ajout d'un stagiaire</a>
</body>
</html>