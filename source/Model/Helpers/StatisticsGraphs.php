<?php

namespace Source\Model\Helpers;

use Aws\S3\S3Client;

class StatisticsGraphs {

    private $storeId = NULL;
    private $graphTypes = [];
    private $graphData = [];
    private $timePeriod = NULL;

    public function __construct($storeId, $periodo) {
        $this->setDefaultGraphTypes($storeId);
        $this->setTimePeriod($periodo);
    }
      
    public function getGraphType($key) {
        return $this->graphTypes[$key] ?? null;
    }

    public function getAllGraphTypes() {
        return $this->graphTypes;
    }

    public function setGraphType($key, $value) {
        $this->graphTypes[$key] = $value;
    }

    public function unsetGraphType($key) {
        unset($this->graphTypes[$key]);
    }

    public function getTimePeriod() {
        return $this->timePeriod;
    }

    public function setTimePeriod($periodo) {
        $this->timePeriod = $periodo;
    }

    public function setDefaultGraphTypes($storeId) {
        $this->graphTypes = [
            1 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'pie',
                'grafico_contador' => 'sold_units',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ],
            2 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'bar',
                'grafico_contador' => 'sold_units',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ],
            3 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'line',
                'grafico_contador' => 'sold_units',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ],
            4 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'pie',
                'grafico_contador' => 'revenue',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ],
            5 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'bar',
                'grafico_contador' => 'revenue',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ],
            6 => [
                'grafico_loja' => $storeId,
                'grafico_tipo' => 'line',
                'grafico_contador' => 'revenue',
                'grafico_alvo' => 'product',
                'grafico_filtro' => 'top_10',
                'grafico_lista' => ''
            ]
        ];
    }

    public function getGraphData() {
        $data = [];
        foreach ($this->getAllGraphTypes() as $key => $graphType) {
            $info = [
                'item_store' => $graphType['grafico_loja'],
                'item_type' => $graphType['grafico_tipo'],
                'item_period' => $this->getItemTimePeriod($graphType['grafico_tipo']),
                'item_id' => $this->getItemId($graphType['grafico_alvo']),
                'item_name' => $this->getItemName($graphType['grafico_alvo']),
                'item_counter' => $this->getItemCounter($graphType['grafico_contador']),
                'item_extraJoins' => $this->getItemJoins($graphType['grafico_alvo']),
                'item_extraFilters' => $this->getItemFilters($graphType['grafico_filtro'], $graphType['grafico_alvo'], $graphType['grafico_lista']),
                'item_limit' => $graphType['grafico_filtro'] == 'top_10' ? 'LIMIT 10' : ''

            ];
            $data[$key] = [
                'id' => $key,
                'name' => $this->buildName($graphType),
                'type' => $graphType['grafico_tipo'],
                'real' => in_array($graphType['grafico_contador'], ['revenue', 'discount']),
                'data' => $this->buildQuery($info)
            ];
        }
        return $data;
    }

    public function buildName($graphType) {
        $nome = '';
        switch($graphType['grafico_tipo']) {
            case 'pie':
                $nome .= 'Distribuição ';
                break;
            case 'bar':
                $nome .= 'Total';
                break;
            case 'line':
                $nome .= 'Crescimento';
                break;
        }
        switch($graphType['grafico_contador']) {
            case 'sold_units':
                $nome .= ' das Unidades Vendidas';
                break;
            case 'revenue':
                $nome .= ' do Faturamento';
                break;
            case 'discount':
                $nome .= ' do Desconto';
                break;
        }
        switch($graphType['grafico_alvo']) {
            case 'product':
                $nome .= ' por Produto';
                break;
            case 'category':
                $nome .= ' por Categoria';
                break;
            case 'payment_method':
                $nome .= ' por Método de Pagamento';
                break;
        }
        switch($graphType['grafico_filtro']) {
            case 'all':
                $nome .= ' (Todos)';
                break;
            case 'top_10':
                $nome .= ' (Top 10)';
                break;
            case 'custom':
                $nome .= ' (Personalizado)';
                break;
        }
        return $nome;

    }

    public function getItemTimePeriod($type) {
        return $type == 'line' ? $this->getTimePeriod()['group_by'] : '';
    }

    public function getItemId($item) {
        $options = [
            'product' => 'produto_id',
            'category' => 'categoria_id',
            'payment_method' => 'venda_pagamento'
        ];
        if (!isset($options[$item])) return 'produto_id';
        return $options[$item];
    }

    public function getItemName($item) {
        $options = [
            'product' => 'produto_nome',
            'category' => 'categoria_nome',
            'payment_method' => 'venda_pagamento'
        ];
        if (!isset($options[$item])) return 'produto_nome';
        return $options[$item];
    }

    public function getItemCounter($item) {
        $options = [
            'sold_units' => 'venda_item_unidades',
            'revenue' => 'venda_item_valor',
            'discount' => 'venda_item_desconto'
        ];
        if (!isset($options[$item])) return 'venda_item_unidades';
        return $options[$item];
    }

    public function getItemJoins($item) {
        $options = [
            'category' => '
                    INNER JOIN 
                        categoria_produtos AS catprod ON p.produto_id = catprod.categoria_produto_produto 
                    INNER JOIN 
                        categoria_loja AS cl ON catprod.categoria_produto_categoria = cl.categoria_id
                ',
        ];
        if (!isset($options[$item])) return '';
        return $options[$item];
    }

    public function getItemFilters($filter, $target, $list) {
        if ($filter == 'custom') {
            $options = [
                'product' => "AND p.produto_id IN ($list)",
                'category' => "AND catprod.categoria_produto_categoria IN ($list)"
            ];
            if (!isset($options[$target])) return '';
            return $options[$target];
        }
        return '';
    }

    public function buildQuery($info) {
        $period = $this->getTimePeriod();
        $itemPeriod = $groupByPeriod = $orderByPeriod = '';
        if ($info['item_type'] == 'line') {
            $itemPeriod = "{$info['item_period']} AS periodo,";
            $groupByPeriod = ", periodo";
            $orderByPeriod = "periodo ASC, ";
        }
        $query = "
            SELECT 
                {$itemPeriod}
                {$info['item_id']} AS id,
                {$info['item_name']} AS nome, 
                SUM(vi.{$info['item_counter']}) AS total
            FROM 
                vendas_itens AS vi
            INNER JOIN
                vendas AS v ON vi.venda_item_venda = v.venda_id
            INNER JOIN 
                produtos AS p ON vi.venda_item_produto = p.produto_id
            {$info['item_extraJoins']}
            WHERE 
                COALESCE(v.venda_cancelada, 0) = 0
            AND
                v.venda_loja_id = {$info['item_store']}
            AND 
                {$period['where']}
            {$info['item_extraFilters']}
            GROUP BY
                id {$groupByPeriod}
            ORDER BY
                {$orderByPeriod} total DESC
            {$info['item_limit']}
        ";
        return $query;
    }

}