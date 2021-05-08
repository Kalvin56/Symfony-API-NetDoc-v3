<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiDoctorController extends AbstractController
{
    #[Route('/api/doctors', name: 'api_doctors', methods: ['GET'])]
    public function index(DoctorRepository $doctorRepository): Response
    {
        $data = $doctorRepository->findAll();
        return $this->json($data,200,[],['groups' => 'show_doctor']);
    }

    #[Route('/api/doctors/{id}', name: 'api_doctors_id', methods: ['GET'])]
    public function doctor($id, DoctorRepository $doctorRepository): Response
    {
        // $data = $doctorRepository->findAll();
        return $this->json($id,200);
    }

    #[Route('/api/doctors/search', name: 'api_doctors_search', methods: ['POST'])]
    public function search(Request $request, DoctorRepository $doctorRepository): Response
    {
        // obtenir une donnée
        // méthode de base :
        // $jsonRecu = json_decode($request->getContent());
        // $doctor_complete_name = $jsonRecu->doctor_complete_name;
        // méthode avec la fonction transformJsonBody qui reprend le json_decode (en bas de page) :
        // $request = $this->transformJsonBody($request);
        // $doctor_complete_name = $request->get('$doctor_complete_name');

        $request = $this->transformJsonBody($request);

        if (!$request || !$request->get('doctor_complete_name') || !$request->request->get('doctor_city')){
            return $this->json([
                "status" => 400,
                "message" => "erreur"
            ],400);
        }
        
        $complete_name = $request->get('doctor_complete_name');
        $city = $request->get('doctor_city');
                 
        $data = $doctorRepository->findOneBy(array('doctor_complete_name' => $complete_name, 'doctor_city' => $city ));

        if($data){
            return $this->json($data,200,[],['groups' => 'show_doctor']);
        }else{
            return $this->json([
                "status" => 404,
                "message" => "no doctor found"
            ],404);
        }
        
        
        
    }

    #[Route('/api/doctors/cities', name: 'api_doctors_cities', methods: ['GET'])]
    public function cities(DoctorRepository $doctorRepository): Response
    {
        $data = $doctorRepository->findCities();
        // dd($data);
        return $this->json($data,200,[],['groups' => 'show_doctor']);
    }
    
    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
