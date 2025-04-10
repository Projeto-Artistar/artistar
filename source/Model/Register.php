<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Register extends Core
{
    public function verifyIfEmailIsAvaliable($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $emailStatement = $this->SQL->prepare('
            SELECT
                COUNT(*) qtd
            FROM
                lojas 
            WHERE
                loja_login_email = :sentEmail
        ');
        $emailStatement->bindParam(':sentEmail', $email, PDO::PARAM_STR);
        $emailStatement->execute();
        $result = $emailStatement->fetch();
        return $result['qtd'] == 0;
    }

    public function insertStore($user, $email, $password) {
  
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = md5($password);

        $storeStatement = $this->SQL->prepare('
            INSERT INTO lojas 
                (loja_nome, loja_login_email, loja_login_senha)
            VALUES 
                (:user, :email, :password)
        ');

        $storeStatement->bindParam(':user', $user, PDO::PARAM_STR);
        $storeStatement->bindParam(':email', $email, PDO::PARAM_STR);
        $storeStatement->bindParam(':password', $password, PDO::PARAM_STR);

        $storeStatement->execute();

        return $this->SQL->lastInsertId();

    }

}