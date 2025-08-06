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
                produto_palavras_chave palavra_chave,
                produto_descricao descricao,
                produto_codigo_interno subtitulo,
                produto_valor preco,
                produto_valor_desconto desconto,
                produto_estoque estoque,
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

    public function insertSale($saleData, $storeId) {
        //Start transaction
        $this->SQL->beginTransaction();
        try {
            //The transaction will: insert the sale and its items
            $stmt = $this->SQL->prepare("
                INSERT INTO vendas (
                    venda_loja_id,
                    venda_pagamento,
                    venda_data_criacao, 
                    venda_pago,
                    venda_entregue
                ) VALUES (
                    :loja_id, 
                    :pagamento, 
                    NOW(), 
                    :pago, 
                    :entregue
                )
            ");
            $stmt->bindValue(":loja_id", $storeId, PDO::PARAM_INT);
            switch($saleData['payment_method']) {
                case 'pix':
                    $saleData['payment_method'] = 'Pix';
                    break;
                case 'dinheiro':
                default:
                    $saleData['payment_method'] = 'Dinheiro';
                    break;
                case 'cartao-debito':
                    $saleData['payment_method'] = 'Cartão de Débito';
                    break;
                case 'cartao-credito':
                    $saleData['payment_method'] = 'Cartão de Crédito';
                    break;
                case 'boleto':
                    $saleData['payment_method'] = 'Boleto';
                    break;
                case 'transferencia':
                    $saleData['payment_method'] = 'Transferência';
                    break;
                case 'outro':
                    $saleData['payment_method'] = 'Outro';
                    break;
            }
            $stmt->bindValue(":pagamento", $saleData['payment_method'], PDO::PARAM_STR);
            $stmt->bindValue(":pago", (isset($saleData['paid']) && $saleData['paid'] == '1' ? 1 : 0), PDO::PARAM_BOOL);
            $stmt->bindValue(":entregue", (isset($saleData['delivered']) && $saleData['delivered'] == '1' ? 1 : 0), PDO::PARAM_BOOL);
            $stmt->execute();
            $saleId = $this->SQL->lastInsertId();
            foreach ($saleData['items'] as $item) {
                $stmt = $this->SQL->prepare("
                    INSERT INTO vendas_itens (
                        venda_item_produto, 
                        venda_item_venda,
                        venda_item_unidades,
                        venda_item_desconto,
                        venda_item_valor
                    ) VALUES (
                        :produto_id,
                        :venda_id,
                        :quantidade,
                        :desconto,
                        :preco
                        
                    )
                ");
                $stmt->bindValue(":produto_id", $item['id'], PDO::PARAM_INT);
                $stmt->bindValue(":venda_id", $saleId, PDO::PARAM_INT);
                $stmt->bindValue(":quantidade", $item['qtd'], PDO::PARAM_INT);
                $item['total_price'] = str_replace(',', '.', str_replace('.', '', $item['total_price']));
                $item['discount'] = str_replace(',', '.', str_replace('.', '', $item['discount']));
                $stmt->bindValue(":preco", $item['total_price'], PDO::PARAM_STR);
                $stmt->bindValue(":desconto", $item['discount'], PDO::PARAM_STR);
                $stmt->execute();
            }


            //Commit transaction
            $this->SQL->commit();
            return $saleId;
        } catch (\Exception $e) {
            //Rollback transaction in case of error
            $this->SQL->rollBack();
            throw new \Exception("Erro ao inserir venda: " . $e->getMessage());
        }
    }

}