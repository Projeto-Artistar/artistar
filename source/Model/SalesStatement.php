<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class SalesStatement extends Core {

    public function buildWhereSales($filter = []) {
        $where = [];
        if (isset($filter['event'])) $where[] = "COALESCE(v.venda_evento_id, 0) = " . (int)$filter['event'] . " ";
        return !empty($where) ? " AND " . implode("\nAND\n", $where) : "";
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
                e.evento_nome evento_nome,
                COUNT(vi.venda_item_id) AS total_itens,
                SUM(vi.venda_item_unidades) AS total_unidades,
                SUM(vi.venda_item_desconto) AS total_desconto,
                SUM(vi.venda_item_valor) AS total_valor
            FROM
                vendas AS v
            LEFT JOIN
                eventos AS e ON e.evento_id = v.venda_evento_id
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
                v.venda_data_cancelamento data_cancelamento,
                e.evento_id evento_id
            FROM
                vendas AS v
            LEFT JOIN
                eventos AS e ON e.evento_id = v.venda_evento_id
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

    public function getProductsWithSales($saleId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                p.produto_id id,
                p.produto_nome nome,
                p.produto_palavras_chave palavra_chave,
                p.produto_descricao descricao,
                p.produto_codigo_interno subtitulo,
                p.produto_valor preco_produto,
                p.produto_valor_desconto desconto_produto,
                p.produto_estoque estoque_produto,
                p.produto_thumbnail imagem,
                vi.venda_item_id id_venda_item,
                vi.venda_item_unidades qtd_vendida,
                vi.venda_item_desconto desconto_venda,
                vi.venda_item_valor valor_venda
            FROM 
                produtos AS p
            INNER JOIN
                vendas AS v ON v.venda_id = :sale_id
            LEFT JOIN
                vendas_itens AS vi ON vi.venda_item_produto = p.produto_id AND vi.venda_item_venda = v.venda_id
            WHERE
                v.venda_loja_id = p.produto_loja
            AND
                (
                        p.produto_ativo = 1
                    OR
                        vi.venda_item_id IS NOT NULL
                )
            GROUP BY
                p.produto_id
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
            {$where}
        ");
        $stmt->bindValue(":store_id", $store, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSalesProducts($saleId) {
        $stmt = $this->SQL->prepare("
            SELECT 
                vi.venda_item_id id,
                vi.venda_item_produto id_produto,
                vi.venda_item_venda id_venda,
                vi.venda_item_unidades qtd,
                vi.venda_item_desconto desconto,
                vi.venda_item_valor valor
            FROM
                vendas_itens AS vi
            WHERE
                vi.venda_item_venda = :sale_id
            GROUP BY
                vi.venda_item_id
        ");
        $stmt->bindValue(":sale_id", $saleId, PDO::PARAM_INT);
        $stmt->execute();
        //Trazer todos os itens, com o id_produto como chave do array
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $itemsByProductId = [];
        foreach ($items as $item) $itemsByProductId[$item['id_produto']] = $item;
        return $itemsByProductId;
    }

    public function updateSaleInfo($saleId, $data) {
        $stmt = $this->SQL->prepare("
            UPDATE 
                vendas
            SET
                venda_pagamento = :payment_method,
                venda_data_venda = :sale_datetime,
                venda_pago = :paid,
                venda_data_pagamento = :payment_date,
                venda_entregue = :delivered,
                venda_data_entrega = :delivery_date,
                venda_cancelada = :canceled,
                venda_data_cancelamento = :cancellation_date,
                venda_evento_id = :event_id
            WHERE
                venda_id = :sale_id
        ");
        $stmt->bindValue(":payment_method", $data['payment_method'], PDO::PARAM_STR);
        if (empty($data['sale_datetime'])) {
            $stmt->bindValue(":sale_datetime", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":sale_datetime", $data['sale_datetime'], PDO::PARAM_STR);
        }
        $stmt->bindValue(":paid", $data['paid'], PDO::PARAM_INT);
        if (empty($data['payment_date'])) {
            $stmt->bindValue(":payment_date", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":payment_date", $data['payment_date'], PDO::PARAM_STR);
        }
        $stmt->bindValue(":delivered", $data['delivered'], PDO::PARAM_INT);
        if (empty($data['delivery_date'])) {
            $stmt->bindValue(":delivery_date", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":delivery_date", $data['delivery_date'], PDO::PARAM_STR);
        }
        $stmt->bindValue(":canceled", $data['canceled'], PDO::PARAM_INT);
        if (empty($data['cancellation_date'])) {
            $stmt->bindValue(":cancellation_date", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":cancellation_date", $data['cancellation_date'], PDO::PARAM_STR);
        }
        if (empty($data['event'])) {
            $stmt->bindValue(":event_id", null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(":event_id", $data['event'], PDO::PARAM_INT);
        }
        $stmt->bindValue(":sale_id", $saleId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateItem($id, $data) {
        $stmt = $this->SQL->prepare("
            UPDATE 
                vendas_itens
            SET
                venda_item_unidades = :qtd,
                venda_item_desconto = :desconto,
                venda_item_valor = :valor,
                venda_item_data_ultima_atualizacao = NOW()
            WHERE
                venda_item_id = :id
        ");
        $stmt->bindValue(":qtd", $data['qtd'], PDO::PARAM_INT);
        $data['total_price'] = str_replace(',', '.', str_replace('.', '', $data['total_price']));
        $data['discount'] = str_replace(',', '.', str_replace('.', '', $data['discount']));
        $stmt->bindValue(":desconto", $data['discount'], PDO::PARAM_STR);
        $stmt->bindValue(":valor", $data['total_price'], PDO::PARAM_STR);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function insertItem($saleId, $data) {
        $stmt = $this->SQL->prepare("
            INSERT INTO 
                vendas_itens (
                    venda_item_produto,
                    venda_item_venda,
                    venda_item_unidades,
                    venda_item_desconto,
                    venda_item_valor,
                    venda_item_data_criacao,
                    venda_item_data_ultima_atualizacao
                ) VALUES (
                    :produto_id,
                    :venda_id,
                    :qtd,
                    :desconto,
                    :valor,
                    NOW(),
                    NOW()
                )
        ");
        $stmt->bindValue(":produto_id", $data['id'], PDO::PARAM_INT);
        $stmt->bindValue(":venda_id", $saleId, PDO::PARAM_INT);
        $stmt->bindValue(":qtd", $data['qtd'], PDO::PARAM_INT);
        $data['total_price'] = str_replace(',', '.', str_replace('.', '', $data['total_price']));
        $data['discount'] = str_replace(',', '.', str_replace('.', '', $data['discount']));
        $stmt->bindValue(":desconto", $data['discount'], PDO::PARAM_STR);
        $stmt->bindValue(":valor", $data['total_price'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteItem($id) {
        $stmt = $this->SQL->prepare("
            DELETE FROM 
                vendas_itens
            WHERE
                venda_item_id = :id
        ");
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getStoreSubscriptions($storeId) {
        $stmt = $this->SQL->prepare("
            SELECT
                e.evento_id,
                e.evento_nome
            FROM
                inscricoes i
            INNER JOIN
                eventos AS e ON e.evento_id = i.inscricao_evento
            WHERE
                i.inscricao_loja = :store_id
            ORDER BY
                e.evento_data_final DESC
        ");
        $stmt->bindValue(":store_id", $storeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}