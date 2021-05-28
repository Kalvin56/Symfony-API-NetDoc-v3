<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Repository\AppointmentRepository;
use App\Repository\DoctorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ApiAppointmentController extends AbstractController
{
    #[Route('/api/appointments/create', name: 'api_appointments_create', methods:['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  ValidatorInterface $validator, DoctorRepository $doctorRepository): Response
    {
        $jsonRecu = $request->getContent();
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $doctor = $doctorRepository->findOneBy(array('user' => $user_id));
        try{
            $appointment =  $serializer->deserialize($jsonRecu, Appointment::class, 'json');
            $appointment->setAppointmentStatus(1);
            $appointment->setAppointmentDoctor($doctor);

            $errors_appointment = $validator->validate($appointment);
            if(count($errors_appointment) > 0){
                return $this->json($errors_appointment, 400);
            }

            $em->persist($appointment);
            $em->flush();
            return $this->json([
                'status' => 201,
                'message' => 'Création du rendez-vous réussie',
            ], 201);
        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }catch(NotNormalizableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    #[Route('/api/appointments/doctors/{id}', name: 'api_appointments_doctors_id', methods:['GET'])]
    public function doctor($id, AppointmentRepository $appointmentRepository): Response
    {
        $data = $appointmentRepository->findOneBy(array('appointment_doctor' => $id));
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $data_id = $data->getAppointmentDoctor()->getUser()->getId();
        $data_complete = $appointmentRepository->findBy(array('appointment_doctor' => $id), array('appointment_date' => 'DESC'));
        if($user_id !== $data_id){
            return $this->json([
                "status" => 403,
                "message" => "Access denied"
            ], 403);
        }
        return $this->json($data_complete,200,[],['groups' => 'show_appointment']);
    }

    #[Route('/api/appointments/status/{id}', name: 'api_appointments_status_id', methods:['POST'])]
    public function status($id, AppointmentRepository $appointmentRepository, Request $request, EntityManagerInterface $em): Response
    {

        $data = $appointmentRepository->find($id);

        $request = $this->transformJsonBody($request);

        if (!$request || !$request->get('status')){
            return $this->json([
                "status" => 400,
                "message" => "Veuillez renseigner le status"
            ],400);
        }

        $status = $request->get('status');

        if ($status !== 1 && $status !== 2 & $status !== 3){
            return $this->json([
                "status" => 400,
                "message" => "Veuillez renseigner un status correct"
            ],400);
        }
        
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $type = $this->get('security.token_storage')->getToken()->getUser()->getType();

        if($type !== "doctor" && $type !== "patient"){
            return $this->json([
                "status" => 400,
                "message" => "erreur"
            ],400);
        }

        if($type == "doctor"){

            $data_id_doctor = $data->getAppointmentDoctor()->getUser()->getId();

            if($user_id !== $data_id_doctor){
                return $this->json([
                    "status" => 403,
                    "message" => "Access denied"
                ], 403);
            }

        }

        if($type == "patient"){

            $data_id_patient = $data->getAppointmentPatient()->getUser()->getId();

            if($user_id !== $data_id_patient){
                return $this->json([
                    "status" => 403,
                    "message" => "Access denied"
                ], 403);
            }

        }

        $data->setAppointmentStatus($status);

        $em->persist($data);
        $em->flush();
        
        return $this->json([
            "status" => 200,
            "message" => "Status modifié"
        ], 200);
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
