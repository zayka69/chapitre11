<style type="text/css">
h1 {
text-align:   center;
}

ul li
{
    color:#6150A1;
}
</style>
<h1>Exemple de g�n�ration d'un RIB en pdf</h1><br><br>
<ul>
<?php   
//class RIB
require('rib.inc');  
 try  {    
	 // Cr�ation du RIB    
	 $oRibFr = new RIB_FR('10096', '18250', '00012345678', '39');    
	 // Affichage des informations    
	 echo '<li>Code banque : '.$oRibFr->getCodeBanque().'</li>';   
	 echo '<li>Code guichet : '.$oRibFr->getCodeGuichet().'</li>';    
	 echo '<li>Num�ro de compte : '.$oRibFr->getNumeroCompte().'</li>';   
	 echo '<li>Cl� RIB : '.$oRibFr->getCleRib().'</li>';     
	 // Affichage du RIB par la m�thode __toString()   
	 echo '<li>Mon RIB est le '.$oRibFr.'</li>';
 } 
 catch(Exception $e)  {    
	echo $e->getMessage();  
 }
 ?>
</ul>
