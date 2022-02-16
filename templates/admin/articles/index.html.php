<h1>Gérer les articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article['title'] ?></h2>
    <small>Écrit le <?= $article['created_at'] ?></small>
    <p><?= $article['excerpt'] ?></p>
    <a href="/?controller=article&task=showadmin&id=<?= $article['pk_id'] ?>">Lire la suite</a>
    <a href="/?controller=article&task=modify&id=<?= $article['pk_id'] ?>">Modifier</a>
    <a href="/?controller=article&task=delete&id=<?= $article['pk_id'] ?>" onclick="return window.confirm('Êtes-vous sur de vouloir supprimer cet article ?')">Supprimer</a>
<?php endforeach ?>