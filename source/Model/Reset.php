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
                usuario_id id,
                usuario_nome_completo nome,
                usuario_email email
            FROM
                usuarios 
            WHERE
                usuario_email = :sentEmail
        ');
        $emailStatement->bindParam(':sentEmail', $email, PDO::PARAM_STR);
        $emailStatement->execute();
        $result = $emailStatement->fetch();
        return $result;
    }

    public function updateValidationCode($id, $code) {
        $updateStatement = $this->SQL->prepare('
            UPDATE 
                usuarios 
            SET 
                usuario_codigo_validacao = :code,
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
                usuario_codigo_validacao = NULL,
                usuario_envio_validacao = NULL
            WHERE 
                usuario_id = :id
        ');
        $updateStatement->bindParam(':id', $id, PDO::PARAM_INT);
        return $updateStatement->execute();
    }

}