<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class SalesStatement extends Core {

    public function getSales($storeId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                v.venda_id id,
                v.venda_numero numero,
                v.venda_pagamento pagamento,
                DATE_FORMAT(v.venda_data_criacao, '%d/%m/%Y') data_criacao,
                DATE_FORMAT(v.venda_data_criacao, '%H:%i') hora_criacao,
                v.venda_pago pago,
                v.venda_entregue entregue,
                v.venda_cancelada cancelada,
                COUNT(vi.venda_item_id) AS total_itens,
                SUM(vi.venda_item_unidades) AS total_unidades,
                SUM(vi.venda_item_desconto) AS total_desconto,
                SUM(vi.venda_item_valor) AS total_valor
            FROM
                vendas AS v
            LEFT JOIN
                vendas_itens AS vi ON vi.venda_item_venda = v.venda_id
            WHERE
                v.venda_loja_id = :loja_id
            GROUP BY
                v.venda_id
            ORDER BY
                v.venda_data_criacao DESC
        ");
        $stmt->bindValue(":loja_id", $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItems($sales) {
        if (empty($sales)) {
            return [];
        }
        $sales = implode(',', array_map('intval', $sales));
        $stmt = $this->SQL->prepare("
            SELECT
                vi.venda_item_id id,
                vi.venda_item_venda id_venda,
                p.produto_id id_produto,
                p.produto_nome nome,
                p.produto_codigo_interno codigo_interno,
                p.produto_thumbnail thumbnail,
                vi.venda_item_unidades qtd,
                vi.venda_item_desconto desconto,
                vi.venda_item_valor valor
            FROM
                vendas_itens AS vi
            LEFT JOIN
                produtos AS p ON p.produto_id = vi.venda_item_produto
            WHERE
                vi.venda_item_venda IN ({$sales})
            GROUP BY
                vi.venda_item_id
            ORDER BY
                nome ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}