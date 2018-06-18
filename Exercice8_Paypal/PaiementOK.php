<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

include("paypal_api.php");

$requete = construit_url_paypal(); // Construit les options de base

// On ajoute le reste des options
// La fonction urlencode permet d'encoder au format URL les espaces, slash, deux points, etc.)
$requete = $requete."&METHOD=DoExpressCheckoutPayment".
			"&TOKEN=".htmlentities($_GET['token'], ENT_QUOTES). // Ajoute le jeton qui nous a été renvoyé
			"&AMT=".$_SESSION['Prix_total']. 
			"&CURRENCYCODE=EUR".
			"&PayerID=".htmlentities($_GET['PayerID'], ENT_QUOTES). // Ajoute l'identifiant du paiement qui nous a également été renvoyé
			"&PAYMENTACTION=sale";

// Initialise notre session cURL. On lui donne la requête à exécuter.
$ch = curl_init($requete);

// Modifie l'option CURLOPT_SSL_VERIFYPEER afin d'ignorer la vérification du certificat SSL. Si cette option est à 1, une erreur affichera que la vérification du certificat SSL a échoué, et rien ne sera retourné. 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// Retourne directement le transfert sous forme de chaîne de la valeur retournée par curl_exec() au lieu de l'afficher directement. 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// On lance l'exécution de la requête URL et on récupère le résultat dans une variable
$resultat_paypal = curl_exec($ch);

$html_sortie="";

if (!$resultat_paypal)
    // S'il y a une erreur, on affiche "Erreur", suivi du détail de l'erreur.
    {
        $html_sortie="<p>Erreur</p><p>".curl_error($ch)."</p>";
    }
    // S'il s'est exécuté correctement, on effectue les traitements...
    else
    {
	$liste_param_paypal = recup_param_paypal($resultat_paypal); // Lance notre fonction qui dispatche le résultat obtenu en un array
	                   
	
	// Si la requête a été traitée avec succès
	if ($liste_param_paypal['ACK'] == 'Success')
	{           
        $emailmembre ="contact@contact.com";
        // On affiche la page avec les remerciements, et tout le tralala...  
		$html_sortie.= '<h1 style="position: relative;margin:auto;margin: 50px auto 20px auto;">Paiement accepté <span style="opacity:0.2;">Paypal</span></h1><br/>';
		$html_sortie.= '<br/><div style="font-size:18px;color:#02363B;text-align:center;margin:auto;width:100%;">Transaction n° '.$liste_param_paypal['TRANSACTIONID'].'</div>';	
        $html_sortie.= "<div id='blocretour'>"; 
        $html_sortie.= "<h2>Votre paiement a bien été effectué</h2>"; 
        $html_sortie.= "<hr /><br/> "; 
        $html_sortie.= "<h3 style='margin-top:10px;font-weight:100;'>Un e-mail de confirmation va vous être envoyé à :<br /><br /><span style='font-size:25px;'>".$emailmembre."<span> </h3> "; 
        $html_sortie.= "<br />"; 
        $html_sortie.="<p>Merci d'avoir acheté sur notre site. A très bientôt !</p>";
        $html_sortie.="<p id='rig'><i>VotreSite.com</i><p>";
        $html_sortie.= "</div>"; 
        $html_sortie.= "<div id='btnretour'>"; 
        $html_sortie.= "<a href='index.php' class='btn-lien mt05 mb05'>Retour au site</a> ";               
        $html_sortie.= "</div>";
	
		//--------- MAJ en BDD -
		//--------- envoi du mail de confirmation - END----------
			
	}
	else // En cas d'échec, affiche la première erreur trouvée.
	{                 
        $html_sortie="<p>Erreur de communication avec le serveur PayPal.<br />".$liste_param_paypal['L_SHORTMESSAGE0']."<br />".$liste_param_paypal['L_LONGMESSAGE0']."</p>";
    }
}

// On ferme notre session cURL.
curl_close($ch);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//FR" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Paiement OK</title>
    <link href="css/commun.css" rel="stylesheet" type="text/css">
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <link href="css/sprite.css" rel="stylesheet" type="text/css">
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
        <?php
        echo $html_sortie;
        ?>        
      </div>
    </div>
    </body>
</html>



       

