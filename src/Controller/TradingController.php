<?php

namespace App\Controller;

use App\Entity\Trading;
use App\Form\TradingFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TradingController extends AbstractController
{
    /**
     * @Route("/trading", name="trading")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        
        $tradings = $this->getDoctrine()->getRepository(Trading::class)->findAll();
        var_dump($tradings);

        return $this->render('trading/index.html.twig', [
            'tradings' => $tradings,
            'controller_name' => 'TradingController',
        ]);

    }

    /**
     * @Route("/trading/new", name="trading_new")
     */
    public function newTrading(): Response
    {
       $form = $this->createForm(TradingFormType::class);

        return $this->render('trading/new.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'TradingController',
        ]);        


    }
}
