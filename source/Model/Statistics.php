<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;
use DateTime;

class Statistics extends Core {

    public function getPeriodos() {
        return [
            'day' => [
                'name' => '24h',
                'following' => 'week',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%H")'
            ],
            'week' => [
                'name' => '7 Dias',
                'following' => 'fortnight',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'fortnight' => [
                'name' => '15 Dias',
                'following' => 'month',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'month' => [
                'name' => '1 Mês',
                'following' => 'semester',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%d")'
            ],
            'semester' => [
                'name' => '6 Meses',
                'following' => 'year',
                'where' => 'v.venda_data_criacao BETWEEN :dataInicio AND :dataFim',
                'group_by' => 'DATE_FORMAT(v.venda_data_criacao, "%m")'
            ],
            'year' => [
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
                produtos p
            JOIN 
                vendas_itens i ON p.produto_id = i.venda_item_produto
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

}