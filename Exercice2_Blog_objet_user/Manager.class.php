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
			$resultat = $this->base->query('SELECT * FROM contenu INNER JOIN user ON contenu.Id_user = user.Id  order by Date');
			//fetch sur chaque ligne ramenée par la requête	
		    while ($ligne = $resultat->fetch()) {
				$blog = new Blog();
			    $blog->setId($ligne['Id']);
			    $blog->setTitre($ligne['Titre']);
			    $blog->setDate($ligne['Date']);
			    $blog->setCommentaire($ligne['Commentaire']);
			    $blog->setPhoto($ligne['Photo']);
				$blog->setLogin($ligne['Login']);
			    $tableau[$compteur] = $blog; //stockage de l'objet dans le tableau
			    $compteur++;
		    }   
			return $tableau;	
		}
		
		public function insertionContenu(Blog $blog) {
			$sql = "INSERT INTO contenu (Titre, Date, Commentaire, Photo, Id_user) VALUES ('".$blog->getTitre()."','".$blog->getDate()."','".$blog->getCommentaire()."','".$blog->getPhoto()."',".$blog->getIdUser().")";
			$this->base->exec($sql);	
			//récupération du dernier identifiant
			$identifiant = $this->base->lastInsertId();
			return $identifiant;	
		}
		
		public function verifUser(User $user) {
			
			$retour = 0;
			$sql = 'SELECT * FROM user WHERE login = :login and password = :password';
			// Préparation de la requête avec les marqueurs
			$resultat = $this->base->prepare($sql);
			$login = $user->getLogin();
			$password = $user->getPassword();
			$resultat->bindValue(':login', $login);
			$resultat->bindValue(':password', $password);
			$resultat->execute();
			$ligne = $resultat->fetch();
			//Si il y a une ligne, c'est que la personne existe en base de données			
			if ($ligne) {
				$retour = $ligne['Id'];
			}
			return $retour;
		}
	
	}
?>