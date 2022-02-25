<h1>Modifier l'article <?= $article->getTitle() ?></h1>

<form action="/article/update/" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= $article->getTitle() ?>"/>

    <label for="excerpt">Extrait :</label>
    <textarea name="excerpt" id="excerpt"><?= $article->getExcerpt() ?></textarea>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content"><?= $article->getContent() ?></textarea>

    <?php // TODO : Ajouter un champ "Modifier l'auteur" ?>

    <input type="hidden" name="id" value="<?= $article->getId() ?>">

    <input type="submit" value="Publier">
</form>

<p><a href="/adminpanel/dashboard/">Retour au dashboard</a></p>
