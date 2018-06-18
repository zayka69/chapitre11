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

<h2>Suppression des données du stagiaire</h2><br />
<form action="suppression_stagiaire.php" method="POST">
<table border="1">
<tr>
  <th width="100px">Nom</th> <th width="100px">Prénom</th> <th width="100px">Nationalité</th> <th width="100px">Type de formation</th> <th width="300px">Formateur - Salle - Date début - Date fin</th><th width="50px">Suppression</th>
</tr>  
	<?php
	$requete = "SELECT *,nationalite.Libelle as Lib_nationalite,type_formation.Libelle as Lib_type_formation, stagiaire.Id as Id_stagiaire FROM (stagiaire".
				" INNER JOIN nationalite on stagiaire.Id_nationalite = nationalite.Id_nationalite)".
				" INNER JOIN type_formation on stagiaire.Id_type_formation = type_formation.Id_type_formation".
				" order by Nom";

	if ($resultat = mysqli_query($connect,$requete)) {
		date_default_timezone_set('Europe/Paris');
		/* fetch le tableau associatif */
		while ($ligne = mysqli_fetch_assoc($resultat)) {
			echo "<tr>";
			echo "<td>".$ligne['Nom']."</td>";
			echo "<td>".$ligne['Prenom']."</td>";
			echo "<td>".$ligne['Lib_nationalite']."</td>";
			echo "<td>".$ligne['Lib_type_formation']."</td>";
			echo "<td>";
			$requete_formateur = "SELECT * FROM stagiaire_formateur INNER JOIN formateur on stagiaire_formateur.Id_formateur = formateur.Id_formateur INNER JOIN salle on formateur.Id_salle = salle.Id_salle where stagiaire_formateur.Id_stagiaire = ".$ligne['Id'];
			//echo $requete_formateur;
			if ($resultat_formateur = mysqli_query($connect,$requete_formateur)) {
				/* fetch le tableau associatif */
				while ($ligne_formateur = mysqli_fetch_assoc($resultat_formateur)) {
					$dt_debut = date_create_from_format('Y-m-d', $ligne_formateur['Date_debut']);
					echo $ligne_formateur['Nom']." - ".$ligne_formateur['Libelle']." - ".$dt_debut->format('d/m/Y')." - ".$ligne_formateur['Date_fin']."<br />";
				}
			}
			echo "&nbsp;</td>";
			echo "<td><input type='checkbox' name='suppression[]' value='".$ligne['Id_stagiaire']."' /></td>";
			echo "</tr>";
		}	
	}

	/* Fermeture de la connexion */
	mysqli_close($connect);

	?>
</table>
<br />
<input type="submit" name="supprimer" value="supprimer" />
</form>
<br />
<a href="formation.php">Ajout d'un stagiaire</a> <a href="liste_stagiaire_a_modifier.php">Modification d'un stagiaire</a>

</body>
</html>