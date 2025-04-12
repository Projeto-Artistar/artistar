<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Auth extends Core {

    public function searchUser($email, $password) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = md5($password);
        $userStatement = $this->SQL->prepare('
            SELECT
                loja_id
            FROM
                lojas 
            WHERE
                loja_login_email = :sentEmail 
            AND 
                loja_login_senha = :sentPassword
        ');
        $userStatement->bindParam(':sentEmail', $email, PDO::PARAM_STR);
        $userStatement->bindParam(':sentPassword', $password, PDO::PARAM_STR);
        $userStatement->execute();
        $result = $userStatement->fetch();
        return $result['loja_id'] ?? null;
    }

}