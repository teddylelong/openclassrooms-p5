<h1>Modifier l'article <?= $article->getTitle() ?></h1>


<form action="/article/update/" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="<?= $article->getTitle() ?>"/>

    <label for="excerpt">Extrait :</label>
    <textarea name="excerpt" id="excerpt"><?= $article->getExcerpt() ?></textarea>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content"><?= $article->getContent() ?></textarea>

    <label for="author">Attribuer un nouvel auteur :</label>
    <select name="author" id="author">
        <option value="<?= $article->getAuthorId() ?>">Garder l'auteur actuel (<?= $article->getAuthorName() ?>)</option>
        <?php foreach ($users as $user) : ?>
        <option value="<?= $user->getId() ?>"><?= $user->getFirstname() .' '. $user->getLastname() ?></option>
        <?php endforeach ?>
    </select>

    <input type="hidden" name="id" value="<?= $article->getId() ?>">

    <input type="submit" value="Publier">
</form>
