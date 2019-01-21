<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Util\Teacher;


class TestController extends AbstractController {

  function hello()
  {
    return new Response('<h1>Buongiorno  !</h1>');
  }

  /**
  * @Route("/help", name="help")
  */
  function help()
  {
    // $html = '<h1>Aiuto  !</h1>';
    // $res = new Response($html);
    // return $res;
    $title = 'Aiuto mi sta uccidendo !';
    $students = ['Julien', 'Kevin', 'Rayane'];
    $trainees = [
      ['name' => 'Julien', 'birthyear' => 1995, 'Senior' => true],
      ['name' => 'Kevin', 'birthyear' => 1936, 'Senior' => false],
      ['name' => 'Rayane', 'birthyear' => 2010, 'Senior' => false],
    ];

    $teachers = [
      new Teacher('Chris'),
      new Teacher('Greg'),
      new Teacher('Medhi')
    ];

    return $this->render('test/help.html.twig', [
      'title' => $title,
      'students' => $students,
      'trainees' => $trainees,
      'teachers' => $teachers
    ]);

  }

}
