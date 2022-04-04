<?php

namespace Controllers;

use Renderer;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
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