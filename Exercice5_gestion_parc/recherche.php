<?php // Dispatcher secondaire 
require('common.php'); 
extract($_POST); // Importe les variables dans la table des symboles. Permet de mettre le contenu de $_POST['addip'] dans la variable $addip
if (isset($addip)) {
	$controller->recherche($addip); // action du controleur
}
else {
	$controller->recherche(""); // action du controleur
}	
?>