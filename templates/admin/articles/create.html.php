<h1>Rédiger un article</h1>

<form action="index.php?controller=article&task=insert" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title"/>

    <label for="excerpt">Rédigez un extrait :</label>
    <textarea name="excerpt" id="excerpt"></textarea>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content"></textarea>

    <input type="hidden" name="fk_user_id" value="1">

    <input type="submit" value="Publier">
</form>

<p><a href="index.php?controller=adminpanel&task=dashboard">Retour au dashboard</a></p>
