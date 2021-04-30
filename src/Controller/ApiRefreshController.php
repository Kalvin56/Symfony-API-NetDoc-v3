<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Exception;
use \Firebase\JWT\JWT;
use App\Service\JwtHelper;
use App\Repository\JwtRefreshRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiRefreshController extends AbstractController
{
    #[Route('/api/refresh', name: 'api_refresh', methods:['POST'])]
    public function index(Request $request, JwtRefreshRepository $jwtRefreshRepository, EntityManagerInterface $em, JwtHelper $jwthelper, DoctorRepository $doctorRepository, PatientRepository $patientRepository): Response
    {
        try{

            $request = $this->transformJsonBody($request);
            if (!$request || !$request->get('jwtrefresh')){
                return $this->json([
                    "status" => 400,
                    "message" => "erreur"
                ],400);
            }
            $jwtrefresh = $request->get('jwtrefresh');
            $jwtrefresh_decode = JWT::decode($jwtrefresh, $this->getParameter('jwt_refresh_secret'), array('HS256'));
            $user_id = $jwtrefresh_decode->data->id;
            $jwtrefresh_entity_array = $jwtRefreshRepository->findBy(array('user' => $user_id));
            foreach($jwtrefresh_entity_array as $row){
                if(password_verify($jwtrefresh,$row->getJwtrefreshValue())){
                    echo "hey";
                    $jwtrefresh_entity = $jwtRefreshRepository->findOneBy(array('jwtrefresh_value' => $row->getJwtrefreshValue()));
                }
            }
            if(!$jwtrefresh_entity){
                return $this->json([
                    "status" => 400,
                    "message" => "erreur"
                ],400);
            }
            $type = $jwtrefresh_entity->getUser()->getType();
            $email = $jwtrefresh_entity->getUser()->getEmail();
            $role = $jwtrefresh_entity->getUser()->getRoles();
            if($type === "doctor"){
                $doctor = $doctorRepository->findOneBy(array("user" => $user_id));
                $complete_name = $doctor->getDoctorCompleteName();
            }
            if($type === "patient"){
                $patient = $patientRepository->findOneBy(array("user" => $user_id));
                $complete_name = $patient->getPatientCompleteName();
            }         
            $new_jwtrefresh = $jwthelper->createJWTRefresh("refresh", $type, $complete_name, $email, $user_id, $role);
            $new_jwt = $jwthelper->createJWT("refresh", $type, $complete_name, $email, $user_id, $role);
            $jwtrefresh_entity->setJwtrefreshValue(password_hash($new_jwtrefresh, PASSWORD_DEFAULT));
            $jwtrefresh_entity->setJwtrefreshDateIssued(new \DateTime());
            $em->persist($jwtrefresh_entity);
            $em->flush();
            return $this->json([
                "status" => 200,
                "jwt" => $new_jwt,
                "jwtrefresh" => $new_jwtrefresh
            ],200);
            // dd(password_verify($jwtrefresh,$jwtrefresh_entity->getJwtrefreshValue()));

        }catch(Exception $e){
            return $this->json([
                "status" => 400,
                "message" => "Access denied"
            ],400);
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
