<h1>Nos articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article->getTitle() ?></h2>
    <small>Écrit le <?= $article->getCreatedAt() ?></small>
    <p><?= $article->getExcerpt() ?></p>
    <a href="/article/show/<?= $article->getId() ?>/">Lire la suite</a>
<?php endforeach ?>