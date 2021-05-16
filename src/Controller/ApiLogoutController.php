<?php

namespace App\Controller;

use Exception;
use Firebase\JWT\JWT;
use App\Repository\JwtRefreshRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiLogoutController extends AbstractController
{
    #[Route('/api/logout', name: 'api_logout', methods:['POST'])]
    public function index(Request $request, JwtRefreshRepository $jwtRefreshRepository, EntityManagerInterface $em): Response
    {
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $request = $this->transformJsonBody($request);

        if (!$request || !$request->get('jwt_refresh')){
            return $this->json([
                "status" => 400,
                "message" => "erreur requete"
            ],400);
        }

        try{
            $refresh = $request->get('jwt_refresh');
            $refresh_decode = JWT::decode($refresh,$this->getParameter('jwt_refresh_secret'),['HS256']);
            $refresh_id = $refresh_decode->data->id;

            if($user_id !== $refresh_id){
                return $this->json([
                    "status" => 400,
                    "message" => "Access denied"
                ],401);
            }

            $jwtrefresh_target = $jwtRefreshRepository->findOneBy(array('user' => $user_id, "jwtrefresh_value" => $refresh));

            if(!$jwtrefresh_target){
                return $this->json([
                    "status" => 400,
                    "message" => "refresh empty"
                ],400);
            }

            $em->remove($jwtrefresh_target);
            $em->flush();

            return $this->json([
                "status" => 200,
                "message" => "Déconnexion réussie"
            ],200);

        }catch(Exception $e){
            return $this->json([
                "status" => 400,
                "message" => "Access denied"
            ],401);
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
