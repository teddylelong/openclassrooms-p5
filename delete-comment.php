<?php

require_once 'librairies/database.php';
require_once 'librairies/functions.php';
require_once 'librairies/models/Comment.php';

$model = new Comment();

/**
 * 1. Récupération du paramètre "id" en GET
 */
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Ho ! Fallait préciser le paramètre id en GET !");
}

$id = $_GET['id'];


/**
 * 2. Connexion à la base de données avec PDO
 */
$pdo = getPdo();

/**
 * 3. Vérification de l'existence du commentaire
 */
$commentaire = $model->find($id);
if (!$commentaire) {
    die("Aucun commentaire n'a l'identifiant $id !");
}

/**
 * 4. Suppression réelle du commentaire
 * On récupère l'identifiant de l'article avant de supprimer le commentaire
 */
$article_id = $commentaire['article_id'];
$model->delete($id);


/**
 * 5. Redirection vers l'article en question
 */
redirect('article.php?id=' . $article_id);
