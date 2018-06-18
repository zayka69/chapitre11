<?php session_start(); 
	 //On image que la personne s'est déjà connectée et donc qu'on a son identifiant et son nom en session.
	 $_SESSION['Nom'] = "demo";
	 $_SESSION['Id_client'] = 1;	
	 $_SESSION['Prix_total'] = 30;
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>paypal</title>
	<link href="css/commun.css" rel="stylesheet" type="text/css">
    <link href="css/default.css" rel="stylesheet" type="text/css">
    <link href="css/sprite.css" rel="stylesheet" type="text/css">
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery.alerts.js" type="text/javascript"></script>
	<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript">
	function envoi() {
		var ok=0;
		var boutons = document.getElementsByName("conditions[]");
		var nbpass = 0;	 
		for (var i = 0; i< boutons.length; i++)
		{
			if (boutons[i].checked)
			{
				nbpass ++;
			}
		}	
		
		if (nbpass == 0) {
			ok=1;
			jAlert('Vous devez cocher "J\'accepte les conditions générales d\'utilisation".', 'Message');
		}

		var boutons = document.getElementsByName("paiement");
		var nbpass2 = 0;	 
		for (var i = 0; i< boutons.length; i++)
		{
			if (boutons[i].checked)
			{
				nbpass2 ++;
			}
		}
		if (nbpass2 == 0) {
			ok=1;
			jAlert('Vous devez cocher un moyen de paiement.', 'Message');
		}		
		
		if (ok==1) {
			return false;
		}
		else {
			return true;
		}	
	}
	</script>
  </head>
  <body>
    <header>
      
      <div class="bande-grise">
        <div class="container">
          <nav class="pull-left nav-connected">
            <ul>
              <li>
			  Nom client : <?php 
			  if (isset($_SESSION['Nom'])) { 
				echo $_SESSION['Nom'];				
			  } 
			  ?></li>              
            </ul>
          </nav>

          <div class="clear"></div>
		  <br />
		  <h3>Nous sommes dans le cadre où le cient s'est déjà connecté et a déjà mis dans son panier tous ses achats.</h3>
        </div>
      </div>
    </header>

    <div class="min600">
      <div class="container-fil-ariane mt2 mb3">
        <div class="fil-ariane">
          <div class="step pull-left ml6 mt2 mr300"><span class="sprite sprite-etape-01 mb1"></span>Achat produit</div> 
          <div class="step pull-left mt2 mr300"><span class="sprite sprite-etape-02 mb1"></span>Facturation</div> 
          <div class="step pull-left mt2"><span class="sprite sprite-etape-03-over mb1"></span>Paiement</div> 
          <div class="clear"></div>
        </div>
      </div>
      <div class="container">
      <div class="cont-w pa1 w750 mb4 pull-left">
        <h1 class="txt-19">Sélection de votre moyen de paiement</h1>

          <div class="pull-left">
		 
			<form name="achat" id="achat" onsubmit="return envoi();" method="post" action="paypal_main.php">
				<div class="bloc-cadre pa2 pull-left mr28">
								
					<input type="radio" name="paiement" value="1" checked="checked" ><span class="sprite sprite-logo-paypal"></span>
				</div>

				<div class="bloc-cadre pa2 pull-left mr28 txt-right">
				  <input type="radio" name="paiement" value="2" ><span class="sprite sprite-picto-visa mb05"></span><br/> Visa
				</div>

				<div class="bloc-cadre pa2 pull-left mr28 txt-right">
				  <input type="radio" name="paiement" value="3" ><span class="sprite sprite-picto-mastercard mb05"></span><br/> Mastercard
				</div>
				

				<div class="clear"></div>
				 <div class="mt4"></div>
				 <input class="btn-green pull-right w350 mb2" value="Je continue" type="submit">
				<span class="green txt-13">
				<input type="checkbox" name="conditions[]">J'accepte les conditions générales d'utilisation &nbsp; &nbsp;</span><br/>            
			</form>
          </div>
        </div>


          <div class="pull-right w300 ">
           <div class=" pa2 radius3 bloc-cadre mb2 cont-w">
            <h2 class="txt-17">Détail de votre panier</h2>
              <div class="split"></div>
              <div class="pull-left">
                  <p>Total</p>
                  <p>Prix HT</p>
              </div>

              <div class="pull-right green txt-right">
			  <?php				
				echo "<p><strong>".$_SESSION['Prix_total']." € TTC</strong></p>";
				$pht = $_SESSION['Prix_total']*0.8;
				echo "<p><strong>".$pht." € HT</strong></p>";				
				?>
              </div>
              <div class="clear"></div>
     
          </div>
    
        </div>
      </div>
               
	<div class="clear"></div>   
  
  </body>
</html>