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
	
    function enable_formateur(param) { //Id_stagiaire en paramètre
		//remise à zéro des checkbox
		var i; 
		var obj_input; 
		for (i = 0; i < document.formulaire.elements.length; i++) 
		{ 
			obj_input = document.formulaire.elements[i]; 
			if(obj_input.type=="checkbox" && obj_input.name.substring(0,12)!="modification") // on teste si CheckBox et <> modification
			{ 
				obj_input.disabled=true;
				if (obj_input.id.substring(obj_input.id.indexOf("_")+1) == param) { //décoche les checkbox seulement si on change la sélection du type de formation
					obj_input.checked=false;
				}
			}

			if(obj_input.name.substring(0,5)=="debut" || obj_input.name.substring(0,3)=="fin") // on teste si date début ou date fin 
			{ 
				obj_input.disabled=true;
			} 			
		} 
	
		var tableau_formation = new Array();

		<?php
		$requete_stag = "SELECT *, stagiaire.Id as Id_stagiaire FROM stagiaire".
				" order by Nom";

		if ($resultat_stag = mysqli_query($connect,$requete_stag)) {
	
			while ($ligne_stag = mysqli_fetch_assoc($resultat_stag)) {
		
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
				id_formation=document.formulaire.type_formation<?php echo $ligne_stag['Id_stagiaire'];?>.options[document.formulaire.type_formation<?php echo $ligne_stag['Id_stagiaire'];?>.selectedIndex].value;
				var tableau_formateur = new Array();
				tableau_formateur = tableau_formation[id_formation];
				for(var i= 0; i < tableau_formateur.length; i++)
				{
					document.getElementById("formateur"+tableau_formateur[i]+"_<?php echo $ligne_stag['Id_stagiaire'];?>").disabled=false;
					document.getElementById("debut"+tableau_formateur[i]+"_<?php echo $ligne_stag['Id_stagiaire'];?>").disabled=false;
					document.getElementById("fin"+tableau_formateur[i]+"_<?php echo $ligne_stag['Id_stagiaire'];?>").disabled=false;
				}
		<?php }//fin while
		}//fin si	?>
	}
	</script>
</head>

<body onload="enable_formateur(0)">

<h2>Modification des données du stagiaire</h2><br />
<form name="formulaire" id="formulaire" action="modification_stagiaire.php" method="POST">
<table border="1">
<tr>
  <th width="100px">Nom</th> <th width="100px">Prénom</th> <th width="100px">Nationalité</th> <th width="100px">Type de formation</th> <th width="300px">Formateur - Salle - Date début - Date fin</th><th width="50px">Modification</th>
</tr>  
	<?php
	$requete = "SELECT *, stagiaire.Id as Id_stagiaire FROM stagiaire".
				" order by Nom";

	if ($resultat = mysqli_query($connect,$requete)) {
		date_default_timezone_set('Europe/Paris');
		/* fetch le tableau associatif */
		while ($ligne = mysqli_fetch_assoc($resultat)) {
			echo "<tr>";
			echo "<td><input type='text' name='nom".$ligne['Id_stagiaire']."' value='".$ligne['Nom']."' /></td>";
			echo "<td><input type='text' name='prenom".$ligne['Id_stagiaire']."' value='".$ligne['Prenom']."' /></td>";
			echo "<td>";
			echo '<select name="nationalite'.$ligne['Id_stagiaire'].'">';
			$requete_nat = "SELECT * FROM nationalite";
			if ($resultat_nat = mysqli_query($connect,$requete_nat)) {
				/* fetch le tableau associatif */
				while ($ligne_nat = mysqli_fetch_assoc($resultat_nat)) {
					if ($ligne_nat['Id_nationalite'] == $ligne['Id_nationalite']) {
						echo "<option value='".$ligne_nat['Id_nationalite']."' selected='selected' >".$ligne_nat['Libelle']."</option>";
					}
					else {
						echo "<option value='".$ligne_nat['Id_nationalite']."'>".$ligne_nat['Libelle']."</option>";
					}
				}
				/*libère l'objet resultat */
				mysqli_free_result($resultat_nat);
			}
			echo "</select>";
			echo "</td>";
			echo "<td>";
			echo '<select name="type_formation'.$ligne['Id_stagiaire'].'" onchange="enable_formateur('.$ligne['Id_stagiaire'].')">';
			$requete_form = "SELECT * FROM type_formation";
			if ($resultat_form = mysqli_query($connect,$requete_form)) {
				/* fetch le tableau associatif */
				while ($ligne_form = mysqli_fetch_assoc($resultat_form)) {
					if ($ligne_form['Id_type_formation'] == $ligne['Id_type_formation']) {
						echo "<option value='".$ligne_form['Id_type_formation']."' selected='selected'>".$ligne_form['Libelle']."</option>";
					}
					else {
						echo "<option value='".$ligne_form['Id_type_formation']."'>".$ligne_form['Libelle']."</option>";
					}
				}
				/*libère l'objet resultat */
				mysqli_free_result($resultat_form);
			}
			echo "</select>";
			echo "</td>";
			echo "<td>";
			$requete_tout_formateur = "SELECT * FROM formateur left join salle on formateur.id_salle = salle.id_salle";
			if ($resultat_tout_formateur = mysqli_query($connect,$requete_tout_formateur)) {

				/* fetch le tableau associatif */
				while ($ligne_tout_formateur = mysqli_fetch_assoc($resultat_tout_formateur)) {
					$checked="";
					$dt_debut = date_create_from_format('Y-m-d',strftime("%Y-%m-%d"));
					$dt_fin = date_create_from_format('Y-m-d',strftime("%Y-%m-%d",strtotime('+6 month')));
					$requete_formateur = "SELECT * FROM stagiaire_formateur INNER JOIN formateur on stagiaire_formateur.Id_formateur = formateur.Id_formateur INNER JOIN salle on formateur.Id_salle = salle.Id_salle where stagiaire_formateur.Id_stagiaire = ".$ligne['Id'];
					if ($resultat_formateur = mysqli_query($connect,$requete_formateur)) {
						/* fetch le tableau associatif */
						while ($ligne_formateur = mysqli_fetch_assoc($resultat_formateur)) {
							if ($ligne_formateur['Id_formateur'] == $ligne_tout_formateur['Id_formateur']) {
								$dt_debut = date_create_from_format('Y-m-d', $ligne_formateur['Date_debut']);
								$dt_fin = date_create_from_format('Y-m-d', $ligne_formateur['Date_fin']);
								$checked = "checked='checked'";
							}
						}
					}
					echo "<input type='checkbox' ".$checked." id='formateur".$ligne_tout_formateur['Id_formateur']."_".$ligne['Id_stagiaire']."' name='formateur".$ligne['Id_stagiaire']."[]' value='".$ligne_tout_formateur['Id_formateur']."' />";
					echo $ligne_tout_formateur['Nom']." - ".$ligne_tout_formateur['Libelle']." - <input type='text' size='8' name='debut".$ligne_tout_formateur['Id_formateur']."_".$ligne['Id_stagiaire']."' id='debut".$ligne_tout_formateur['Id_formateur']."_".$ligne['Id_stagiaire']."' value='".$dt_debut->format('d/m/Y')."' onchange='verif_date(this.value)' />";
					echo "<input type='text' size='8' name='fin".$ligne_tout_formateur['Id_formateur']."_".$ligne['Id_stagiaire']."' id='fin".$ligne_tout_formateur['Id_formateur']."_".$ligne['Id_stagiaire']."' value='".$dt_fin->format('d/m/Y')."' onchange='verif_date(this.value)' /><br />";
				}
				/*libère l'objet resultat */
				mysqli_free_result($resultat_tout_formateur);
			}	
			echo "&nbsp;</td>";
			echo "<td><input type='checkbox' name='modification[]' value='".$ligne['Id_stagiaire']."' /></td>";
			echo "</tr>";
		}	
	}

	/* Fermeture de la connexion */
	mysqli_close($connect);

	?>
</table>
<br />
<input type="submit" name="modifier" value="modifier" />
</form>
<br />
<a href="formation.php">Ajout d'un stagiaire</a> <a href="liste_stagiaire_a_supprimer.php">Suppression d'un stagiaire</a>

</body>
</html>