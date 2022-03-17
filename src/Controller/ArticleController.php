<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/admin/article/{id}/delete", name="app_article_list")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $article = $articleRepository->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_article_list');
    }

    /**
     * @Route("/admin/article/create", name="app_article_create")
     */
    public function createArticle(Request $request, EntityManagerInterface $em)
    {
        $article = new Article();

        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $em->persist($article);
            $em->flush();
        }

        return $this->render('/article/createArticle.html.twig', [
            'articleForm' => $articleForm->createView(),
        ]);
    }
}
