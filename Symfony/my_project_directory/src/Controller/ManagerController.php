<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'app_manager')]
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        if (!$authChecker->isGranted('ROLE_MANAGER')) {
            throw $this->createAccessDeniedException('Access Denied!');
        }

        return $this->render('manager/index.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }
}
