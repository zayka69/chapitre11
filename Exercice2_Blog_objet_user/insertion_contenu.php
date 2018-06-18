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
		// Connexion � la base de donn�es
		include('connexion.php');
																					
		if ($_FILES['photo']['error']) {    
			  switch ($_FILES['photo']['error']){    
				   case 1: // UPLOAD_ERR_INI_SIZE    
					   echo "La taille du fichier est plus grande que la limite autoris�e par le serveur (param�tre upload_max_filesize du fichier php.ini).";    
					   break;    
				   case 2: // UPLOAD_ERR_FORM_SIZE    
					   echo "La taille du fichier est plus grande que la limite autoris�e par le formulaire (param�tre post_max_size du fichier php.ini).";
					   break;    
				   case 3: // UPLOAD_ERR_PARTIAL    
					   echo "L'envoi du fichier a �t� interrompu pendant le transfert.";    
					   break;    
				   case 4: // UPLOAD_ERR_NO_FILE    
					   echo "La taille du fichier que vous avez envoy� est nulle.";
					   break;    
			  }    
		}    
		else {    
		 //si il n'ya pas d'erreur alors $_FILES['nom_du_fichier']['error'] vaut 0    
			echo "Aucune erreur dans l'upload du fichier.<br />";
			if ((isset($_FILES['photo']['name'])&&($_FILES['photo']['error'] == UPLOAD_ERR_OK))) {    
				$chemin_destination = 'photos/';  
				//d�placement du fichier du r�pertoire temporaire (stock� par d�faut) dans le r�pertoire de destination	
				move_uploaded_file($_FILES['photo']['tmp_name'], $chemin_destination.$_FILES['photo']['name']);    
				echo "Le fichier ".$_FILES['photo']['name']." a �t� copier dans le r�pertoire photos";
			} 
			else {
				echo "Le fichier n'a pas pu �tre copier dans le r�pertoire photos.";
			}
		}

		$manager = new Manager($base);
		//cr�ation d'un objet Blog avec les valeurs de ses attributs compl�t�es par celles re�ues par $_POST
		$blog = new Blog();
		$blog->setTitre(htmlentities(addslashes($_POST['titre'])));
		$blog->setDate(date("Y-m-d H:i:s"));
		$blog->setCommentaire(htmlentities(addslashes($_POST['commentaire'])));
		$blog->setPhoto($_FILES['photo']['name']);
		$blog->setIdUser($_SESSION['Id']);
		$identifiant = $manager->insertionContenu($blog);

		if ($identifiant != 0) {
			echo "<br />Ajout du commentaire r�ussi.<br /><br />";
		}
		else {
			echo "<br />Le commentaire n'a pas pu �tre ajout�.<br /><br />";
		}
		
	}	
	catch(Exception $e)
	{
		// message en cas d'erreur
		die('Erreur : '.$e->getMessage());
	}
?>
<a href="formulaire_ajout.php" >retour � la page d'insertion</a>
 </body>
</html>