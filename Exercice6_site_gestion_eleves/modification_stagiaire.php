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
if (isset($_POST['modification'])) {
	date_default_timezone_set('Europe/Paris');
	foreach ($_POST['modification'] as $valeur) {
		//Pour modifier la table stagiaire_formateur,il faut tout supprimer et créer ceux qui sont cochés
		$requete = "DELETE from stagiaire_formateur where Id_stagiaire = ".$valeur;
		$resultat = mysqli_query($connect,$requete);
		if (isset($_POST['formateur'.$valeur])) {
			foreach ($_POST['formateur'.$valeur] as $valeur_formateur) {
				$dt_debut = date_create_from_format('d/m/Y', $_POST['debut'.$valeur_formateur."_".$valeur]);
				$dt_fin = date_create_from_format('d/m/Y', $_POST['fin'.$valeur_formateur."_".$valeur]);
				$requete_formateur = "INSERT INTO stagiaire_formateur (Id_stagiaire, Id_formateur, Date_debut, Date_fin) VALUES (".$valeur.",".$valeur_formateur.",'".$dt_debut->format('Y/m/d')."','".$dt_fin->format('Y/m/d')."')";
				$resultat_formateur = mysqli_query($connect,$requete_formateur);
			}
		}
		$requete_stagiaire = "UPDATE stagiaire SET Nom='".htmlentities(addslashes($_POST['nom'.$valeur]),ENT_QUOTES)."',Prenom='".htmlentities(addslashes($_POST['prenom'.$valeur]),ENT_QUOTES)."',Id_nationalite=".$_POST['nationalite'.$valeur].",Id_type_formation=".$_POST['type_formation'.$valeur]." where Id = ".$valeur;
		$resultat_stagiaire = mysqli_query($connect,$requete_stagiaire);
	}
}
/* Fermeture de la connexion */
mysqli_close($connect);
header('location:liste_stagiaire_a_modifier.php');
?>
</body>
</html>