<?php
class Blog 
    {
        // D�claration des attributs 
		private $id;
		private $titre;
		private $date;
		private $commentaire;
		private $photo;
		private $id_user;
		private $login;
		
		
		//accesseurs
		public function getId()
		{
            return $this->id; //retourne l'identifiant 
		}
		public function setId($id)
		{
			$this->id = $id; //�crit dans l'attribut id
		}
		
		public function getTitre()
		{
            return $this->titre; //retourne le titre 
		}
		public function setTitre($titre)
		{
			$this->titre = $titre; //�crit dans l'attribut titre
		}
		
		public function getDate()
		{
            return $this->date; //retourne la date 
		}
		public function setDate($date)
		{
			$this->date = $date; //�crit dans l'attribut date
		}
		
		public function getCommentaire()
		{
            return $this->commentaire; //retourne le commentaire 
		}
		public function setCommentaire($commentaire)
		{
			$this->commentaire = $commentaire; //�crit dans l'attribut commentaire
		}
		
		public function getPhoto()
		{
            return $this->photo; //retourne le nom de la photo 
		}
		public function setPhoto($photo)
		{
			$this->photo = $photo; //�crit dans l'attribut photo
		}
		
		public function getIdUser()
		{
            return $this->id_user; //retourne l'identifiant 
		}
		public function setIdUser($id_user)
		{
			$this->id_user = $id_user; //�crit dans l'attribut id_user
		}
		
		public function getLogin()
		{
            return $this->login; //retourne le login 
		}
		public function setLogin($login)
		{
			$this->login = $login; //�crit dans l'attribut login
		}
		
		
}
?>
