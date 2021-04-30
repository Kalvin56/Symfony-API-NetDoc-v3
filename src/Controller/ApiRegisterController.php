<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Repository\DomainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ApiRegisterController extends AbstractController
{
    #[Route('/api/register/doctor', name: 'api_register_doctor', methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  ValidatorInterface $validator, DomainRepository $domainRepository): Response
    {
        $jsonRecu = $request->getContent();
        try{
            $user =  $serializer->deserialize($jsonRecu, User::class, 'json');
            $pass = $user->getPassword();
            $user->setDateRegister(new \DateTime());

            $doctor =  $serializer->deserialize($jsonRecu, Doctor::class, 'json');
            $doctor->setUser($user);

            $errors_user = $validator->validate($user);
            if(count($errors_user) > 0){
                return $this->json($errors_user, 400);
            }

            $errors_doctor = $validator->validate($doctor);
            if(count($errors_doctor) > 0){
                return $this->json($errors_doctor, 400);
            }

            $age =  $this->Age($doctor->getDoctorBirth());
            if($age < 18){
                return $this->json([
                    'status' => 400,
                    'message' => 'Il faut avoir au minimum 18 ans'
                ], 400);
            }
            if($age > 120){
                return $this->json([
                    'status' => 400,
                    'message' => 'Age incorrect'
                ], 400);
            }

            $request = $this->transformJsonBody($request);
            if($request->get('doctor_confirm_password')){
                $comfirm_password = $request->get('doctor_confirm_password');
                if($comfirm_password !== $pass){
                    return $this->json([
                        'status' => 400,
                        'message' => 'Les mots de passe de correspondent pas'
                    ], 400);
                }              
            }else{
                return $this->json([
                    'status' => 400,
                    'message' => 'Le champ confirmation mot de passe ne doit pas être vide'
                ], 400);
            }

            if($request->get('doctor_domain')){
                $domain_name_array = (array)$request->get('doctor_domain');
                for($i = 0; $i <= count($domain_name_array) - 1; $i++){
                    // echo $domain_id[$i];
                    if($domainRepository->findOneBy(array('domain_name' => $domain_name_array[$i]))){
                        // dump($domainRepository->find($domain_id[$i]));
                        $domain = $domainRepository->findOneBy(array('domain_name' => $domain_name_array[$i]));
                        $doctor->addDoctorDomainId($domain);
                    }else{
                        return $this->json([
                            'status' => 400,
                            'message' => 'La spécialité saisie est incorrect'
                        ], 400);
                    }
                }                
            }else{
                return $this->json([
                    'status' => 400,
                    'message' => 'Le champ spécialité ne doit pas être vide'
                ], 400);
            }


            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $user->setPassword($pass);
            $user->setRoles(["ROLE_DOCTOR"]);
            $user->setType("doctor");

            $name = $doctor->getDoctorName();
            $lastname = $doctor->getDoctorLastname();
            $completename = $name." ".$lastname;
            $doctor->setDoctorCompleteName($completename);

            $em->persist($user);
            $em->persist($doctor);
            $em->flush();
            return $this->json([
                'status' => 200,
                'message' => 'Création du compte réussie',
                'doctor' => $doctor
            ], 200,[],['groups' => 'show_doctor'] );
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


    #[Route('/api/register/patient', name: 'api_register_patient', methods: ['POST'])]
    public function patient(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  ValidatorInterface $validator): Response
    {
        $jsonRecu = $request->getContent();
        try{
            $user =  $serializer->deserialize($jsonRecu, User::class, 'json');
            $pass = $user->getPassword();
            $user->setDateRegister(new \DateTime());

            $patient =  $serializer->deserialize($jsonRecu, Patient::class, 'json');
            $patient->setUser($user);

            $errors_user = $validator->validate($user);
            if(count($errors_user) > 0){
                return $this->json($errors_user, 400);
            }

            $errors_patient = $validator->validate($patient);
            if(count($errors_patient) > 0){
                return $this->json($errors_patient, 400);
            }

            $age =  $this->Age($patient->getPatientBirth());
            if($age < 18){
                return $this->json([
                    'status' => 400,
                    'message' => 'Il faut avoir au minimum 18 ans'
                ], 400);
            }
            if($age > 120){
                return $this->json([
                    'status' => 400,
                    'message' => 'Age incorrect'
                ], 400);
            }

            $request = $this->transformJsonBody($request);
            if($request->get('patient_confirm_password')){
                $comfirm_password = $request->get('patient_confirm_password');
                if($comfirm_password !== $pass){
                    return $this->json([
                        'status' => 400,
                        'message' => 'Les mots de passe de correspondent pas'
                    ], 400);
                }              
            }else{
                return $this->json([
                    'status' => 400,
                    'message' => 'Le champ confirmation mot de passe ne doit pas être vide'
                ], 400);
            }


            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $user->setPassword($pass);
            $user->setRoles(["ROLE_PATIENT"]);
            $user->setType("patient");

            $name = $patient->getPatientName();
            $lastname = $patient->getPatientLastname();
            $completename = $name." ".$lastname;
            $patient->setPatientCompleteName($completename);

            $em->persist($user);
            $em->persist($patient);
            $em->flush();
            return $this->json([
                'status' => 200,
                'message' => 'Création du compte réussie',
                'doctor' => $patient
            ], 200,[],['groups' => 'show_patient'] );
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

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

    function Age($date_naissance) {
        $date_actuel = new \DateTime();
        return $date_actuel->diff($date_naissance, true)->y;
    }
}
