<?php

namespace App\Controller;

use App\Entity\JwtRefresh;
use App\Service\JwtHelper;
use App\Repository\UserRepository;
use App\Repository\DoctorRepository;
use App\Repository\JwtRefreshRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login/doctor', name: 'api_login', methods:['POST'])]
    public function index(Request $request, UserRepository $userRepository, JwtHelper $jwthelper, DoctorRepository $doctorRepository, EntityManagerInterface $em, JwtRefreshRepository $jwtRefreshRepository): Response
    {
        $jsonRecu = $request->getContent();
        try{
            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('email') || !$request->request->get('password')){
                return $this->json([
                    'status' => 400,
                    'message' => 'Tous les champs doivent êtres remplis'
                ],400);
            }
            $email = $request->get('email');
            $password = $request->get('password');
            $data = $userRepository->findOneBy(array('email' => $email, 'type' => 'doctor'));
            //Vérification utilisateur existant
            if(!$data){
                return $this->json([
                    'status' => 404,
                    'message' => 'Aucun utilisateur correspondant'
                ], 404);
            }
            //Vérification mot de passe correct
            $data_password = $data->getPassword();
            $isPasswordCorrect = password_verify($password, $data_password);
            if(!$isPasswordCorrect){
                return $this->json([
                    'status' => 400,
                    'message' => 'Mot de passe incorrect'
                ], 400);
            }
            //Payload
            $role = $data->getRoles();
            $data_email = $data->getEmail();
            $data_user_id = $data->getId();
            $doctor = $doctorRepository->findOneBy(array('user' => $data));
            $data_complete_name = $doctor->getDoctorCompleteName();
            $issuer_claim = "login/doctor"; // this can be the servername
            $audience_claim = "doctor"; // audience
            $jwt = $jwthelper->createJWT($issuer_claim,$audience_claim,$data_complete_name,$data_email,$data_user_id, $role);
            $jwt_refresh = $jwthelper->createJWTRefresh($issuer_claim,$audience_claim,$data_complete_name,$data_email,$data_user_id, $role);
            $jwtrefresh_entity = new JwtRefresh();
            $jwtrefresh_entity->setJwtrefreshDateIssued(new \DateTime());            
            $jwtrefresh_entity->setJwtrefreshValue(password_hash($jwt_refresh,PASSWORD_DEFAULT));
            $jwtrefresh_entity->setUser($data);            
            $em->persist($jwtrefresh_entity);
            $em->flush();
            return $this->json([
                'status' => 200,
                'message' => 'Connexion réussie',
                'jwt' => $jwt,
                'jwt_refresh' => $jwt_refresh
            ], 200);
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


    #[Route('/api/login/patient', name: 'api_login_patient', methods:['POST'])]
    public function patient(Request $request, UserRepository $userRepository, JwtHelper $jwthelper, PatientRepository $patientRepository): Response
    {
        $jsonRecu = $request->getContent();
        try{
            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('email') || !$request->request->get('password')){
                return $this->json([
                    'status' => 400,
                    'message' => 'Tous les champs doivent êtres remplis'
                ],400);
            }
            $email = $request->get('email');
            $password = $request->get('password');
            $data = $userRepository->findOneBy(array('email' => $email, 'type' => 'patient'));
            //Vérification utilisateur existant
            if(!$data){
                return $this->json([
                    'status' => 404,
                    'message' => 'Aucun utilisateur correspondant'
                ], 404);
            }
            //Vérification mot de passe correct
            $data_password = $data->getPassword();
            $isPasswordCorrect = password_verify($password, $data_password);
            if(!$isPasswordCorrect){
                return $this->json([
                    'status' => 400,
                    'message' => 'Mot de passe incorrect'
                ], 400);
            }
            //Payload
            $role = $data->getRoles();
            $data_email = $data->getEmail();
            $data_user_id = $data->getId();
            $patient = $patientRepository->findOneBy(array('user' => $data));
            $data_complete_name = $patient->getPatientCompleteName();
            $issuer_claim = "login/patient"; // this can be the servername
            $audience_claim = "patient"; // audience
            $jwt = $jwthelper->createJWT($issuer_claim,$audience_claim,$data_complete_name,$data_email,$data_user_id, $role);
            $jwt_refresh = $jwthelper->createJWTRefresh($issuer_claim,$audience_claim,$data_complete_name,$data_email,$data_user_id, $role);
            return $this->json([
                'status' => 200,
                'message' => 'Connexion réussie',
                'jwt' => $jwt,
                'jwt_refresh' => $jwt_refresh
            ], 200);
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
}
