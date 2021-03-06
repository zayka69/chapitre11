<?php 
/** * Classe cl� RIB * 
* Classe permettant de cr�er des objets de type RIB_FR stockant 
* des num�ro de comptes bancaires fran�ais ainsi que 
* les m�thodes n�cessaires pour contr�ler la validit�
* d'un RIB fran�ais. 
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
 * @param string num�ro du compte bancaire   
 * @param string cl� rib   
 * @return void   
 **/  
 public function __construct($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)  {    
	// Contr�le du RIB    
	if(true === (self::verifierRIB($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)))    {     
		// Mise � jour des propri�t�s de la classe RIB_FR     
		$this->_sCodeBanque = $sCodeBanque;      
		$this->_sCodeGuichet = $sCodeGuichet;      
		$this->_sCleRib = $sCleRib;      
		$this->_sNumeroCompte = $sNumeroCompte;    
	}    
	else    {      
		throw new Exception("Le RIB n'est pas un RIB valide fran-�ais.");    
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
 * Retourne la cl� rib   
*  
 * @param void  
 * @return string cl� rib   
 **/ 
 public function getCleRib()  {    
	return $this->_sCleRib;  
 }  
 
 /**  
 * Retourne le num�ro de compte  
 *   
 * @param void   
 * @return string num�ro de compte   
 **/ 
 public function getNumeroCompte()  
 {   
	return $this->_sNumeroCompte;  
 }
 
 /**   
 * Affiche le RIB correctement dans le bon format   
 * @param void   
 * @return string num�ro de compte RIB complet   
 **/  
 public function __toString()   {    
	return $this->_sCodeBanque .' '. $this->_sCodeGuichet .' '. $this->_sNumeroCompte .' '. $this->_sCleRib;  
 } 
 
 /**   
 * V�rifie que la cl� RIB se trouve bien dans l'intervalle 01 - 97   
 *   
 * @param string cl� rib   
 * @return boolean true / false   
 **/ 
 public static function verifierCleRib($sCleRib)  {    
	return preg_match('`^(0[1-9]|[1-8]\d|9[0-7])$`', $sCleRib); 
 }
 /**   
 * Calcule une cl� RIB � partir des informations bancaires   
 * La fonction impl�mente l'algorithme de cl� RIB   
 * Une cl� RIB n'est valable que si elle se trouve dans l'intervalle 01 - 97  
 *   
 * @param string code unique de la banque   
 * @param string code unique du guichet (agence o� se trouve le compte)   
 * @param string num�ro du compte bancaire (peut contenir des lettres)   
 * @return string cl� rib calcul�e  
 **/ 
 public static function calculerCleRib($sCodeBanque, $sCodeGuichet, $sNumeroCompte)  {    
	 $sCleRib = ''; 
	 $iCleRib = 0;	 
	 // Calcul de la cl� RIB   
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
 * V�rifie que le RIB pass� en param�tre est un RIB 
 * de compte bancaire fran�ais correct   
 *   
 * @param string code unique de la banque   
 * @param string code unique du guichet   
 * @param string num�ro du compte bancaire  
 * @param string cl� rib  
 * @return boolean true / false  
 **/  
 public static function verifierRIB($sCodeBanque, $sCodeGuichet, $sNumeroCompte, $sCleRib)  {    
	 $bCorrect = false;     
	 // V�rifie la cl� RIB   
	 if(self::verifierCleRib($sCleRib))    {      
		 // Calcule la cl� RIB pour v�rifier si elle correpond avec celle transmise en param�tre     
		 if($sCleRib === self::calculerCleRib($sCodeBanque, $sCodeGuichet, $sNumeroCompte))      {        
			$bCorrect = true;      
		 }    
	 }    
	 return $bCorrect;  
 }  
  
}
?>
