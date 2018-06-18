<?php
session_start();
include('User.class.php');
include('Manager.class.php');
try
{
    // Connexion à la base de données
	include('connexion.php');
    $manager = new Manager($base);
	//création d'un objet Blog avec les valeurs de ses attributs complétées par celles reçues par $_POST
	$user = new User();
	$user->setLogin(htmlentities(addslashes($_POST['login'])));
	$user->setPassword(htmlentities(addslashes($_POST['password'])));
	$identifiant = $manager->verifUser($user);	
	
    if ($identifiant != 0) {
		$_SESSION['Id'] = $identifiant;
		//echo $_SESSION['Id'];
		header("location:affichage_blog.php");
	}
	else {
		header("location:login.php?message=1");
	}
 
}
catch(Exception $e)
{
    // message en cas d'erreur
    die('Erreur : '.$e->getMessage());
}

?>
