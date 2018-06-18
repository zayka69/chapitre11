<?php 
class Controller{   	
	var $vars = array();    
	var $layout = 'default';    
	function __construct(){         
		if(isset($_POST)){            
			$this->data = $_POST;  //inutilis� dans cet exemple       
		} 
		if(isset($this->models)){   
			foreach($this->models as $v){ 
				$this->loadModel($v);   //chargement du mod�le, ici parc_model       
			}         
		}
	} 
	
	function set($d){    
		$this->vars = array_merge($this->vars,$d);  //fusionne les tableaux $this->vars et $d  
	}
	
	// inclusion du fichier pass� en param�tre     
	function render($filename){ 
		extract($this->vars);   //Importe les variables dans la table des symboles.     
		ob_start();      //d�marre la temporisation de sortie.  
		require(ROOT.'views/'.get_class($this).'/'.$filename.'.php');        
		$content_for_layout = ob_get_clean();  //Lit le contenu courant du tampon de sortie puis l'efface  
		//Cela permet de r�cup�rer le contenu de la vue et de le stocker dans la variable $content_for_layout
		require(ROOT.'views/layout/'.$this->layout.'.php');  //affichage du layout default.php       
	} 
	
	function loadModel($name){  
		require_once(ROOT.'models/'.strtolower($name).'.php');        
		$this->$name = new $name();    
	} 
} ?>