<?php
session_start();
include("paypal_api.php");
//$manager = new Manager($connexion);
if (!isset($_SESSION['Id_client'])) {
	header("location:paiement.php");
}
$items="";
$ItemQty=1; //Nombre de produit acheté 
$ItemTotalPrice=0;

$ItemName='Achat';
$ItemNumber=$_SESSION['Id_client'];
$ItemDesc='Achat paypal';
$ItemPrice=$_SESSION['Prix_total'];
$i=0;
$items.="&L_PAYMENTREQUEST_0_NAME".$i."=".urlencode($ItemName);
$items.="&L_PAYMENTREQUEST_0_NUMBER".$i."=".urlencode($ItemNumber);
$items.="&L_PAYMENTREQUEST_0_DESC".$i."=".urlencode($ItemDesc);
$items.="&L_PAYMENTREQUEST_0_AMT".$i."=".urlencode($ItemPrice);
$items.="&L_PAYMENTREQUEST_0_QTY".$i."=". urlencode($ItemQty);
	
$ItemTotalPrice = $_SESSION['Prix_total'];

//Other important variables like tax, shipping cost
$TotalTaxAmount     = 0.0;  //Sum of tax for all items in this order. 
$HandalingCost      = 0.00;  //Handling cost for this order.
$InsuranceCost      = 0.00;  //shipping insurance cost for this order.
$ShippinDiscount    = 0.00; //Shipping discount for this order. Specify this as negative number.
$ShippinCost        = 0.00; //livraison Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.


//Grand total including all tax, insurance, shipping cost and discount
$GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
$PayPalCurrencyCode='EUR';

$requete = construit_url_paypal();

$paiement_cb="";
if (isset($_POST['paiement']) && ($_POST['paiement'] == 2 || $_POST['paiement'] == 3)) {
	$paiement_cb = "&SOLUTIONTYPE=Sole&LANDINGPAGE=Billing";//paiement par CB
}
$url="http://127.0.0.1:8081/chapitre11/Exercice8_Paypal/"; //A changer avec votre site
$requete = $requete."&METHOD=SetExpressCheckout".    //SetExpressCheckout
			"&CANCELURL=".urlencode($url."paypal_cancel.php"). 
			"&RETURNURL=".urlencode($url."PaiementOK.php").
           $items.
            '&NOSHIPPING=0'. 	//set 1 to hide buyer's shipping address, in-case products that do not require shipping                
            '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
            '&PAYMENTREQUEST_0_TAXAMT='.urlencode($TotalTaxAmount).
            '&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($ShippinCost).
            '&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($HandalingCost).
            '&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($ShippinDiscount).
            '&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($InsuranceCost).
            '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
            '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).            
            '&LOCALECODE=FR'. 
            '&LOGOIMG=logo2.gif'. //site logo
            '&CARTBORDERCOLOR=e2e2e2'. //border color of cart
            '&ALLOWNOTE=1'.$paiement_cb;
	
echo '<hr/>'.$requete;

$ch = curl_init($requete);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


$resultat_paypal = curl_exec($ch);

if (!$resultat_paypal)
	{echo "<p>Erreur</p><p>".curl_error($ch)."</p>";}
else
{
	$liste_param_paypal = recup_param_paypal($resultat_paypal); // Lance notre fonction qui dispatche le résultat obtenu en un array

	// Si la requête a été traitée avec succès
	if ($liste_param_paypal['ACK'] == 'Success')
	{
		// Redirige le visiteur sur le site de PayPal
        header("Location: https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=".$liste_param_paypal['TOKEN']); 
		// EN PRODUCTION
		//header("Location: https://www.paypal.com/webscr&cmd=_express-checkout&token=".$liste_param_paypal['TOKEN']); 		
        exit();
	}
	else // En cas d'échec, affiche la première erreur trouvée.
	{echo "<p>Erreur de communication avec le serveur PayPal.<br />".$liste_param_paypal['L_SHORTMESSAGE0']."<br />".$liste_param_paypal['L_LONGMESSAGE0']."</p>";}		
}
curl_close($ch);
