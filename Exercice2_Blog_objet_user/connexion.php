<?php // Connexion � la base de donn�es
		$base = new PDO('mysql:host=127.0.0.1;dbname=Blog', 'root', '');
		$base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	?>	