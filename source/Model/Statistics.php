<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;
use DateTime;
use Source\Model\Helpers\StatisticsGraphs;

class Statistics extends Core {

    public function getPeriodos() {
        return [
            'day' => [
                'id' => 'day',
                'name' => '24h',
                'following' => 'week',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%H")'
            ],
            'week' => [
                'id' => 'week',
                'name' => '7 Dias',
                'following' => 'fortnight',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'fortnight' => [
                'id' => 'fortnight',
                'name' => '15 Dias',
                'following' => 'month',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'month' => [
                'id' => 'month',
                'name' => '1 Mês',
                'following' => 'semester',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'semester' => [
                'id' => 'semester',
                'name' => '6 Meses',
                'following' => 'year',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%m")'
            ],
            'year' => [
                'id' => 'year',
                'name' => 'Ano',
                'following' => null,
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%m")'
            ]
        ];
    }

    public function getTotals($store, $periodo, $dataReferencia) {
        $query = "
            SELECT 
                {$periodo['group_by']} as periodo,
                SUM(vi.venda_item_valor) as total_vendas,
                COUNT(DISTINCT v.venda_id) as total_transacoes
            FROM 
                vendas v
            LEFT JOIN
                vendas_itens vi ON vi.venda_item_venda = v.venda_id
            WHERE 
                v.venda_loja_id = :store 
            AND
                {$periodo['where']}
            AND
                COALESCE(v.venda_cancelada, 0) = 0
            GROUP BY
                periodo
            ORDER BY
                periodo ASC
        ";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        // Calcular datas de início e fim conforme o período
        list($dataInicio, $dataFim) = $this->getDataInicioFim($dataReferencia, $periodo);
        $stmt->bindValue(':dataInicio', $dataInicio);
        $stmt->bindValue(':dataFim', $dataFim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBestSellers($store, $periodo, $dataReferencia) {
        $query = "
            SELECT
                (
                    SELECT 
                        p.produto_nome
                    FROM 
	  		            vendas_itens vi
                    JOIN 
                        produtos p ON p.produto_id = vi.venda_item_produto
                    JOIN 
                        vendas v ON v.venda_id = vi.venda_item_venda
                    WHERE 
                        v.venda_loja_id = :store 
                    AND
                        {$periodo['where']}
                    AND
                        COALESCE(v.venda_cancelada, 0) = 0
                    GROUP BY 
                        p.produto_id
                    ORDER BY 
                        SUM(vi.venda_item_unidades) DESC
                    LIMIT 1
                ) AS produto_mais_vendido,
                (
                    SELECT 
                        SUM(vi.venda_item_unidades)
                    FROM 
                        vendas_itens vi
                    JOIN 
                        produtos p ON p.produto_id = vi.venda_item_produto
                    JOIN 
                        vendas v ON v.venda_id = vi.venda_item_venda
                    WHERE 
                        v.venda_loja_id = :store 
                    AND
                        {$periodo['where']}
                    AND
                        COALESCE(v.venda_cancelada, 0) = 0
                    GROUP BY 
                        p.produto_id
                    ORDER BY 
                        SUM(vi.venda_item_unidades) DESC
                    LIMIT 1
                ) AS quantidade_mais_vendida,
                (
                SELECT 
                    p.produto_nome
                FROM 
                    vendas_itens vi
                JOIN 
                    produtos p ON p.produto_id = vi.venda_item_produto
                JOIN 
                    vendas v ON v.venda_id = vi.venda_item_venda
                WHERE 
                    v.venda_loja_id = :store 
                AND
                    {$periodo['where']}
                AND
                    COALESCE(v.venda_cancelada, 0) = 0
                GROUP BY 
                    p.produto_id
                ORDER BY 
                    SUM(vi.venda_item_valor) DESC
                LIMIT 1
            ) AS produto_maior_valor,
            (
                SELECT 
                    SUM(vi.venda_item_valor)
                FROM 
                    vendas_itens vi
                JOIN 
                    produtos p ON p.produto_id = vi.venda_item_produto
                JOIN 
                    vendas v ON v.venda_id = vi.venda_item_venda
                WHERE 
                    v.venda_loja_id = :store 
                AND
                    {$periodo['where']}
                AND
                    COALESCE(v.venda_cancelada, 0) = 0
                GROUP BY 
                    p.produto_id
                ORDER BY 
                    SUM(vi.venda_item_valor) DESC
                LIMIT 1
            ) AS valor_maior_venda;
        ";
    $stmt = $this->SQL->prepare($query);
    $stmt->bindValue(':store', $store, PDO::PARAM_INT);
    list($dataInicio, $dataFim) = $this->getDataInicioFim($dataReferencia, $periodo);
    $stmt->bindValue(':dataInicio', $dataInicio);
    $stmt->bindValue(':dataFim', $dataFim);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function arrangeGraphData($totais, $periodoSelecionado, $dataReferencia) {
        $graphData = [
            'labels' => [],
            'values' => [
                'total_vendas' => [],
                'total_transacoes' => []
            ],
            'totals' => [
                'vendas' => 0,
                'transacoes' => 0
            ]
        ];
        switch ($periodoSelecionado) {
            case 'day':
                for ($i=0; $i < 24; $i++) {
                    $nextHour = date('H', strtotime($dataReferencia." +{$i} hour"));
                    $graphData['labels'][] = $nextHour;
                    $graphData['values']['total_vendas'][$nextHour] = 0;
                    $graphData['values']['total_transacoes'][$nextHour] = 0;
                }
                break;
            case 'week':
                for ($i=6; $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData['labels'][] = $nextDay;
                    $graphData['values']['total_vendas'][$nextDay] = 0;
                    $graphData['values']['total_transacoes'][$nextDay] = 0;
                }
                break;
            case 'fortnight':
                for ($i=14; $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData['labels'][] = $nextDay;
                    $graphData['values']['total_vendas'][$nextDay] = 0;
                    $graphData['values']['total_transacoes'][$nextDay] = 0;
                }
                break;
            case 'month':
                for ($i=(date('t')-1); $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData['labels'][] = $nextDay;
                    $graphData['values']['total_vendas'][$nextDay] = 0;
                    $graphData['values']['total_transacoes'][$nextDay] = 0;
                }
                break;
            case 'semester':
                for ($i=5; $i >= 0; $i--) {
                    $nextMonth = date('m', strtotime($dataReferencia." -$i month"));
                    //Nome do Mês em Português
                    $graphData['labels'][] = getMonthName($nextMonth);
                    $graphData['values']['total_vendas'][$nextMonth] = 0;
                    $graphData['values']['total_transacoes'][$nextMonth] = 0;
                }
                break;
            case 'year':
                for ($i=11; $i >= 0; $i--) {
                    $nextMonth = date('m', strtotime($dataReferencia." -$i month"));
                    $graphData['labels'][] = getMonthName($nextMonth);
                    $graphData['values']['total_vendas'][$nextMonth] = 0;
                    $graphData['values']['total_transacoes'][$nextMonth] = 0;
                }
                break;
        }
        foreach ($totais as $total) {
            $graphData['values']['total_vendas'][$total['periodo']] = $total['total_vendas'];
            $graphData['values']['total_transacoes'][$total['periodo']] = $total['total_transacoes'];
        }
        $graphData['totals']['vendas'] = array_sum($graphData['values']['total_vendas']);
        $graphData['totals']['transacoes'] = array_sum($graphData['values']['total_transacoes']);
        return $graphData;
    }

    public function getProductRanking($store, $periodo, $dataReferencia) {
        $query = "
            SELECT 
                p.produto_id, 
                p.produto_nome, 
                p.produto_codigo_interno,
                SUM(i.venda_item_unidades) as total_vendido, 
                SUM(i.venda_item_valor) as total_faturado
            FROM 
                vendas_itens i 
            JOIN 
                produtos p ON p.produto_id = i.venda_item_produto
            JOIN 
                vendas v ON v.venda_id = i.venda_item_venda
            WHERE 
                v.venda_loja_id = :store 
            AND 
                {$periodo['where']}
            AND
                COALESCE(v.venda_cancelada, 0) = 0
            GROUP BY 
                p.produto_id
            ORDER BY 
                total_faturado DESC, total_vendido DESC, p.produto_nome ASC
        ";

    $stmt = $this->SQL->prepare($query);
    $stmt->bindValue(':store', $store, PDO::PARAM_INT);
    list($dataInicio, $dataFim) = $this->getDataInicioFim($dataReferencia, $periodo);
    $stmt->bindValue(':dataInicio', $dataInicio);
    $stmt->bindValue(':dataFim', $dataFim);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Calcula as datas de início e fim para cada período
     */
    private function getDataInicioFim($dataReferencia, $periodo) {
        switch ($periodo['name']) {
            case '24h':
                $dataInicio = $dataReferencia . ' 00:00:00';
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            case '7 Dias':
                $dataInicio = date('Y-m-d 00:00:00', strtotime($dataReferencia . ' -6 days'));
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            case '15 Dias':
                $dataInicio = date('Y-m-d 00:00:00', strtotime($dataReferencia . ' -14 days'));
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            case '1 Mês':
                $dataInicio = date('Y-m-d 00:00:00', strtotime($dataReferencia . ' -1 month +1 day'));
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            case '6 Meses':
                $dataInicio = date('Y-m-d 00:00:00', strtotime($dataReferencia . ' -5 months'));
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            case 'Ano':
                $dataInicio = date('Y-m-d 00:00:00', strtotime($dataReferencia . ' -11 months'));
                $dataFim = $dataReferencia . ' 23:59:59';
                break;
            default:
                $dataInicio = $dataReferencia . ' 00:00:00';
                $dataFim = $dataReferencia . ' 23:59:59';
        }
        return [$dataInicio, $dataFim];
    }

    public function getAllProducts($store) {
        $query = "SELECT produto_id id, produto_nome nome FROM produtos WHERE produto_loja = :store ORDER BY produto_nome ASC";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCategories($store) {
        $query = "SELECT categoria_id id, categoria_nome nome FROM categoria_loja WHERE categoria_loja = :store ORDER BY categoria_nome ASC";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGraphTypes($store) {
        $query = "
            SELECT 
                *
            FROM 
                graficos_loja
            WHERE
                grafico_loja = :store
        ";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGraphTypeByPosition($store, $graphId) {
        $query = "
            SELECT 
                *
            FROM 
                graficos_loja 
            WHERE 
                grafico_loja = :store 
            AND 
                grafico_posicao = :graphId
        ";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->bindValue(':graphId', $graphId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createGraphType($store, $graphId, $info) {
        $query = "
            INSERT INTO graficos_loja (
                grafico_loja, 
                grafico_tipo, 
                grafico_contador, 
                grafico_alvo, 
                grafico_filtro,  
                grafico_lista,
                grafico_posicao
            ) VALUES (
                :store, 
                :type, 
                :counter, 
                :target, 
                :filter, 
                :list,
                :position
            )
        ";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->bindValue(':type', $info['type'], PDO::PARAM_STR);
        $stmt->bindValue(':counter', $info['counter'], PDO::PARAM_STR);
        $stmt->bindValue(':target', $info['target'], PDO::PARAM_STR);
        $stmt->bindValue(':filter', $info['filter'], PDO::PARAM_STR);
        $stmt->bindValue(':list', $info['list'], PDO::PARAM_STR);
        $stmt->bindValue(':position', $graphId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateGraphType($store, $graphId, $info) {
        $query = "
            UPDATE graficos_loja SET
                grafico_tipo = :type,
                grafico_contador = :counter,
                grafico_alvo = :target,
                grafico_filtro = :filter,
                grafico_lista = :list
            WHERE
                grafico_loja = :store
            AND
                grafico_posicao = :graphId
        ";
        $stmt = $this->SQL->prepare($query);
        $stmt->bindValue(':type', $info['type'], PDO::PARAM_STR);
        $stmt->bindValue(':counter', $info['counter'], PDO::PARAM_STR);
        $stmt->bindValue(':target', $info['target'], PDO::PARAM_STR);
        $stmt->bindValue(':filter', $info['filter'], PDO::PARAM_STR);
        $stmt->bindValue(':list', $info['list'], PDO::PARAM_STR);
        $stmt->bindValue(':store', $store, PDO::PARAM_INT);
        $stmt->bindValue(':graphId', $graphId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getGraphData($store, $graphs, $periodo, $dataReferencia) {
        $statisticsGraphs = new StatisticsGraphs($store, $periodo);
        foreach($graphs as $graph) $statisticsGraphs->setGraphType($graph['grafico_posicao'], $graph);
        $info = [];
        foreach($statisticsGraphs->getGraphData() as $key => $data) {
            $graphData = $this->queryGraphData($data['data'], $periodo, $dataReferencia);
            
            if ($data['type'] == 'line') {
                $graphData = $this->arrangeCustomGraphData($graphData, $periodo['id'], $dataReferencia);
                $graphData = array_values($graphData);
            }
            $info[$key] = [
                'id'    => $data['id'],
                'name'  => $data['name'],
                'type'  => $data['type'],
                'real'  => $data['real'],
                'data'  => $graphData,
                'base' => $statisticsGraphs->getGraphType($data['id'])
            ];
        }

        return $info;
    }

    public function queryGraphData($query ,$periodo, $dataReferencia) {
        $stmt = $this->SQL->prepare($query);
        list($dataInicio, $dataFim) = $this->getDataInicioFim($dataReferencia, $periodo);
        $stmt->bindValue(':dataInicio', $dataInicio);
        $stmt->bindValue(':dataFim', $dataFim);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrangeCustomGraphData($totais, $periodoSelecionado, $dataReferencia) {
        $graphData = [];
        switch ($periodoSelecionado) {
            case 'day':
                for ($i=0; $i < 24; $i++) {
                    $nextHour = date('H', strtotime($dataReferencia." +{$i} hour"));
                    $graphData[$nextHour] = 0;
                }
                break;
            case 'week':
                for ($i=6; $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData[$nextDay] = 0;
                }
                break;
            case 'fortnight':
                for ($i=14; $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData[$nextDay] = 0;
                }
                break;
            case 'month':
                for ($i=(date('t')-1); $i >= 0; $i--) {
                    $nextDay = date('d', strtotime($dataReferencia." -$i day"));
                    $graphData[$nextDay] = 0;
                }
                break;
            case 'semester':
                for ($i=5; $i >= 0; $i--) {
                    $nextMonth = date('m', strtotime($dataReferencia." -$i month"));
                    $graphData[$nextMonth] = 0;
                }
                break;
            case 'year':
                for ($i=11; $i >= 0; $i--) {
                    $nextMonth = date('m', strtotime($dataReferencia." -$i month"));
                    $graphData[$nextMonth] = 0;
                }
                break;
        }
        $base = $graphData;
        $graphData = [];
        foreach ($totais as $total) {
            if (!isset($graphData[$total['id']])) $graphData[$total['id']] = [
                'label' => $total['nome'],
                'data' => $base
            ];
            $graphData[$total['id']]['data'][$total['periodo']] = $total['total'];
        }
        foreach ($graphData as $key => $data) {
            $graphData[$key]['data'] = array_values($data['data']);
        }
        return $graphData;
    }

}