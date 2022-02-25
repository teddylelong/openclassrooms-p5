<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | <?= $pageTitle ?></title>
</head>

<body class="admin">
    <?php Notification::display(); ?>

    <?= $pageContent ?>
</body>

</html>