<?php
$pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
// Récupération du billet
$req = $pdo->prepare('SELECT id, Titre, Contenu, DATE_FORMAT(DateCreation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');
$req->execute(array($_GET['billet']));
$donnees = $req->fetch();

// Récupération des commentaires
$req2 = $pdo->prepare('SELECT Auteur, Commentaire, DATE_FORMAT(DateCommentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE idbillets = ? ORDER BY DateCommentaire');
$req2->execute(array($_GET['billet']));



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
        <p><a href="index.php">Retour à la liste des billets</a></p>

<div class="news">
    <h3>
        <?php echo htmlspecialchars($donnees['Titre']); ?>
        <em>le <?php echo $donnees['date_creation_fr']; ?></em>
    </h3>
    
    <p>
    <?php
    echo nl2br(htmlspecialchars($donnees['Contenu']));
    ?>
    </p>
</div>

<h2>Commentaires</h2>

<?php while ($donnees = $req2->fetch()) : ?>
	<p><strong><?php echo htmlspecialchars($donnees['Auteur']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>
	<p><?php echo nl2br(htmlspecialchars($donnees['Commentaire'])); ?></p>
<?php endwhile ?>

</body>
</html>

