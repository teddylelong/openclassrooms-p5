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
            <td><?= $user->getLastname() ?></td>
            <td><?= $user->getFirstname() ?></td>
            <td><?= $user->getEmail() ?></td>
            <td><?= $user->getIsAdmin() ?></td>
            <td><?= $user->getCreatedAt() ?></td>
            <td><a href="/user/delete/<?= $user->getId() ?>/" onclick="return window.confirm('Êtes-vous sur de vouloir supprimer cet utilisateur ?')">Supprimer</a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>
