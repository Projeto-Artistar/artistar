<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Sales extends Core {

    public function getProducts($storeId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                produto_id id,
                produto_nome nome,
                produto_codigo_interno subtitulo,
                produto_valor preco,
                produto_valor_desconto desconto,
                IF(produto_thumbnail != '', produto_thumbnail, 'assets/image/200x300.png') imagem
            FROM 
                produtos
            WHERE 
                produto_loja = :loja_id
            AND
                produto_ativo = 1
            ORDER BY 
                nome ASC
        ");
        $stmt->bindValue(":loja_id", $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}