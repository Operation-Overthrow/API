<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/api/login_check', name: 'app_login_check', methods: ['POST'])]
    public function loginCheck()
    {
        throw new \Exception('Something went wrong!');
    }

}