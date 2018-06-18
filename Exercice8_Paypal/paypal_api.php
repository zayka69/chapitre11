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

  ?>