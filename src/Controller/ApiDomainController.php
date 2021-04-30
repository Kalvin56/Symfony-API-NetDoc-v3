<?php

namespace App\Controller;

use App\Repository\DomainRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiDomainController extends AbstractController
{
    #[Route('/api/domain', name: 'api_domain')]
    public function index(DomainRepository $domainRepository): Response
    {
        $data = $domainRepository->findAll();
        return $this->json($data,200,[],['groups' => 'show_domain']);
    }
}
