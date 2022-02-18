<h1>Rédiger un article</h1>

<form action="/article/insert/" method="POST">
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title"/>

    <label for="excerpt">Rédigez un extrait :</label>
    <textarea name="excerpt" id="excerpt"></textarea>

    <label for="content">Contenu :</label>
    <textarea name="content" id="content"></textarea>

    <input type="submit" value="Publier">
</form>

<p><a href="/adminpanel/dashboard/">Retour au dashboard</a></p>
