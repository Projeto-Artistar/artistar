<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Register extends Core {

    public function verifyIfEmailAndUsernameAreValid($email, $username) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        $qtdStatement = $this->SQL->prepare('
            SELECT 
                (
                    SELECT
                        COUNT(*) qtd
                    FROM
                        lojas 
                    WHERE
                        loja_nome_unico = :username
                ) AS qtd_storeUsername,
                (
                    SELECT
                        COUNT(*) qtd
                    FROM
                        usuarios 
                    WHERE
                        usuario_nome = :username
                ) AS qtd_userUsername,
                (
                    SELECT
                        COUNT(*) qtd
                    FROM
                        usuarios 
                    WHERE
                        usuario_email = :useremail
                ) AS qtd_userEmail     
        ');

        $qtdStatement->bindParam(':useremail', $email, PDO::PARAM_STR);
        $qtdStatement->bindParam(':username', $username, PDO::PARAM_STR);
        $qtdStatement->execute();
        return $qtdStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($user, $complete_user, $email, $password) {
  
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = md5($password);
          
        $storeStatement = $this->SQL->prepare('
            INSERT INTO usuarios
                (usuario_nome, usuario_nome_completo, usuario_senha, usuario_email)
            VALUES 
                (:user, :complete_user, :password, :email)
        ');

        $storeStatement->bindParam(':user', $user, PDO::PARAM_STR);
        $storeStatement->bindParam(':complete_user', $complete_user, PDO::PARAM_STR);
        $storeStatement->bindParam(':email', $email, PDO::PARAM_STR);
        $storeStatement->bindParam(':password', $password, PDO::PARAM_STR);

        $storeStatement->execute();

        return $this->SQL->lastInsertId();

    }

    public function deleteUser($user_id) {
        $deleteStatement = $this->SQL->prepare('
            DELETE FROM 
                usuarios 
            WHERE 
                usuario_id = :id
        ');
        $deleteStatement->bindParam(':id', $user_id, PDO::PARAM_INT);
        return $deleteStatement->execute();
    }

    public function insertStore($user, $complete_user, $user_id) {
          
        $storeStatement = $this->SQL->prepare('
            INSERT INTO lojas 
                (loja_nome_unico, loja_nome, loja_proprietario)
            VALUES 
                (:user, :complete_user, :id_user)
        ');

        $storeStatement->bindParam(':user', $user, PDO::PARAM_STR);
        $storeStatement->bindParam(':complete_user', $complete_user, PDO::PARAM_STR);
        $storeStatement->bindParam(':id_user', $user_id, PDO::PARAM_INT);
        
        $storeStatement->execute();

        return $this->SQL->lastInsertId();

    }

    public function updateValidationCode($id, $code) {
        $updateStatement = $this->SQL->prepare('
            UPDATE 
                usuarios
            SET 
                usuario_codigo_validacao = :code,
                usuario_email_validado = 0,
                usuario_envio_validacao = NOW()
            WHERE 
                usuario_id = :id
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
                usuarios 
            WHERE
                usuario_id = :id 
            AND 
                usuario_codigo_validacao = :code
            AND
                usuario_envio_validacao > NOW() - INTERVAL 1 HOUR
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
                usuarios
            SET 
                usuario_email_validado = 1,
                usuario_codigo_validacao = NULL,
                usuario_envio_validacao = NULL
            WHERE 
                usuario_id = :id
        ');
        $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $updateStatement->execute();
    }

}