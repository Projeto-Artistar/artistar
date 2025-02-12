<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Auth extends Core {

    public function __construct() {
        //apenas para exemplificar a conexão com o banco de dados
    }

    public function login($post) {
        $_SESSION['artistar']['logado'] = true;
        return true;
    }

}