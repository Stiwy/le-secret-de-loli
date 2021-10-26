<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="app_register")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $emailExist = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

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
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
