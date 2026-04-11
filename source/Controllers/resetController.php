<?php

namespace Source\Controllers;

use Exception;
use CoffeeCode\Router\Router;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Source\Core\Core;
use Source\Model\Reset;
use Source\Model\Helpers\ValidationCode;

class resetController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        $this->getLayout()->setFooter('footer');
        $this->addLayout();
    }

    public function home() {
        echo $this->view->render("password-reset/home", [
            'title' =>  'Esqueci minha senha - Artistar', 
            'redirect' => $this->getRedirect()
        ]);
        return;
    }

    public function sendEmail($post) {
        try { 
            $helper = new ValidationCode();
            $userFound = $helper->searchEmail($post['email']);
            if (empty($userFound)) exit($this->renderApiResponse(404, 'E-mail not found'));
            $validationCode = $helper->generateValidationCode(8);
            $this->setUserPasswordChange($userFound['id']);
            $helper->updateValidationCode($userFound['id'], $validationCode);
            $helper->sendValidationEmail($userFound['email'], $validationCode);
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
            'redirect' => $this->getRedirect()
        ]);
        return;
    }

    public function validateCode($post) {

        try {
            $model = new Reset();
            $helper = new ValidationCode();
            $userId = $this->getUserPasswordChange();
            if ($helper->validateCode($userId, $post['code'])) {
                $helper->updateEmailValidationStatus($userId);
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
