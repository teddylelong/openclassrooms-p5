<h1>Liste des utilisateurs :</h1>

<table>
    <thead>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Droits admin</th>
        <th>Date d'inscription</th>
        <th></th>
    </thead>
    <tbody>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?= $user['lastname'] ?></td>
            <td><?= $user['firstname'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['is_admin'] ?></td>
            <td><?= $user['created_at'] ?></td>
            <td><a href="index.php?controller=user&task=delete&id=<?= $user['pk_id'] ?>" onclick="return window.confirm('Êtes-vous sur de vouloir supprimer cet utilisateur ?')">Supprimer</a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<p><a href="index.php?controller=adminpanel&task=dashboard">Retour au dashboard</a></p>