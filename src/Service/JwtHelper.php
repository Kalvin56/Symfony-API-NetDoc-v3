<?php

namespace App\Service;

use \Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class JwtHelper{

    private $params;

    public function __construct(ContainerBagInterface $params)
    {
        $this->params = $params;
    }

    public function createJWT($issuer_claim,$audience_claim,$data_complete_name,$data_mail,$data_user_id, $role){
        $payload = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + $this->params->get('expire_jwt_secret'),
            "data" => array(
                "complete_name" => $data_complete_name,
                "mail" => $data_mail,
                "id" => $data_user_id,
                'role' => $role)
        );
        $jwt = JWT::encode($payload, $this->params->get('jwt_secret'), 'HS256');
        return $jwt;
    }

    public function createJWTRefresh($issuer_claim,$audience_claim,$data_complete_name,$data_mail,$data_user_id, $role){
        $payload = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + $this->params->get('expire_jwt_refresh_secret'),
            "data" => array(
                "complete_name" => $data_complete_name,
                "mail" => $data_mail,
                "id" => $data_user_id,
                'role' => $role)
        );
        $jwt_refresh = JWT::encode($payload, $this->params->get('jwt_refresh_secret'), 'HS256');
        return $jwt_refresh;
    }

}
?>