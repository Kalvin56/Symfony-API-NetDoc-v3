<?php

namespace App\Controller;

use App\Entity\Appointment;
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
    #[Route('/api/appointment/create', name: 'api_appointment_create', methods:['POST'])]
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
}
