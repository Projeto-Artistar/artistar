<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Reset extends Core
{
    public function searchEmail($email) {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $emailStatement = $this->SQL->prepare('
            SELECT
                loja_id id,
                loja_nome nome,
                loja_login_email email
            FROM
                lojas 
            WHERE
                loja_login_email = :sentEmail
        ');
        $emailStatement->bindParam(':sentEmail', $email, PDO::PARAM_STR);
        $emailStatement->execute();
        $result = $emailStatement->fetch();
        return $result;
    }

    public function updateValidationCode($id, $code) {
        $updateStatement = $this->SQL->prepare('
            UPDATE 
                lojas 
            SET 
                loja_codigo_validacao = :code,
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
            AND
                loja_envio_validacao > NOW() - INTERVAL 1 HOUR
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
                loja_codigo_validacao = NULL,
                loja_envio_validacao = NULL
            WHERE 
                loja_id = :id
        ');
        $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $updateStatement->execute();
    }

}