<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Store extends Core {

    public function getStoreData($storeId) {
        $isNumeric = is_numeric($storeId);
        $select = $this->SQL->prepare(
            'SELECT
                loja.loja_id codigo,
                loja.loja_nome nome,
                loja.loja_nome_unico nome_unico,
                loja.loja_descricao descricao,
                loja.loja_foto foto
            FROM
                lojas loja
            WHERE
                loja.loja_id = :storeId'
        );

        $storeId = (int) $storeId;
        $select->bindParam(':storeId', $storeId, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function getPublicProducts($storeId, $search = '', $limit = 24) {
        $query = '
            SELECT
                produto_id id,
                produto_nome nome,
                produto_thumbnail thumbnail,
                produto_valor valor,
                produto_valor_desconto valor_desconto
            FROM
                produtos
            WHERE
                produto_loja = :storeId
            AND
                produto_ativo = 1
        ';

        if (!empty($search)) {
            $query .= '
                AND (
                    produto_nome LIKE :search
                    OR produto_descricao LIKE :search
                    OR produto_palavras_chave LIKE :search
                )
            ';
        }

        $query .= '
            ORDER BY produto_id DESC
            LIMIT :limit
        ';

        $select = $this->SQL->prepare($query);
        $storeId = (int) $storeId;
        $select->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $select->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }
        $limit = (int) $limit;
        $select->bindParam(':limit', $limit, PDO::PARAM_INT);
        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }
}