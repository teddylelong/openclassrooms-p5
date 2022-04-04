<?php

namespace Controllers;

use Dto\PostDto;
use Entities\User;
use Models\UserModel;
use Models\ArticleModel;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Render the homepage
     * Get last articles order by date and display it on homepage
     *
     * @return void
     */
    public function home(): void
    {
        $articleModel = new ArticleModel();
        $articles = $articleModel->findAll('articles.created_at DESC LIMIT 0, 4');

        $userModel = new UserModel();

        foreach ($articles as $article) {
            $user = $userModel->find($article->getAuthorId());

            if (!$user) {
                $user = new User();
            }

            $posts[] = new PostDto($article, $user);
        }

        $pageTitle = "Accueil";
        $this->renderer->render('articles/home', compact('pageTitle', 'posts'));
    }

    /**
     * Render "A propos" static page
     *
     * @return void
     */
    public function aPropos()
    {
        $pageTitle = 'À propos';
        $this->renderer->render('pages/a-propos', compact('pageTitle'));
    }

    /**
     * Render "Mentions légales" static page
     *
     * @return void
     */
    public function mentionsLegales()
    {
        $pageTitle = 'Mentions légales';
        $this->renderer->render('pages/mentions-legales', compact('pageTitle'));
    }

    /**
     * Render "Données personnelles" static page
     *
     * @return void
     */
    public function donneesPersonnelles()
    {
        $pageTitle = "Données personnelles";
        $this->renderer->render('pages/donnees-personnelles', compact('pageTitle'));
    }

    /**
     * Render "Mon CV" static page
     *
     * @return void
     */
    public function monCv()
    {
        $pageTitle = "Mon CV";
        $this->renderer->render('pages/mon-cv', compact('pageTitle'));
    }
}