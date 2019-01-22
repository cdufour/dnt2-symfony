<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Color;

class ColorController extends AbstractController
{
    /**
     * @Route("/color", name="color")
     */
    public function index()
    {
      // récupération des couleurs depuis la bdd
      // via le repository
      $repo = $this->getDoctrine()->getRepository(Color::class);
      $colors = $repo->findAll();

      return $this->render('color/index.html.twig', [
        'colors' => $colors
      ]);
    }

    /**
     * @Route("/color/new", name="color_new")
     */
    public function new(Request $request)
    {
      //dump($request);
      $method = 'GET';
      if ($request->isMethod('POST')) {
        $method = 'POST';

        $color = new Color(
          $request->request->get('hexa'),
          $request->request->get('en'),
          $request->request->get('fr')
        );

        // formulaire soumis par le client
        // récupération des valeurs postées

        // Ecriture en base de données via le manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($color);
        $em->flush();

        // redirection vers l'index
        return $this->redirectToRoute('color');

      }

      return $this->render('color/new.html.twig', [
        'method' => $method
      ]);
    }

    /**
     * @Route("/couleur/{name}", name="color_single")
     */
    public function single($name)
    {
      return new
    }

}
