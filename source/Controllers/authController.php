<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Core;
use Source\Model\Auth;

class authController extends Core {

    public function login() {
        $auth = new Auth();
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $auth->login($post);
        header("location: /");
        return;
    }

    public function logout(){
        session_destroy();
        header("location: /");
    }


}
