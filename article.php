<?php

require_once 'librairies/database.php';
require_once 'librairies/functions.php';
require_once 'librairies/models/Article.php';
require_once 'librairies/models/Comment.php';

$articleModel = new Article();
$commentModel = new Comment();

/**
 * 1. Récupération du param "id" et vérification de celui-ci
 */
$article_id = null;

// Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $article_id = $_GET['id'];
}

// On peut désormais décider : erreur ou pas ?!
if (!$article_id) {
    die("Vous devez préciser un paramètre `id` dans l'URL !");
}

$pdo = getPdo();

/**
 * 3. Récupération de l'article en question
 */
$article = $articleModel->find($article_id);

/**
 * 4. Récupération des commentaires de l'article en question
 */
$commentaires = $commentModel->findAllByArticle($article_id);

/**
 * 5. Affichage
 */
$pageTitle = $article['title'];

render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
