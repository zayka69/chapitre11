<?php
session_start();
if (!isset($_SESSION['Id'])) {
	header("location:login.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Blog</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
<body>
	<h2>Formulaire d'ajout de contenu au Blog</h2>
	<form action="insertion_contenu.php" method="POST"  enctype="multipart/form-data">
		<p>Titre: <input type="text" name="titre" /></p>
		<p>Commentaire: <br /><textarea name="commentaire" rows="10" cols="50"></textarea></p>
		<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
		<p>Choisissez une photo ave une taille inférieure à 2 M0.</p>
		<input type="file" name="photo">
		<br /><br />
		<input type="submit" name="ok" value="Envoyer">
	</form>
	<br />
	<a href="affichage_blog.php" >page d'affichage du blog</a>
 </body>
</html>
