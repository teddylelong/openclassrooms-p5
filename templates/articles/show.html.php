<h1><?= $article['title'] ?></h1>

<small>Ecrit le <?= $article['created_at'] ?></small>

<p><?= $article['excerpt'] ?></p>

<hr>

<?= $article['content']; ?>

<?php if (count($commentaires) === 0) : ?>
    <h2>Il n'y a pas encore de commentaires pour cet article... Soyez le premier !</h2>

<?php else : ?>
    <h2>Il y a déjà <?= count($commentaires) ?> réactions : </h2>

    <?php foreach ($commentaires as $commentaire) : ?>
        <h3>Commentaire de <?= $commentaire['author'] ?></h3>
        <small>Le <?= $commentaire['created_at'] ?></small>
        <blockquote>
            <em><?= $commentaire['content'] ?></em>
        </blockquote>
    <?php endforeach ?>

<?php endif ?>

<form action="/comment/insert/" method="POST">
    <h3>Déposez votre commentaire ci-dessous</h3>
    <input type="text" name="author" placeholder="Votre pseudo !">
    <input type="email" name="email" placeholder="Votre email !">
    <textarea name="content" id="" cols="30" rows="10" placeholder="Votre commentaire ..."></textarea>
    <input type="hidden" name="article_id" value="<?= $article_id ?>">
    <button>Commenter !</button>
</form>