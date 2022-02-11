<?php

require_once 'librairies/database.php';
require_once  'librairies/functions.php';


/**
 * 2. Récupération des articles
 */

$articles = findAllArticles();

/**
 * 3. Affichage
 */
$pageTitle = "Accueil";
render('articles/index', compact('pageTitle', 'articles'));
