<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Color;
use App\Form\ColorType;

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
      $colorsRaw = $repo->findAllRaw();

      return $this->render('color/index.html.twig', [
        'colors' => $colors,
        'colorsRaw' => $colorsRaw
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
     * @Route("/color/single/{name}", name="color_single")
     */
    public function single($name)
    {
      $repo = $this->getDoctrine()->getRepository(Color::class);
      $color = $repo->findOneByEn($name);
      $hexa = $repo->findByColorname($name);

      var_dump($hexa);

      if (!$color) {
        // couleur non trouvée en anglais
        // Existe-t-elle en français ?
        $color = $repo->findOneByFr($name);
      }

      if (!$color) return new Response('Couleur non trouvée');

      // couleur trouvée
      $html = '<div style="width:100px;height:100px;background-color:#'.$color->getHexa().'"></div>';
      return new Response($html);
    }

  /**
   * @Route("/color/add", name="color_add")
   */
   public function add(Request $request)
   {
     $color = new Color(null, null, null);
     $form = $this->createForm(ColorType::class, $color);

     // traitement de la soumission du formulaire
     $form->handleRequest($request);
     if ($form->isSubmitted()) {
       $color = $form->getData();
       $em = $this->getDoctrine()->getManager();
       $em->persist($color);
       $em->flush();

       return $this->redirectToRoute('color');
     }

     return $this->render('color/form.html.twig', [
       'form' => $form->createView()
     ]);
   }


   /**
    * @Route("/color/edit/{id}", name="color_edit")
    */
    public function edit(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();
      $color = $em->getRepository(Color::class)->find($id);

      $form = $this->createForm(ColorType::class, $color);

      $form->handleRequest($request);
      if ($form->isSubmitted()) {
        $color = $form->getData();
        $em->flush();
        return $this->redirectToRoute('color');
      }

      return $this->render('color/form.html.twig', [
        'form' => $form->createView()
      ]);

    }





}
