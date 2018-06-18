<?php 
/** * Classe clé RIB * 
* Classe permettant de créer des objets de type RIB_FR stockant 
* des numéro de comptes bancaires français ainsi que 
* les méthodes nécessaires pour contrôler la validité
* d'un RIB français. 
**/
class RIB_FR{ 
 /**   
 * Attributs   
 **/ 
 private $_sCodeBanque;  
 private $_sCodeGuichet;  
 private $_sCleRib;  
 private $_sNumeroCompte;   
 
 /**   
 * Constructeur de la classe   
 *   
 * @param string code unique de la banque   
 * @param string code unique du guichet    
 * @param string numéro du compte bancaire   
 * @param string clé rib   
 * @return void   
 **/  
 public function __construct($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)  {    
	// Contrôle du RIB    
	if(true === (self::verifierRIB($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)))    {     
		// Mise à jour des propriétés de la classe RIB_FR     
		$this->_sCodeBanque = $sCodeBanque;      
		$this->_sCodeGuichet = $sCodeGuichet;      
		$this->_sCleRib = $sCleRib;      
		$this->_sNumeroCompte = $sNumeroCompte;    
	}    
	else    {      
		throw new Exception("Le RIB n'est pas un RIB valide fran-çais.");    
	}  
 } 
 
 /**   
 * Destructeur de la classe  
 *   
 * @param void   
 * @return void   
 **/  
 public function __destruct() { } 
 
 /**  
 * Retourne le code banque   
 *   
 * @param void   
 * @return string code banque  
 **/ 
 public function getCodeBanque()  {   
	return $this->_sCodeBanque;  
 }   
 
 /**   
 * Retourne le code guichet  
 *   
 * @param void   
 * @return string code guichet   
 **/ 
 public function getCodeGuichet()  {   
	return $this->_sCodeGuichet; 
 } 
 
 /**   
 * Retourne la clé rib   
*  
 * @param void  
 * @return string clé rib   
 **/ 
 public function getCleRib()  {    
	return $this->_sCleRib;  
 }  
 
 /**  
 * Retourne le numéro de compte  
 *   
 * @param void   
 * @return string numéro de compte   
 **/ 
 public function getNumeroCompte()  
 {   
	return $this->_sNumeroCompte;  
 }
 
 /**   
 * Affiche le RIB correctement dans le bon format   
 * @param void   
 * @return string numéro de compte RIB complet   
 **/  
 public function __toString()   {    
	return $this->_sCodeBanque .' '. $this->_sCodeGuichet .' '. $this->_sNumeroCompte .' '. $this->_sCleRib;  
 } 
 
 /**   
 * Vérifie que la clé RIB se trouve bien dans l'intervalle 01 - 97   
 *   
 * @param string clé rib   
 * @return boolean true / false   
 **/ 
 public static function verifierCleRib($sCleRib)  {    
	return preg_match('`^(0[1-9]|[1-8]\d|9[0-7])$`', $sCleRib); 
 }
 /**   
 * Calcule une clé RIB à partir des informations bancaires   
 * La fonction implémente l'algorithme de clé RIB   
 * Une clé RIB n'est valable que si elle se trouve dans l'intervalle 01 - 97  
 *   
 * @param string code unique de la banque   
 * @param string code unique du guichet (agence où se trouve le compte)   
 * @param string numéro du compte bancaire (peut contenir des lettres)   
 * @return string clé rib calculée  
 **/ 
 public static function calculerCleRib($sCodeBanque, $sCodeGuichet, $sNumeroCompte)  {    
	 $sCleRib = ''; 
	 $iCleRib = 0;	 
	 // Calcul de la clé RIB   
	 $iCleRib = 97 - (int) fmod (89 * $sCodeBanque  + 15 * $sCodeGuichet + 3  * $sNumeroCompte, 97);     
	 if($iCleRib<10)     {     
		$sCleRib = '0'. (string)$iCleRib;    
	 } 
	 else 
	 {      
		$sCleRib = (string) $iCleRib;    
	 }    
	 return  $sCleRib; 
 } 
 
 /**   
 * Vérifie que le RIB passé en paramètre est un RIB 
 * de compte bancaire français correct   
 *   
 * @param string code unique de la banque   
 * @param string code unique du guichet   
 * @param string numéro du compte bancaire  
 * @param string clé rib  
 * @return boolean true / false  
 **/  
 public static function verifierRIB($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)  {    
	 $bCorrect = false;     
	 // Vérifie la clé RIB   
	 if(self::verifierCleRib($sCleRib))    {      
		 // Calcule la clé RIB pour vérifier si elle correpond avec celle transmise en paramètre     
		 if($sCleRib === self::calculerCleRib($sCodeBanque, $sCodeGuichet, $sNumeroCompte))      {        
			$bCorrect = true;      
		 }    
	 }    
	 return $bCorrect;  
 }  
  
}
?>
