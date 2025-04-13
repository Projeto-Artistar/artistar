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
            if (!$model->verifyIfEmailIsAvaliable($post['email'])) exit($this->renderApiResponse(404, 'E-mail already in use'));
            $storeId = $model->insertStore($post['user'], $post['email'], $post['password']);
            $this->setUserLogonStatus($storeId);
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
                $model->updateValidationCode($this->getUser()['id'], $validationCode);
                $this->sendValidationEmail($this->getUser()['email'], $validationCode);
            }
        }
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar', 
            'footer' => $this->footer(),
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
            //Use credentials
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Confirmação de Email - Artistar';

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
