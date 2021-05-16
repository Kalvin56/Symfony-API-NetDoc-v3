<?php

namespace App\Controller;

use App\Repository\PatientRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPatientController extends AbstractController
{
    #[Route('/api/patients/{id}', name: 'api_patients_id', methods: ['GET'])]
    public function doctor($id, PatientRepository $patientRepository): Response
    {
        $data = $patientRepository->find($id);
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $data_id = $data->getUser()->getId();
        if($user_id !== $data_id){
            return $this->json([
                "status" => 403,
                "message" => "Access denied"
            ], 403);
        }
        return $this->json($data,200,[],['groups' => 'show_patient']);
    }
}
