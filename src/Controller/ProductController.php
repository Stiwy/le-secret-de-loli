<?php

namespace App\Controller;

use App\Classes\Card;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Reference;
use App\Form\AddCardType;
use App\Partials\AddCard;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    private $categories;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack) 
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->categories = $this->entityManager->getRepository(Category::class)->findBy(['toHide' => 0], ['inOrder' => 'asc']);
    }

    /**
     * @Route("produit/{category}/{slug}", name="product")
     */
    public function index($slug, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Reference::class)->findProductByPrimaryReference($slug);
        $products = $this->entityManager->getRepository(Reference::class)->findAllReferencesOfProduct($slug);
        $articles = $this->entityManager->getRepository(Product::class)->findBy(['id_category' => $product[0]->getProduct()->getIdCategory()->getId(), 'toHide' => 0]);

        $session = $this->requestStack->getSession();
        $card = new Card();
        $addCard = $this->createForm(AddCardType::class, $card);
        AddCard::index($addCard, $session, $product, $request);        
        $sessionCard = $session->get('cardSession');

        return $this->render('product/index.html.twig', [
            'sessionCard' => $sessionCard,
            'product' => $product[0],
            'products' => $products,
            'articles' => $articles,
            'addCard' => $addCard->createView(),
            'categories' => $this->categories
        ]);
    }

    /**
     * @Route("produit/{category}/{slug}/{reference}", name="reference")
     */
    public function showReference($slug, $reference, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Reference::class)->findProductByReference($slug, $reference);
        $products = $this->entityManager->getRepository(Reference::class)->findAllReferencesOfProduct($slug);
        $articles = $this->entityManager->getRepository(Product::class)->findBy(['id_category' => $product[0]->getProduct()->getIdCategory()->getId(), 'toHide' => 0]);

        $session = $this->requestStack->getSession();
        $card = new Card();
        $addCard = $this->createForm(AddCardType::class, $card);
        AddCard::index($addCard, $session, $product, $request);        
        $sessionCard = $session->get('cardSession');

        return $this->render('product/index.html.twig', [
            'sessionCard' => $sessionCard,
            'product' => $product[0],
            'products' => $products,
            'articles' => $articles,
            'addCard' => $addCard->createView(),
            'categories' => $this->categories
        ]);
    }
}
