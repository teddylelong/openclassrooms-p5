<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon blog | <?= $pageTitle ?></title>
</head>

<body class="website">
    <?php require_once 'inc/website/header.inc.php'?>
    <?php require_once 'inc/website/nav.inc.php'; ?>

    <?php Notification::display(); ?>

    <?= $pageContent ?>

    <?php require_once 'inc/website/footer.inc.php' ?>
</body>

</html>