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
            <td><?= $comment->getAuthor() ?></td>
            <td><?= $comment->getEmail() ?></td>
            <td><?= $comment->getContent() ?></td>
            <td><?= $comment->getCreatedAt() ?></td>
            <td><a href="/article/showadmin/<?= $comment->getArticleId() ?>/">Voir</a></td>
            <td><a href="/comment/approve/<?= $comment->getId() ?>/">Approuver</a> <a href="/comment/disapprove/<?= $comment->getId() ?>/">Désapprouver</a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>