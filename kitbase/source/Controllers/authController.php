<?php



namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Auth;
use Firebase\JWT\JWT;

class authController extends Core
{

    public function carregaLogin(){ echo $this->view->render("login"); }

    public function verificaDados($dados)
    {

        if( !isset($dados["senha"]) || !isset($dados["usuario"]) ){
            echo json_encode(array( "msg"=> "Parece que você esquece de preencher algum campo!"));
            return;
        }else{
            if( empty($dados["senha"]) || empty($dados["usuario"]) ){
                echo json_encode(array( "msg"=> "Preencha todos os campos para continuar!"));
                return;
            }

            $authLogin = new Auth();

            $statusLogin = $authLogin->verificaLogin($dados["usuario"], $dados["senha"]);

            if(gettype($statusLogin["data"]) == "string"){
                echo json_encode(array( "msg"=> $statusLogin["data"]));
                return;
            }else{
            //GERA O TOKEN

                //PAYLOAD
                $payload = [
                    'name' => $statusLogin["data"][0]["nm_usuario"],
                    'email' => $statusLogin["data"][0]["cd_email"],
                    'hash' => base64_encode(time())
                ];

                $token = JWT::encode($payload, KEY, 'HS256');

                setcookie("backsite-token", $token, time()+ (10 * 365 * 24 * 60 * 60), "/");

                echo json_encode(array(
                    'token' => $token
                ));

                return;
            }

        }


    }

}
