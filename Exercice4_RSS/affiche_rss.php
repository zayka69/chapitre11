<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <title>Exercice avec RSS</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="alternate" type="application/rss+xml" href="http://www.lemonde.fr/rss/une.xml" /> 
    </head>
<body>
<?php 
$rss = simplexml_load_file('http://www.lemonde.fr/rss/une.xml'); 
foreach ($rss->channel->item as $item) { 
  echo '<div>
           <h2>'.$item->title.'</h2>
           <h4>post&eacute; le: '.date("d/m/Y",strtotime($item->pubDate)).'</h4>
           '.$item->description.' <a href="'.$item->link.'">Lire tout l\'article</a>
        </div><br />';
} 
?> 

</body>
</html>
