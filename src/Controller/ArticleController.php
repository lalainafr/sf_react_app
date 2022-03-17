<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="app_article_list")
     */
    public function listArticle(ArticleRepository $articleRepository)
    {
        $articles =  $articleRepository->findAll();

        return $this->render('/article/index.html.twig', [
            "articles" => $articles,
        ]);
    }
}
