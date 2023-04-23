<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Trading;
use App\Form\TradingFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class TradingController extends AbstractController
{
    /**
     * @Route("/trading", name="trading")
     */
        
        public function new(Request $request, EntityManagerInterface $em, FlashBagInterface $flashBag): Response
        {
            $trading = new Trading();
            $form = $this->createForm(TradingFormType::class, $trading);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->getUser();
                $accounts = $user->getAccounts();
               
                foreach ($accounts as $acc) {
                    $newBalance = $acc->getBalance() + $trading->getAmount();
                    $acc->setBalance($newBalance);
                    $em->persist($acc);
                }

                $em->persist($trading);
                $em->flush();

                $flashBag->add('success', 'Le virement a été effectué avec succès.');

                return $this->redirectToRoute('account');
            }

            return $this->render('trading/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }

    }

       


