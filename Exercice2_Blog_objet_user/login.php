<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Exercice login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    </head>
<body>
<h2>Veuillez saisir votre login et votre mot de passe</h2>
<form action="verif_login.php" method="POST">
login:<input type="text" name="login" /><br /><br />
mot de passe:<input type="text" name="password" /><br /><br />
<input type="submit" name="envoyer" value="valider"/>
<br /><br />
<?php
if (isset($_GET['message']) && $_GET['message'] == '1') {
	echo "<span style='color:#ff0000'>login incorrect</span>";
}
?>
<br />
</form>
</body>
</html>
