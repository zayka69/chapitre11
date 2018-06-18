<?php
class Manager 
    {
	    private $base; // Instance de PDO
        
        public function __construct($base)
        {
            $this->setDb($base);
        }
		
		public function setDb(PDO $base)
        {
            $this->base = $base;
        }

		public function getContenuParDate() {
			$tableau = array();
			$compteur = 0;
			$resultat = $this->base->query('SELECT * FROM contenu order by Date');
			//fetch sur chaque ligne ramenée par la requête	
		    while ($ligne = $resultat->fetch()) {
				$blog = new Blog();
			    $blog->setId($ligne['Id']);
			    $blog->setTitre($ligne['Titre']);
			    $blog->setDate($ligne['Date']);
			    $blog->setCommentaire($ligne['Commentaire']);
			    $blog->setPhoto($ligne['Photo']);
			    $tableau[$compteur] = $blog; //stockage de l'objet dans le tableau
			    $compteur++;
		    }   
			return $tableau;	
		}
		
		public function insertionContenu(Blog $blog) {
			$sql = "INSERT INTO contenu (Titre, Date, Commentaire, Photo) VALUES ('".$blog->getTitre()."','".$blog->getDate()."','".$blog->getCommentaire()."','".$blog->getPhoto()."')";
			$this->base->exec($sql);	
			//récupération du dernier identifiant
			$identifiant = $this->base->lastInsertId();
			return $identifiant;	
		}
	
	}
?>