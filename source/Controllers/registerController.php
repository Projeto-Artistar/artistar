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
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function insertStore($post) {
        try { 
            $model = new Register();
            if ($model->verifyIfEmailIsAvaliable($post['email'])) {
                $validationCode = $this->generateValidationCode(8);
                $storeId = $model->insertStore($post['user'], $post['email'], $post['password'], $validationCode);
                if($this->sendValidationEmail($post['email'], $validationCode)) {
                    $this->setUserLogonStatus($storeId);
                    exit($this->renderApiResponse(200, 'Store inserted successfully'));
                } else {
                    exit($this->renderApiResponse(500, 'Failed to send validation email'));
                }
            } else {
                exit($this->renderApiResponse(404, 'E-mail already in use'));
            }
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, $e->getMessage()));
        }
    }

    public function validate() {
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $this->footer(),
        ]);
        return;
    }

    // Helper functions
    public function sendValidationEmail($email, $validationCode) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            //Use credentials
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Email - Artistar';

            $halfValidationCode = ceil(count($validationCode) / 2);
            $validationCode = substr($validationCode, 0, $halfValidationCode) . '-' . substr($validationCode, $halfValidationCode);

            $mail->Body = 'Seu código de validação é: ' . $validationCode;
            $mail->AltBody = 'Seu código de validação é: ' . $validationCode;
            $mail->send();
            return true;
        } catch (PHPMailerException $e) {
            return false;
        }
    }

    public function setUserLogonStatus($userId) {
        $_SESSION['artistar']['logon'] = $userId;
    }
}
