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
<?php
include('Blog.class.php');
include('Manager.class.php');
try
	{
		// Connexion à la base de données
		include('connexion.php');
																					
		if ($_FILES['photo']['error']) {    
			  switch ($_FILES['photo']['error']){    
				   case 1: // UPLOAD_ERR_INI_SIZE    
					   echo "La taille du fichier est plus grande que la limite autorisée par le serveur (paramètre upload_max_filesize du fichier php.ini).";    
					   break;    
				   case 2: // UPLOAD_ERR_FORM_SIZE    
					   echo "La taille du fichier est plus grande que la limite autorisée par le formulaire (paramètre post_max_size du fichier php.ini).";
					   break;    
				   case 3: // UPLOAD_ERR_PARTIAL    
					   echo "L'envoi du fichier a été interrompu pendant le transfert.";    
					   break;    
				   case 4: // UPLOAD_ERR_NO_FILE    
					   echo "La taille du fichier que vous avez envoyé est nulle.";
					   break;    
			  }    
		}    
		else {    
		 //si il n'ya pas d'erreur alors $_FILES['nom_du_fichier']['error'] vaut 0    
			echo "Aucune erreur dans l'upload du fichier.<br />";
			if ((isset($_FILES['photo']['name'])&&($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {    
				$chemin_destination = 'photos/';  
				//déplacement du fichier du répertoire temporaire (stocké par défaut) dans le répertoire de destination	
				move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_destination.$_FILES['photo']['name']);    
				echo "Le fichier ".$_FILES['photo']['name']." a été copier dans le répertoire photos";
			} 
			else {
				echo "Le fichier n'a pas pu être copier dans le répertoire photos.";
			}
		}

		$manager = new Manager($base);
		//création d'un objet Blog avec les valeurs de ses attributs complétées par celles reçues par $_POST
		$blog = new Blog();
		$blog->setTitre(htmlentities(addslashes($_POST['titre'])));
		$blog->setDate(date("Y-m-d H:i:s"));
		$blog->setCommentaire(htmlentities(addslashes($_POST['commentaire'])));
		$blog->setPhoto($_FILES['photo']['name']);
		$blog->setIdUser($_SESSION['Id']);
		$identifiant = $manager->insertionContenu($blog);

		if ($identifiant != 0) {
			echo "<br />Ajout du commentaire réussi.<br /><br />";
		}
		else {
			echo "<br />Le commentaire n'a pas pu être ajouté.<br /><br />";
		}
		
	}	
	catch(Exception $e)
	{
		// message en cas d'erreur
		die('Erreur : '.$e->getMessage());
	}
?>
<a href="formulaire_ajout.php" >retour à la page d'insertion</a>
 </body>
</html>