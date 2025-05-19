<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Exception;
use Source\Core\Core;
use Source\Model\Register;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class registerController extends Core {

    // Controller functions
    public function home() {
        echo $this->view->render("register/home", [
            'title' =>  'Cadastro - Artistar', 
        ]);
        return;
    }

    public function insertStore($post) {
        try { 
            $model = new Register();
            $qtd = $model->verifyIfEmailAndUsernameAreValid($post['email'], $post['user']);
            $errors = [];
            if ($qtd['qtd_storeUsername'] > 0) $errors[] = [
                'field' => 'username', 
                'message' => 'Username already in use by a store'
            ];

            if ($qtd['qtd_userUsername'] > 0) $errors[] = [
                'field' => 'username', 
                'message' => 'Username already in use by a user'
            ];

            if ($qtd['qtd_userEmail'] > 0) $errors[] = [
                'field' => 'email', 
                'message' => 'E-mail already in use by a user'
            ];

            if (strlen($post['user']) < 3) $errors[] = [
                'field' => 'username', 
                'message' => 'Username must be at least 3 characters long'
            ];

            if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) $errors[] = [
                'field' => 'email', 
                'message' => 'Invalid email format'
            ];

            if (!empty($errors)) exit($this->renderApiResponse(403, 'Validation failed', $errors));

            $userId = $model->insertUser($post['user'], $post['complete_user'], $post['email'], $post['password']);
            if (!$userId) exit($this->renderApiResponse(500, 'Failed to insert user'));
            $storeId = $model->insertStore($post['user'], $post['complete_user'], $userId);
            if (!$storeId) {
                $model->deleteUser($userId);
                exit($this->renderApiResponse(500, 'Failed to insert store'));
            }
            
            $this->setUserLogonStatus($userId);

            exit($this->renderApiResponse(200, 'Store inserted successfully'));
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, $e->getMessage()));
        }
    }

    public function validate() {
        $this->validaAcesso(false);
        if ($this->getUser()['email_validado'] == 1) {
            header("location: /");
            return;
        } else {
            $createdAt = strtotime($this->getUser()['envio_validacao']);
            $now = strtotime(date("Y-m-d H:i:s"));
            $diff = ($now - $createdAt) / 3600;
            if ($diff > 1) {
                $validationCode = $this->generateValidationCode(8);
                $model = new Register();
                if ($this->sendValidationEmail($this->getUser()['email'], $validationCode))
                    $model->updateValidationCode($this->getUser()['id'], $validationCode);
            }
        }
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar',
        ]);
        return;
    }

    public function validateCode($post) {
        $model = new Register();
        if ($model->validateCode($this->getUser()['id'], $post['code'])) {
            $model->updateEmailValidationStatus($this->getUser()['id']);
            exit($this->renderApiResponse(200, 'Email validated successfully'));
        } else {
            exit($this->renderApiResponse(404, 'Invalid code'));
        }
    }

    // Helper functions
    public function sendValidationEmail($email, $validationCode) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Email - Artistar';
            //Use credentials

            //End of credentials
            $mail->addAddress($email);
            $halfValidationCode = ceil(strlen($validationCode) / 2);
            $validationCode = substr($validationCode, 0, $halfValidationCode) . '-' . substr($validationCode, $halfValidationCode);
            $mail->FromName = "Artistar";
            $mail->Body = 'Seu código de validação é: ' . $validationCode;
            $mail->AltBody = 'Seu código de validação é: ' . $validationCode;
            $mail->send();
            return true;
        } catch (PHPMailerException $e) {
            return false;
        }
    }

}
