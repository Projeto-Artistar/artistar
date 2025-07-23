<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Exception;
use Source\Core\Core;
use Source\Model\Reset;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class resetController extends Core {

    public function home() {
        echo $this->view->render("password-reset/home", [
            'title' =>  'Esqueci minha senha - Artistar', 
        ]);
        return;
    }

    public function sendEmail($post) {
        try { 
            $model = new Reset();
            $userFound = $model->searchEmail($post['email']);
            if (empty($userFound)) exit($this->renderApiResponse(404, 'E-mail not found'));
            $validationCode = $this->generateValidationCode(8);
            $this->setUserPasswordChange($userFound['id']);
            $model->updateValidationCode($userFound['id'], $validationCode);
            $this->sendValidationEmail($userFound['email'], $validationCode);
            exit($this->renderApiResponse(200, 'Code sent successfully'));
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, $e->getMessage()));
        }
    }

    public function code() {
        if (empty($this->getUserPasswordChange())) {
            header("location: /password-reset");
            return;
        }
        echo $this->view->render("password-reset/code", [
            'title' =>  'Confirmar código - Artistar', 
        ]);
        return;
    }

    public function validateCode($post) {
        try {
            $model = new Reset();
            $userId = $this->getUserPasswordChange();
            if ($model->validateCode($userId, $post['code'])) {
                $model->updateEmailValidationStatus($userId);
                $this->unsetUserPasswordChange();
                $this->setUserLogonStatus($userId);
                exit($this->renderApiResponse(200, 'Code validated successfully'));
            } else {
                exit($this->renderApiResponse(404, 'Invalid code'));
            }
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, $e->getMessage()));
        }
    }

    // Helpers
    public function sendValidationEmail($email, $validationCode) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            //Use credentials
            $mail->Username = "leo.caselato@gmail.com";
            $mail->Password = "lees awqi ahom efgz";
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->setFrom("leo.caselato@gmail.com");
            
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

    public function unsetUserPasswordChange() {
        unset($_SESSION['artistar']['password_change']);
    }

    public function setUserPasswordChange($id) {
        $_SESSION['artistar']['password_change'] = $id;
    }

    public function getUserPasswordChange() {
        return $_SESSION['artistar']['password_change'] ?? null;
    }

}
