<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Exception;
use Source\Core\Core;
use Source\Model\Auth;

class authController extends Core {

    public function login($post) {
        $auth = new Auth();
        $user = $auth->searchUser($post['email'], $post['password']);
        if (!$user) exit($this->renderApiResponse(404, 'User not found!'));
        $this->setUserLogonStatus($user);
        exit($this->renderApiResponse(200, 'User found!'));
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }

    public function newPassword() {
        $this->validaAcesso();
        echo $this->view->render("new-password", [
            'title' =>  'Redefinir senha - Artistar', 
            'header' => $this->header(),
            'footer' => $this->footer(),
        ]);
        return;
    }

    public function changePassword($post) {
        $userId = $this->getUser()['id'];
        if (empty($userId)) exit($this->renderApiResponse(404, 'User not found'));
        try {
            $model = new Auth();
            if($model->changePassword($userId, $post['password'])) exit($this->renderApiResponse(200, 'Password changed successfully'));
            exit($this->renderApiResponse(404, 'Error changing password'));
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, $e->getMessage()));
        }
    }


}
