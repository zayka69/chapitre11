<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<?php
$connect = mysqli_connect("127.0.0.1", "root", "", "formation");

/* Vérification de la connexion */
if (!$connect) {
    echo "Échec de la connexion : ".mysqli_connect_error();
    exit();
}
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
?>
<head>
	<title>Exerice formation</title>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15" />
	<script language="JavaScript"> 
	function verif_date(date_recue) { 
		if (date_recue == '') {
			alert('Date non valide');
			document.formulaire.envoyer.disabled=true;
		}
		else {
			document.formulaire.envoyer.disabled=false;
		}
	}
	
    function enable_formateur() { 
		var tableau_formation = new Array();

		<?php
		$requete = "SELECT * FROM type_formation_formateur order by Id_type_formation";

		if ($resultat = mysqli_query($connect,$requete)) {
			$increment = 0;
			$Id_type_formation = 0;
			/* fetch le tableau associatif */
			while ($ligne = mysqli_fetch_assoc($resultat)) {
				if ($Id_type_formation == $ligne['Id_type_formation']) {
					echo "tableau_formation[".$ligne['Id_type_formation']."][".$increment."]=".$ligne['Id_formateur'].";\n";
				} 
				else {
					$Id_type_formation = $ligne['Id_type_formation'];
					$increment = 0;
					echo "tableau_formation[".$ligne['Id_type_formation']."] = new Array();\n";
					echo "tableau_formation[".$ligne['Id_type_formation']."][".$increment."]=".$ligne['Id_formateur'].";\n";
				}
				$increment = $increment + 1;
			}
			/*libère l'objet resultat */
			mysqli_free_result($resultat);
		}
		?>
		//remise à zéro des checkbox
		var i; 
		var obj_input; 
		for (i = 0; i < document.formulaire.elements.length; i++) 
		{ 
			obj_input = document.formulaire.elements[i]; 
			if(obj_input.type=="checkbox") // on teste si CheckBox 
			{ 
				obj_input.disabled=true;
				obj_input.checked=false;
			}

			if(obj_input.name.substring(0,5)=="debut" || obj_input.name.substring(0,3)=="fin") // on teste si date début ou si date de fin
			{ 
				obj_input.disabled=true;
			} 			
		} 

		id_formation=document.formulaire.type_formation.options[document.formulaire.type_formation.selectedIndex].value;
		var tableau_formateur = new Array();
		tableau_formateur = tableau_formation[id_formation];
		for(var i= 0; i < tableau_formateur.length; i++)
		{
			document.getElementById("formateur"+tableau_formateur[i]).disabled=false;
			document.getElementById("debut"+tableau_formateur[i]).disabled=false;
			document.getElementById("fin"+tableau_formateur[i]).disabled=false;
		}

	}
	</script>
</head>

<body onload="enable_formateur()">

<h2>Insérer un stagiaire en formation</h2><br />
<form name="formulaire" id="formulaire" action="insertion_stagiaire.php" method="POST">
nom: <input type="text" name="nom"><br /><br />
prénom: <input type="text" name="prenom"><br /><br />
nationalité: <select name="nationalite">
<?php
$requete = "SELECT * FROM nationalite";

if ($resultat = mysqli_query($connect,$requete)) {

    /* fetch le tableau associatif */
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        echo "<option value='".$ligne['Id_nationalite']."'>".$ligne['Libelle']."</option>";
    }

    /*libère l'objet resultat */
    mysqli_free_result($resultat);
}
?>
</select><br /><br />
type de la formation: <select name="type_formation" onchange="enable_formateur()">
<?php
$requete = "SELECT * FROM type_formation";

if ($resultat = mysqli_query($connect,$requete)) {

    /* fetch le tableau associatif */
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        echo "<option value='".$ligne['Id_type_formation']."'>".$ligne['Libelle']."</option>";
    }

    /*libère l'objet resultat */
    mysqli_free_result($resultat);
}
?>
</select><br /><br />
formateurs par date:<br />
<?php
$requete = "SELECT * FROM formateur left join salle on formateur.id_salle = salle.id_salle";

if ($resultat = mysqli_query($connect,$requete)) {

    /* fetch le tableau associatif */
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        echo "<input type='checkbox' value='".$ligne['Id_formateur']."' id='formateur".$ligne['Id_formateur']."' name='formateur[]'>".$ligne['Prenom']." ".$ligne['Nom']." dans la salle ".$ligne['Libelle'].",";
		echo " début : <input type='text' name='debut".$ligne['Id_formateur']."' id='debut".$ligne['Id_formateur']."' value='".strftime("%d/%m/%Y")."' onchange='verif_date(this.value)' />,";
		echo " fin: <input type='text' name='fin".$ligne['Id_formateur']."' id='fin".$ligne['Id_formateur']."' value='".date('d/m/Y', strtotime('+6 month'))."' onchange='verif_date(this.value)' /><br /><br />";
    }

    /*libère l'objet resultat */
    mysqli_free_result($resultat);
}
?>
<br />
<input type="submit" name="envoyer" value="Envoyer" />
</form>
<br />
<a href="liste_stagiaire_a_supprimer.php">Suppression d'un stagiaire</a> <a href="liste_stagiaire_a_modifier.php">Modification d'un stagiaire</a>
<?php

/* Fermeture de la connexion */
mysqli_close($connect);

?>
</body>
</html>