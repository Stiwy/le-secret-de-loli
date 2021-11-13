<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $entityManager;
    private $categories;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack) 
    {
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->categories = $this->entityManager->getRepository(Category::class)->findBy(['toHide' => 0], ['inOrder' => 'asc']);
    }
    
    /**
     * @Route("/categorie/{slug}", name="category")
     */
    public function index($slug): Response
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['slug' => $slug]);
        $articles = $this->entityManager->getRepository(Product::class)->findBy(['id_category' => $category->getId(), 'toHide' => 0]);

        $session = $this->requestStack->getSession();   
        $sessionCard = $session->get('cardSession');

        return $this->render('pages/category/index.html.twig', [
            'sessionCard' => $sessionCard,
            'categories' => $this->categories,
            'articles' => $articles,
            'category' => $category
        ]);
    }
}
