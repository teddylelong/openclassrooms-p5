<h1>Nos articles</h1>

<?php foreach ($articles as $article) : ?>
    <h2><?= $article->title ?></h2>
    <small>Écrit le <?= $article->created_at ?></small>
    <p><?= $article->excerpt ?></p>
    <a href="/article/show/<?= $article->pk_id ?>/">Lire la suite</a>
<?php endforeach ?>