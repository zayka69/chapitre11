
<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//FR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

   <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>paiement annulé</title>
    <link href="css/commun.css" rel="stylesheet" type="text/css">
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <link href="css/sprite.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:500,700' rel='stylesheet' type='text/css'>
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery.alerts.js" type="text/javascript"></script>
	<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
	
    </head>
      <body>
    <header>
      <div class="container">
        <a href="index.php">Retour</a>
        <nav role="navigation">
 
        </nav>
        <div class="clear"></div>
      </div>
      <div class="bande-grise">
        <div class="container">
          <div class="small-search-box">
           
          </div>
          <div class="clear"></div>
        </div>
      </div>
    </header>
    <div class="min600">
      <div class="container cont-w pa2 mt110 mb4">
      	<h1>Paiement annulé</h1>
		<br />
		<p>
		Votre paiement a été annulé. En espérant que vous changerez d'avis, nous vous adressons nos salutations les plus sincères.
		</p>
		<br />
<?php
  
   function construit_url_paypal()
  {
  //Aller sur préférence dans paypal, accès API et activer l'achat express !!!  
	$api_paypal = 'https://api-3t.sandbox.paypal.com/nvp?'; 
	//EN PRODUCTION
	//$api_paypal = 'https://api-3t.paypal.com/nvp?'; 
	$version = 117.0; // Version de l'API

	$user = 'rollet.olivier-facilitator_api1.free.fr'; // Utilisateur API 
	//EN PRODUCTION	
	//$user = 'xxx.zzz.net';
	$pass = '5P6KG48JL4W4URTJ';	   // Mot de passe API 
	//EN PRODUCTION
	//$pass = 'C46NAFRGTBZWK9MA';
	$signature ='A4gHhAFXYYyo.4aD99k4nXlzgfK.AppvlBrsfXXKgtp7pZgLKBSLLZFG'; // Signature de l'API 
	//EN PRODUCTION
	//$signature ='AFcWxV21C7fd0v3bYZZCpSSRl352eUk9C3m5BvAL6dhC-yspdMxDzwR';

	$api_paypal = $api_paypal.'VERSION='.$version.'&USER='.$user.'&PWD='.$pass.'&SIGNATURE='.$signature; // Ajoute tous les paramètres

	return 	$api_paypal; // Renvoie la chaîne contenant tous nos paramètres.
  }

  function recup_param_paypal($resultat_paypal)
  {
	$liste_parametres = explode("&",$resultat_paypal); // Crée un tableau de paramètres
	foreach($liste_parametres as $param_paypal) // Pour chaque paramètre
	{
		list($nom, $valeur) = explode("=", $param_paypal); // Sépare le nom et la valeur
		$liste_param_paypal[$nom]=urldecode($valeur); // Crée l'array final
	}
	return $liste_param_paypal; // Retourne l'array
  }
  
$requete = construit_url_paypal();
$requete = $requete."&METHOD=GetExpressCheckoutDetails"."&TOKEN=".htmlentities($_GET['token'], ENT_QUOTES); // Ajoute le jeton

$ch = curl_init($requete);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$resultat_paypal = curl_exec($ch);

if (!$resultat_paypal) // S'il y a une erreur
	{echo "<p>Erreur</p><p>".curl_error($ch)."</p>";}
// S'il s'est exécuté correctement
else
{
	$liste_param_paypal = recup_param_paypal($resultat_paypal);	
	// On affiche tous les paramètres afin d'avoir un aperçu global des valeurs exploitables (pour vos traitements). Une fois que votre page sera comme vous le voulez, supprimez ces 3 lignes. Les visiteurs n'auront aucune raison de voir ces valeurs s'afficher.
	//echo "<pre>";
	//print_r($liste_param_paypal);
	//echo "</pre>";
	
	// Si la requête a été traitée avec succès
	
	// Mise à jour de la base de données & traitements divers... Exemple :
	//mysqli_query($connexion,"INSERT INTO client(nom, prenom) VALUE('".$liste_param_paypal['FIRSTNAME']."', '".$liste_param_paypal['LASTNAME']."')");
}
curl_close($ch);
?>
		<a class="btn-lien mt05 mb05" href="index.php">Retour paiement</a>
      </div>
    </div>



	</body>
</html>
