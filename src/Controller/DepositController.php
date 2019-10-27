<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/27/19
 * Time: 6:51 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepositController extends AbstractController
{
    /**
    * @Route("/lucky/number")
    */
    public function number()
    {
        $number = random_int(0, 100);



        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
