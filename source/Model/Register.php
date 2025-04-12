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

    public function updateValidationCode($id, $code) {
        $updateStatement = $this->SQL->prepare('
            UPDATE 
                lojas 
            SET 
                loja_codigo_validacao = :code,
                loja_email_validado = 0,
                loja_envio_validacao = NOW()
            WHERE 
                loja_id = :id
        ');
        $updateStatement->bindParam(':code', $code, PDO::PARAM_STR);
        $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $updateStatement->execute();
    }

    public function validateCode($id, $code) {
        $codeStatement = $this->SQL->prepare('
            SELECT
                COUNT(*) qtd
            FROM
                lojas 
            WHERE
                loja_id = :id 
            AND 
                loja_codigo_validacao = :code
        ');
        $codeStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $codeStatement->bindParam(':code', $code, PDO::PARAM_STR);
        $codeStatement->execute();
        $result = $codeStatement->fetch();
        return $result['qtd'] == 1;
    }
    
    public function updateEmailValidationStatus($id) {
        $updateStatement = $this->SQL->prepare('
            UPDATE 
                lojas 
            SET 
                loja_email_validado = 1,
                loja_codigo_validacao = NULL,
                loja_envio_validacao = NULL
            WHERE 
                loja_id = :id
        ');
        $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $updateStatement->execute();
    }

}