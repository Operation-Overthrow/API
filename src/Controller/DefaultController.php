<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/api/login_check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck()
    {
        throw new Exception('Something went wrong!');
    }

    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
