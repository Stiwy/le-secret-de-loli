<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
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
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/security/login.html.twig', [
            'sessionCard' => $sessionCard,
            'last_username' => $lastUsername, 
            'error' => $error,
            'categories' => $this->categories
        ]);
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
