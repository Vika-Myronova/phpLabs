<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('ROLE_CLIENT')) {
            throw $this->createAccessDeniedException('Access Denied!');
        }

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
