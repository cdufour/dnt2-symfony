<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Player;
use App\Form\PlayerType;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="player")
     */
    public function index()
    {
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
        ]);
    }

    /**
     * @Route("/player/new", name="player_new")
     */
    public function new(Request $request)
    {
      $team = new Player();
      $form = $this->createForm(PlayerType::class, $team);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
      }

      return $this->render('player/form.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
