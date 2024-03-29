<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\EditPasswordType;
use App\Form\EditUserInformationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
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
     * @Route("/mon-compte", name="app_account")
     */
    public function index(): Response
    {
        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        return $this->render('pages/account/index.html.twig', [
            'sessionCard' => $sessionCard,
            'categories' => $this->categories
        ]);
    }

    /**
     * @Route("/mon-compte/mes-informations", name="app_account_informations")
     */
    public function profils(Request $request): Response
    {

        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(EditUserInformationType::class, $user);

        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $emailExist = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if ($form->isValid()) {
                $this->entityManager->flush();

                $notification['type'] = 'success';
                $notification['content'] = "Vos informations ont bien été mise à jour.";
            } elseif ($emailExist && $user->getEmail() != $this->getUser()->getEmail()) {
                $notification['type'] = 'danger';
                $notification['content'] = "L'email que vous avez renseigné existe déjà.";
            }
        }

        return $this->render('account/informations.html.twig', [
            'sessionCard' => $sessionCard,
            'form' => $form->createView(),
            'notification' => $notification,
            'categories' => $this->categories
        ]);
    }

     /**
     * @Route("/mon-compte/mot-de-passe", name="app_account_password")
     */
    public function editPassword(Request $request, UserPasswordHasherInterface $hasher): Response
    {

        $session = $this->requestStack->getSession();
        $sessionCard = $session->get('cardSession');

        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(EditPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($hasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->flush();

                return $this->redirect('https://127.0.0.1:8000/mon-compte?password=ok');
            } else {
                $notification["type"] = "danger";
                $notification["content"] = "Votre mot de passe actuel n'est pas le bon";
            }
        }

        return $this->render('account/password.html.twig', [
            'sessionCard' => $sessionCard,
            'form' => $form->createView(),
            'notification' => $notification,
            'categories' => $this->categories
        ]);
    }

    /**
     * @Route("mon-compte/supprimer", name="app_account_delete")
     */
    public function delete(): Response
    {
        $user = $this->getUser();

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
}
