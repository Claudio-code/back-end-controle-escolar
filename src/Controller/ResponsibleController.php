<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResponsibleController extends AbstractController
{
    /**
     * @Route("/responsible", name="responsible")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ResponsibleController.php',
        ]);
    }
}
