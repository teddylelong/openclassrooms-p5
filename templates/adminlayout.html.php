<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | <?= $pageTitle ?></title>
</head>

<body class="admin">
    <?php require_once 'inc/admin/header.inc.php'; ?>
    <?php require_once 'inc/admin/nav.inc.php'; ?>

    <?php Notification::display(); ?>

    <?= $pageContent ?>

    <?php require_once 'inc/admin/footer.inc.php'; ?>
</body>

</html>