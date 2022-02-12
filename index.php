<?php

require_once 'librairies/database.php';
require_once 'librairies/functions.php';
require_once 'librairies/models/Article.php';

$model = new Article();


/**
 * 2. Récupération des articles
 */

$articles = $model->findAll();

/**
 * 3. Affichage
 */
$pageTitle = "Accueil";
render('articles/index', compact('pageTitle', 'articles'));
