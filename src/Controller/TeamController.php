<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;
use App\Form\TeamType;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function index()
    {
      $repo = $this->getDoctrine()->getRepository(Team::class);
      $teams = $repo->findAll();
      return $this->render('team/index.html.twig', [
          'teams' => $teams,
      ]);
    }

    /**
     * @Route("/team/new", name="team_new")
     */
    public function new(Request $request)
    {
      $team = new Team();
      $form = $this->createForm(TeamType::class, $team);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        $team = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();
        return $this->redirectToRoute('team');
      }

      return $this->render('team/form.html.twig', [
          'form' => $form->createView(),
      ]);
    }
}
