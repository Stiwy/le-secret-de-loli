<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
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
     * @Route("/inscription", name="app_register")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {

        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $emailExist = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($form->isValid()) {
                $password = $hasher->hashPassword($user, $user->getPassword());

                $user->setPassword($password);
                $user->setInsertDate();
                
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $this->redirect('connexion?inscription=ok');
            } elseif ($emailExist) {
                $notification['type'] = 'danger';
                $notification['content'] = "L'email que vous avez renseigné existe déjà.";
            }
        }

        return $this->render('pages/register/index.html.twig', [
            'sessionCard' => $sessionCard,
            'form' => $form->createView(),
            'notification' => $notification,
            'categories' => $this->categories
        ]);
    }
}
