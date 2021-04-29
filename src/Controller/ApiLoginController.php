<?php

namespace App\Controller;

use App\Service\JwtHelper;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login/doctor', name: 'api_login', methods:['POST'])]
    public function index(Request $request, UserRepository $userRepository, JwtHelper $jwthelper): Response
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
            $data = $userRepository->findOneBy(array('email' => $email));
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
            $data_complete_name = "lol";
            $data_mail = $data->getEmail();
            $data_user_id = $data->getId();
            $issuer_claim = "login/user"; // this can be the servername
            $audience_claim = "user"; // audience
            $jwt = $jwthelper->createJWT($issuer_claim,$audience_claim,$data_complete_name,$data_mail,$data_user_id, $role);
            $jwt_refresh = $jwthelper->createJWTRefresh($issuer_claim,$audience_claim,$data_complete_name,$data_mail,$data_user_id, $role);
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
