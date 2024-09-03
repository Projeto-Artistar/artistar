<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Auth extends Core
{

    public function __construct()
    {
        global $db;
        $this->db=$db;
    }

    public function verificaLogin($usuario, $senha){

        try {
            $query = $this->db->prepare(" 
                select nm_usuario, cd_email, cd_cnpj 
                    from  usuario 
                        where cd_senha = AES_ENCRYPT(:senha, 'chave_teste_aqui') 
                            and cd_cnpj = :usuario;            
            ");
            $query->execute(array(
                ':usuario' => $usuario,
                ':senha' => $senha
            ));

            if ($query->rowCount() > 0) {
                return array("Erro" => false, "data" => $query->fetchall(PDO::FETCH_ASSOC));
            } else {
                return array("Erro" => true, "data" =>"Usuário não econtrado");
            }
        } catch (PDOException $e) {
            echo 'Erro na verificação do login: ' . $e->getMessage();
        }
    }

    public function salvaProduto($prodt,$descpd,$pathpd,$preco,$descparce,$categ)
    {
        try {
            $query = $this->db->prepare("
                    INSERT INTO produto (nm_produto, vl_preco, nm_parcelado, desc_produto, path_produto, cd_categoria)
                    VALUES (:prodt, :preco, :descparce, :descpd, :pathpd, :categ)
            ");

            $query->execute(array(
                ':prodt' => $prodt,
                ':preco' => $preco,
                ':descparce' => $descparce,
                ':descpd' => $descpd,
                ':pathpd' => $pathpd,
                ':categ' => $categ
            ));

            if ($query->rowCount() > 0) {
                return array("noErro" => true, "data" => "Produto cadastrado com sucesso!");
            } else {
                return array("noErro" => false, "data" => "");
            }
        } catch (PDOException $e) {
            echo 'Erro ao salvar produto: ' . $e->getMessage();
        }

    }

}