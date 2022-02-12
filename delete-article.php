<?php

require_once 'librairies/database.php';
require_once 'librairies/functions.php';
require_once 'librairies/models/Article.php';

$model = new Article;

/**
 * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
 */
if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Ho ?! Tu n'as pas précisé l'id de l'article !");
}

$id = $_GET['id'];

/**
 * 2. Connexion à la base de données avec PDO
 */
$pdo = getPdo();

/**
 * 3. Vérification que l'article existe bel et bien
 */
$article = $model->find($id);
if (!$article) {
    die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
}

/**
 * 4. Réelle suppression de l'article
 */
$model->delete($id);

/**
 * 5. Redirection vers la page d'accueil
 */
redirect('index.php');
