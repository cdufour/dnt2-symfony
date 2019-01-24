<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Player;
use App\Form\PlayerType;

class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="player")
     */
    public function index()
    {
      $repo = $this->getDoctrine()->getRepository(Player::class);
      $players = $repo->findAll();

      return $this->render('player/index.html.twig', [
          'players' => $players,
      ]);
    }

    /**
     * @Route("/player/new", name="player_new")
     */
    public function new(Request $request)
    {
      $player = new Player();
      $form = $this->createForm(PlayerType::class, $player);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        $player = $form->getData();

        // traitement de l'upload

        $file = $form->get('photo')->getData();
        $filename = $file->getClientOriginalName();
        $player->setPhoto($filename);

        try {
          $file->move(
            $this->getParameter('player_photo_upload_dir'),
            $filename);
        } catch (FileException $e) {
          echo 'erreur';
        }

        // enregistrement en db
        $em = $this->getDoctrine()->getManager();
        $em->persist($player);
        $em->flush();

        return $this->redirectToRoute('player');
      }

      return $this->render('player/form.html.twig', [
          'form' => $form->createView()
      ]);
    }
}
