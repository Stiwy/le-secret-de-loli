<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {

        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        return $this->render('pages/home/index.html.twig', [
            'sessionCard' => $sessionCard,
            'categories' => $this->categories
        ]);
    }
}
