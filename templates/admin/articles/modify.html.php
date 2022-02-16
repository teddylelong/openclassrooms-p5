<h1>Modifier l'article <?= $article['title'] ?></h1>

<form action="index.php?controller=article&task=update" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= $article['title'] ?>"/>

    <label for="excerpt">Extrait :</label>
    <textarea name="excerpt" id="excerpt"><?= $article['excerpt'] ?></textarea>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content"><?= $article['content'] ?></textarea>

    <input type="hidden" name="id" value="<?= $article['pk_id'] ?>">

    <input type="submit" value="Publier">
</form>

<p><a href="index.php?controller=adminpanel&task=dashboard">Retour au dashboard</a></p>
