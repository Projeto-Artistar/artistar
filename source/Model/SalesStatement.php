<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class SalesStatement extends Core {

    public function buildWhereSales($filter = []) {
        $where = "";
        return $where;
    }

    public function getOrderList($sort) {
        $orderList = [
            'venda_desc' => [
                'label' => 'Venda (Maior para Menor)',
                'value' => 'numero DESC, data_criacao DESC'
            ],
            'venda_asc' => [
                'label' => 'Venda (Menor para Maior)',
                'value' => 'numero ASC, data_criacao ASC'
            ],
            'data_asc' => [
                'label' => 'Data da Venda (Mais Antiga para Mais Recente)',
                'value' => 'venda_data_venda ASC, numero ASC'
            ],
            'data_desc' => [
                'label' => 'Data da Venda (Mais Recente para Mais Antiga)',
                'value' => 'venda_data_venda DESC, numero DESC'
            ],
            'payment_asc' => [
                'label' => 'Método de Pagamento (A-Z)',
                'value' => 'pagamento ASC, data_criacao ASC'
            ],
            'payment_desc' => [
                'label' => 'Método de Pagamento (Z-A)',
                'value' => 'pagamento DESC, data_criacao DESC'
            ],
            'products_desc' => [
                'label' => 'Produtos (Maior para Menor)',
                'value' => 'total_itens DESC, data_criacao DESC'
            ],
            'products_asc' => [
                'label' => 'Produtos (Menor para Maior)',
                'value' => 'total_itens ASC, data_criacao ASC'
            ],
            'qtd_desc' => [
                'label' => 'Unidades (Maior para Menor)',
                'value' => 'total_unidades DESC, data_criacao DESC'
            ],
            'qtd_asc' => [
                'label' => 'Unidades (Menor para Maior)',
                'value' => 'total_unidades ASC, data_criacao ASC'
            ],
            'value_desc' => [
                'label' => 'Valor (Maior para Menor)',
                'value' => 'total_valor DESC, data_criacao DESC'
            ],
            'value_asc' => [
                'label' => 'Valor (Menor para Maior)',
                'value' => 'total_valor ASC, data_criacao ASC'
            ],
            'discount_desc' => [
                'label' => 'Desconto (Maior para Menor)',
                'value' => 'total_desconto DESC, data_criacao DESC'
            ],
            'discount_asc' => [
                'label' => 'Desconto (Menor para Maior)',
                'value' => 'total_desconto ASC, data_criacao ASC'
            ]
        ];

        foreach($orderList as $key => $value) {
            if ($key === $sort) {
                $orderList[$key]['selected'] = true;
            } else {
                $orderList[$key]['selected'] = false;
            }
        }
        return $orderList;
    }

    public function buildOrderBy($orderList, $order = 'venda_desc') {
        $orderBy = 'numero DESC';
        if (isset($orderList[$order])) {
            $orderBy = $orderList[$order]['value'];
        }
        return $orderBy;
    }

    public function getSales($store, $pagination = [], $where = '', $order = '') {
        $stmt = $this->SQL->prepare("
            SELECT 
                v.venda_id id,
                v.venda_numero numero,
                v.venda_pagamento pagamento,
                DATE_FORMAT(v.venda_data_criacao, '%d/%m/%Y %H:%i') data_criacao,
                DATE_FORMAT(v.venda_data_venda, '%d/%m/%Y %H:%i') data_venda,
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
                v.venda_loja_id = :store
            {$where}
            GROUP BY
                v.venda_id
            ORDER BY
                {$order}
            LIMIT :offset, :limit
        ");
        $stmt->bindValue(":store", $store);
        $stmt->bindValue(":offset", (int) $pagination['offset'], PDO::PARAM_INT);
        $stmt->bindValue(":limit", (int) $pagination['limit'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSales($store, $pagination = [], $where = '') { 
        $stmt = $this->SQL->prepare("
            SELECT
                COUNT(v.venda_id) AS total_sales,
                COUNT(IF(v.venda_cancelada = 1, 1, NULL)) AS total_canceled
            FROM
                vendas AS v
            WHERE
                v.venda_loja_id = :store
            {$where}
        ");
        $stmt->bindValue(":store", $store);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function getProducts($storeId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                produto_id id,
                produto_nome nome,
                produto_palavras_chave palavra_chave,
                produto_descricao descricao,
                produto_codigo_interno subtitulo,
                produto_valor preco,
                produto_valor_desconto desconto,
                produto_estoque estoque,
                produto_thumbnail imagem
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

    public function getSaleById($saleId, $storeId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                v.venda_id id,
                v.venda_numero numero,
                v.venda_pagamento pagamento,
                DATE_FORMAT(v.venda_data_criacao, '%d/%m/%Y') data_criacao,
                DATE_FORMAT(v.venda_data_criacao, '%H:%i') hora_criacao,
                v.venda_pago pago,
                v.venda_data_pagamento data_pagamento,
                v.venda_entregue entregue,
                v.venda_data_entrega data_entrega,
                v.venda_data_venda data_venda,
                v.venda_cancelada cancelada,
                v.venda_data_cancelamento data_cancelamento
            FROM
                vendas AS v
            WHERE
                v.venda_id = :sale_id
            AND
                v.venda_loja_id = :store_id
            LIMIT 1
        ");
        $stmt->bindValue(":sale_id", $saleId, PDO::PARAM_INT);
        $stmt->bindValue(":store_id", $storeId, PDO::PARAM_INT);
        $stmt->execute();
        $sale = $stmt->fetch(PDO::FETCH_ASSOC);
        return $sale ? $sale : null;
    }

    public function getSaleItems($saleId) {
        $stmt = $this->SQL->prepare("
            SELECT
                vi.venda_item_id id,
                vi.venda_item_venda id_venda,
                p.produto_id id_produto,
                p.produto_nome nome,
                p.produto_codigo_interno codigo_interno,
                p.produto_thumbnail thumbnail,
                vi.venda_item_unidades qtd,
                p.produto_valor preco,
                (p.produto_estoque + vi.venda_item_unidades) estoque,
                vi.venda_item_desconto desconto,
                vi.venda_item_valor valor
            FROM
                vendas_itens AS vi
            LEFT JOIN
                produtos AS p ON p.produto_id = vi.venda_item_produto
            WHERE
                vi.venda_item_venda = :sale_id
            ORDER BY
                p.produto_nome ASC
        ");

        $stmt->bindValue(":sale_id", $saleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInfoBanner($store, $where = '') {
        $stmt = $this->SQL->prepare("
            SELECT
                SUM(vi.venda_item_valor) AS total_value,
                COUNT(DISTINCT vi.venda_item_produto) AS total_products,
                SUM(vi.venda_item_unidades) AS total_items
            FROM
                vendas_itens AS vi
            INNER JOIN
                vendas AS v ON v.venda_id = vi.venda_item_venda
            WHERE
                v.venda_loja_id = :store_id
            AND
                COALESCE(v.venda_cancelada, 0) = 0
        ");
        $stmt->bindValue(":store_id", $store, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}