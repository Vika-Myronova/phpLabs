<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        return new Response('This is a test method!');
    }
}
