<h1>Commentaires en attente de modération</h1>

<table>
    <thead>
    <th>Pseudo</th>
    <th>Email</th>
    <th>Contenu</th>
    <th>Date d'ajout</th>
    <th>Article</th>
    <th></th>
    </thead>
    <tbody>
    <?php foreach ($comments as $comment) : ?>
        <tr>
            <td><?= $comment['author'] ?></td>
            <td><?= $comment['email'] ?></td>
            <td><?= $comment['content'] ?></td>
            <td><?= $comment['created_at'] ?></td>
            <td><a href="/article/showadmin/<?= $comment['article_id'] ?>/">Voir</a></td>
            <td><a href="/comment/approve/<?= $comment['pk_id'] ?>/">Approuver</a> <a href="/comment/disapprove/<?= $comment['pk_id'] ?>/">Désapprouver</a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<p><a href="/adminpanel/dashboard/">Retour au dashboard</a></p>