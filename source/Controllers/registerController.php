<?php

namespace Source\Controllers;

use Exception;
use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Register;
use Source\Model\Helpers\ValidationCode;

class registerController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        $this->getLayout()->setFooter('footer');
        $this->addLayout();
    }

    // Controller functions
    public function home() {

        echo $this->view->render("register/home", [
            'title' =>  'Cadastro - Artistar', 
            'redirect' => $this->getRedirect()
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
                $helper = new ValidationCode();
                $validationCode = $helper->generateValidationCode(8);
                if ($helper->sendValidationEmail($this->getUser()['email'], $validationCode))
                    $helper->updateValidationCode($this->getUser()['id'], $validationCode);
            }
        }
        echo $this->view->render("register/validate-email", [
            'title' =>  'Confirmação de Email - Artistar',
            'redirect' => $this->getRedirect()
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

    public function validateUser($post) {
        
        if (empty($post['user'])) exit($this->renderApiResponse(403, 'Sem nome de usuário inserido'));
        if (strlen($post['user']) < 3) exit($this->renderApiResponse(403, 'Nome de usuário deve ter pelo menos 3 caracteres'));
        $model = new Register();

        $username = $model->verifyIfEmailAndUsernameAreValid('', $post['user']);
        if ($username['qtd_storeUsername'] < 1 && $username['qtd_userUsername'] < 1) exit($this->renderApiResponse(200, 'Nome de usuário está disponível'));
        exit($this->renderApiResponse(404, 'Nome de usuário está indisponível'));

        return;
    }

    public function validateEmail($post) {

        if (empty($post['email'])) exit($this->renderApiResponse(403, 'Sem email inserido'));
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) exit($this->renderApiResponse(403, 'Email inválido'));
        $model = new Register();

        $email = $model->verifyIfEmailAndUsernameAreValid($post['email'], '');
        if ($email['qtd_userEmail'] < 1) exit($this->renderApiResponse(200, 'Email está disponível'));
        exit($this->renderApiResponse(404, 'Email está indisponível'));

        return;
    }

}
