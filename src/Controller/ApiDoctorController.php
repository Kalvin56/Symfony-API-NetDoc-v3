<?php

namespace App\Controller;

use DateTime;
use App\Repository\DoctorRepository;
use App\Repository\AppointmentRepository;
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
        $data = $doctorRepository->find($id);
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $data_id = $data->getUser()->getId();
        if($user_id !== $data_id){
            return $this->json([
                "status" => 403,
                "message" => "Access denied"
            ], 403);
        }
        return $this->json($data,200,[],['groups' => 'show_doctor']);
    }

    #[Route('/api/search/doctors', name: 'api_search_doctors', methods: ['POST'])]
    public function search(Request $request, DoctorRepository $doctorRepository, AppointmentRepository $appointmentRepository): Response
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

        $now = new \DateTime();

        // $appointments = $appointmentRepository->findBy(array('appointment_doctor' => $data->getId(), 'appointment_status' => 1), array('appointment_date' => 'DESC'));
        $appointments = $appointmentRepository->findByDate($now,$data->getId(),1);

        if($data){
            return $this->json([
                "infos" => $data,
                "appointments" => $appointments
            ],200,[],['groups' => ['show_doctor', 'show_appointment']]);
        }else{
            return $this->json([
                "status" => 404,
                "message" => "no doctor found"
            ],404);
        }
     
    }

    #[Route('/api/cities/doctors', name: 'api_cities_doctors', methods: ['GET'])]
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
