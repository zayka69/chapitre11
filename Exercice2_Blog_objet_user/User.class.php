<?php
class User 
    {
        // Déclaration des attributs 
		private $id;
		private $login;
		private $password;

		
		//accesseurs
		public function getId()
		{
            return $this->id; //retourne l'identifiant 
		}
		public function setId($id)
		{
			$this->id = $id; //écrit dans l'attribut id
		}
		
		public function getLogin()
		{
            return $this->login; //retourne le login 
		}
		public function setLogin($login)
		{
			$this->login = $login; //écrit dans l'attribut login
		}
		
		public function getPassword()
		{
            return $this->password; //retourne le password 
		}
		public function setPassword($password)
		{
			$this->password = $password; //écrit dans l'attribut password
		}
				
}
?>
