<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $entityManager;
    private $categories;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->categories = $this->entityManager->getRepository(Category::class)->findBy(['toHide' => 0], ['inOrder' => 'asc']);
    }
    
    /**
     * @Route("/categorie/{id}/{slug}", name="category")
     */
    public function index($id, $slug): Response
    {

        $products = $this->entityManager->getRepository(Product::class)->findBy(['id_category' => $id]);
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['id' => $id]);

        return $this->render('pages/category/index.html.twig', [
            'categories' => $this->categories,
            'products' => $products,
            'category' => $category
        ]);
    }
}
