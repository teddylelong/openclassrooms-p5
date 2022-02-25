<h1>Gérer les articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article->getTitle() ?></h2>
    <small>Écrit le <?= $article->getCreatedAt() ?></small>
    <p><?= $article->getExcerpt() ?></p>
    <a href="/article/showadmin/<?= $article->getId() ?>/">Consulter</a>
    <a href="/article/modify/<?= $article->getId() ?>/">Modifier</a>
    <a href="/article/delete/<?= $article->getId() ?>/" onclick="return window.confirm('Êtes-vous sur de vouloir supprimer cet article ?')">Supprimer</a>
<?php endforeach ?>

<p><a href="/adminpanel/dashboard/">Retour au dashboard</a></p>
