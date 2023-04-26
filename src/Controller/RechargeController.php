<?php

namespace App\Controller;

use App\Entity\Recharge;
use App\Form\RechargeFormType;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RechargeController extends AbstractController
{
    /**
     * @Route("/recharge", name="recharge")
     */
    public function recharge(AccountRepository $accountRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $account = $accountRepository->findOneBy(['owner' => $user]);

        if (!$account) {
            throw $this->createNotFoundException('No account found for user '.$user->getEmail());
        }

        $recharges = new Recharge();
        $recharges->setAccount($account);

        $form = $this->createForm(RechargeFormType::class, $recharges);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recharges);
            
            $balance = $account->getBalance() + $recharges->getAmount();
            $account->setBalance($balance);
            $entityManager->persist($account);
            $entityManager->flush();

            $this->addFlash('success', 'Recharge effectuée avec succès !');
            return $this->redirectToRoute('account');
        }

        return $this->render('recharge/index.html.twig', [
            'form' => $form->createView(),
            'account' => $account
        ]);
    }
}