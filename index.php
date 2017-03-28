<?php

$pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
$req = $pdo->query('SELECT id ,Titre,Contenu, date_format(DateCreation,  \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY DateCreation DESC LIMIT 0, 5');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
	<link rel="stylesheet" type="text/css" href="style.css">
    </head>
        
    <body>
        <h1>Mon super blog !</h1>
        <p>Derniers billets du blog :</p>


<?php while ($donnees = $req->fetch()) : ?>

<div class="news">
    <h3>
        <?php echo htmlspecialchars($donnees['Titre']); ?>
        <em>le <?php echo $donnees['date_creation_fr']; ?></em>
    </h3>
    
    <p>
    <?php
    // On affiche le contenu du billet
    echo nl2br(htmlspecialchars($donnees['Contenu']));
    ?>
    <br />
    <em><a href="commentaires.php?billet=<?php echo $donnees['id']; ?>">Commentaires</a></em>
    </p>
</div>
<?php endwhile ?>
</body>
</html>

