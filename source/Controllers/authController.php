<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Auth;

class authController extends Core {

    public function login($post) {
        $auth = new Auth();
        
        $user = $auth->searchUser($post['email'], $post['password']);
        if ($user) {
            $this->setUserLogonStatus($user);
            exit($this->renderApiResponse(200, 'User found!'));
        } else {
            exit($this->renderApiResponse(404, 'User not found!'));
        }
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }


}
