<?php

namespace Source\Model\Helpers;

use Aws\S3\S3Client;

class StatisticsGraphs {

    private $storeId = NULL;
    private $graphTypes = [];
    private $graphData = [];
    private $timePeriod = NULL;
    protected $translator;

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
                'item_extraFilters' => $this->getItemFilters($graphType['grafico_filtro'], $graphType['grafico_alvo'], $graphType['grafico_lista'], $graphType['grafico_contador']),
                'item_filter' => $graphType['grafico_filtro']

            ];
            $data[$key] = [
                'id' => $key,
                'name' => $this->buildName($graphType),
                'type' => $graphType['grafico_tipo'],
                'real' => in_array($graphType['grafico_contador'], ['revenue', 'discount', 'average_value', 'contribution_margin']),
                'data' => $this->buildQuery($info)
            ];
        }
        return $data;
    }

    public function buildName($graphType) {
        $translator = $this->getTranslator();
        $nome = '';
        switch($graphType['grafico_tipo']) {
            case 'pie':
                $nome .= $translator->translate("Distribuição");
                break;
            case 'bar':
                $nome .= $translator->translate("Comparação");
                break;
            case 'line':
                $nome .= $translator->translate("Evolução");
                break;
        }
        switch($graphType['grafico_contador']) {
            case 'sold_units':
                $nome .= $translator->translate(' das Unidades Vendidas');
                break;
            case 'revenue':
                $nome .= $translator->translate(' do Faturamento');
                break;
            case 'discount':
                $nome .= $translator->translate(' do Desconto');
                break;
            case 'refunds':
                $nome .= $translator->translate(' dos Reembolsos');
                break;
            case 'average_value':
                $nome .= $translator->translate(' do Valor Médio');
                break;
            case 'transactions':
                $nome .= $translator->translate(' das Transações');
                break;
            case 'contribution_margin':
                $nome .= $translator->translate(' da Margem de Contribuição');
                break;
        }
        switch($graphType['grafico_alvo']) {
            case 'product':
                $nome .= $translator->translate(' por Produto');
                break;
            case 'category':
                $nome .= $translator->translate(' por Categoria');
                break;
            case 'payment_method':
                $nome .= $translator->translate(' por Método de Pagamento');
                break;
        }
        switch($graphType['grafico_filtro']) {
            case 'all':
                $nome .= $translator->translate(' (Todos)');
                break;
            case 'top_10':
                $nome .= $translator->translate(' (Top 10)');
                break;
            case 'custom':
                $nome .= $translator->translate(' (Personalizado)');
                break;
        }
        return $nome;

    }

    public function getItemTimePeriod($type) {
        return $type == 'line' ? $this->getTimePeriod()['group_by'] : '';
    }

    public function getItemId($item) {
        $options = [
            'product' => 'p.produto_id',
            'category' => 'categoria_id',
            'payment_method' => 'venda_pagamento'
        ];
        if (!isset($options[$item])) return 'produto_id';
        return $options[$item];
    }

    public function getItemName($item) {
        $options = [
            'product' => 'p.produto_nome',
            'category' => 'categoria_nome',
            'payment_method' => 'venda_pagamento'
        ];
        if (!isset($options[$item])) return 'produto_nome';
        return $options[$item];
    }

    public function getItemCounter($item) {
        $options = [
            'sold_units' => 'SUM(vi.venda_item_unidades)',
            'revenue' => 'SUM(vi.venda_item_valor)',
            'discount' => 'SUM(vi.venda_item_desconto)',
            'refunds' => 'COUNT(DISTINCT(vi.venda_item_venda))',
            'average_value' => 'AVG(vi.venda_item_valor)',
            'transactions' => 'COUNT(DISTINCT(vi.venda_item_venda))',
            'contribution_margin' => 'SUM((vi.venda_item_valor - (p.produto_custo * vi.venda_item_unidades)))'
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

    public function getItemFilters($filter, $target, $list, $counter) {
        $and = [];
        if ($filter == 'custom') {
            $options = [
                'product' => "p.produto_id IN ($list)",
                'category' => "catprod.categoria_produto_categoria IN ($list)"
            ];
            if (isset($options[$target])) $and[] = $options[$target];
        }
        if ($counter == 'refunds') {
            $and[] = "v.venda_cancelada = 1";
        } else {
            $and[] = "COALESCE(v.venda_cancelada, 0) = 0";
        }
        // echo $target;
        // echo '<pre>';
        // print_r($and);
        // exit;
        if (empty($and)) return '';
        return 'AND ' . implode(' AND ', $and);
    }

    public function buildQuery($info) {
        $period = $this->getTimePeriod();
        $itemPeriod = $groupByPeriod = $orderByPeriod = '';
        if ($info['item_type'] == 'line') {
            $itemPeriod = "{$info['item_period']} AS periodo,";
            $groupByPeriod = ", periodo";
            $orderByPeriod = "periodo ASC, ";
        }
        if ($info['item_filter'] != 'top_10') {
            $query = "
                SELECT 
                    {$itemPeriod}
                    {$info['item_id']} AS id,
                    {$info['item_name']} AS nome, 
                    {$info['item_counter']} AS total
                FROM 
                    vendas_itens AS vi
                INNER JOIN
                    vendas AS v ON vi.venda_item_venda = v.venda_id
                INNER JOIN 
                    produtos AS p ON vi.venda_item_produto = p.produto_id
                {$info['item_extraJoins']}
                WHERE 
                    v.venda_loja_id = {$info['item_store']}
                AND 
                    {$period['where']}
                {$info['item_extraFilters']}
                GROUP BY
                    id {$groupByPeriod}
                ORDER BY
                    {$orderByPeriod} total DESC
            ";
        } else {
            $query = "
                SELECT 
                    {$itemPeriod}
                    {$info['item_id']} AS id,
                    {$info['item_name']} AS nome, 
                    {$info['item_counter']} AS total
                FROM 
                    vendas_itens AS vi
                INNER JOIN
                    vendas AS v ON vi.venda_item_venda = v.venda_id
                INNER JOIN 
                    produtos AS p ON vi.venda_item_produto = p.produto_id
                INNER JOIN
                (
                    SELECT 
                        {$info['item_id']} AS id
                    FROM 
                        vendas_itens AS vi
                    INNER JOIN
                        vendas AS v ON vi.venda_item_venda = v.venda_id
                    INNER JOIN 
                        produtos AS p ON vi.venda_item_produto = p.produto_id
                    {$info['item_extraJoins']}
                    WHERE 
                        v.venda_loja_id = {$info['item_store']}
                    AND 
                        {$period['where']}
                    {$info['item_extraFilters']}
                    GROUP BY
                        id
                    ORDER BY
                        {$info['item_counter']} DESC
                    LIMIT 10
                ) AS top_itens ON {$info['item_id']} = top_itens.id
                {$info['item_extraJoins']}
                WHERE 
                    v.venda_loja_id = {$info['item_store']}
                AND 
                    {$period['where']}
                {$info['item_extraFilters']}
                GROUP BY
                    id {$groupByPeriod}
                ORDER BY
                    {$orderByPeriod} total DESC
                
            ";
            // echo '<pre>';
            // print_r($query);
            // exit;
        }
        return $query;
    }

    public function setTranslator($translator) {
        $this->translator = $translator;
    }

    public function getTranslator() {
        return $this->translator;
    }

}