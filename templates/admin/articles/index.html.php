<h1>Gérer les articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article['title'] ?></h2>
    <small>Écrit le <?= $article['created_at'] ?></small>
    <p><?= $article['excerpt'] ?></p>
    <a href="/article/showadmin/<?= $article['pk_id'] ?>/">Consulter</a>
    <a href="/article/modify/<?= $article['pk_id'] ?>/">Modifier</a>
    <a href="/article/delete/<?= $article['pk_id'] ?>/" onclick="return window.confirm('Êtes-vous sur de vouloir supprimer cet article ?')">Supprimer</a>
<?php endforeach ?>

<p><a href="/adminpanel/dashboard/">Retour au dashboard</a></p>
