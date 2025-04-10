<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Exception;
use Source\Core\Core;
use Source\Model\Register;

class registerController extends Core {

    public function home() {
        echo $this->view->render("register/home", [
            'title' =>  'Cadastro - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function insertStore($post) {
        $model = new Register();

        try { 
            $emailIsAvaliable = $model->verifyIfEmailIsAvaliable($post['email']);
        } catch (Exception $e) {
            exit(json_encode([
                'code' => 500,
                'message' => $e->getMessage(),
            ]));
        }

        if ($emailIsAvaliable) {
            try { 
                $storeId = $model->insertStore($post['user'], $post['email'], $post['password']);
                exit(json_encode([
                    'code' => 200,
                    'message' => 'Store inserted successfully',
                ]));
            } catch (Exception $e) {
                exit(json_encode([
                    'code' => 500,
                    'message' => $e->getMessage(),
                ]));
            }
        } else {
            exit(json_encode([
                'code' => 404,
                'message' => 'E-mail already in use',
            ]));
        }

    }

    public function validate() {
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

}
