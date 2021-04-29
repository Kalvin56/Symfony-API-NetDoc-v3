<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDoctorController extends AbstractController
{
    #[Route('/api/doctor', name: 'api_doctor', methods: ['GET'])]
    public function index(DoctorRepository $doctorRepository): Response
    {
        $data = $doctorRepository->findAll();
        return $this->json($data,200);
    }
}
