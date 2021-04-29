<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Doctor;
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
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,  ValidatorInterface $validator): Response
    {
        $jsonRecu = $request->getContent();
        try{
            $user =  $serializer->deserialize($jsonRecu, User::class, 'json');
            $pass = $user->getPassword();
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $user->setPassword($pass);
            $user->setRoles(["ROLE_DOCTOR"]);

            $doctor =  $serializer->deserialize($jsonRecu, Doctor::class, 'json');
            $doctor->setUserId($user);

            $errors = $validator->validate($user);
            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $em->persist($user);
            $em->persist($doctor);
            $em->flush();
            return $this->json([
                'status' => 200,
                'message' => 'Création du compte réussie'
            ], 400);
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
