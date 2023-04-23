<?php

namespace App\Controller;

use App\Entity\Account;
use App\Form\AccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $accounts = $entityManager->getRepository(Account::class)->findBy(['owner' => $user]);

        return $this->render('account/index.html.twig', [
            'accounts' => $accounts,
            'controller_name' => 'AccountController',
        ]);
    }

    /**
     * @Route("/account/new", name="new_account")
     */
    public function newAccount(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AccountFormType::class);


        $user = $this->getUser();
        

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();

            $entityManager->persist($account);
            $entityManager->flush();
            return $this->redirectToRoute('account');
        }

        // Récupérer toutes les tâches de la base de données
        $accounts = $entityManager->getRepository(Account::class)->findAll();

        return $this->render('account/new.html.twig', [
            'form' => $form->createView(),
            'accounts' => $accounts, // ajouter cette ligne pour passer la variable accounts à votre vue
        ]);
    }

    /**
     * @Route("/account/{id}", name="show_account")
     */
    public function showAccount(Account $account): Response
    {
        return $this->render('account/show.html.twig', [
            'account' => $account,
        ]);
        
    }

    /**
     * @Route("/account/{id}/edit", name="edit_account")
     */
    public function editAccount(Account $account, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccountFormType::class, $account);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $account = $form->getData();

            $entityManager->persist($account);
            $entityManager->flush();
            return $this->redirectToRoute('account');
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView(),
            'account' => $account,
        ]);
    }

    /**
     * @Route("/account/{id}/delete", name="delete_account")
     */
    public function deleteAccount(Account $account, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($account);
        $entityManager->flush();

        return $this->redirectToRoute('account');
    }
}
