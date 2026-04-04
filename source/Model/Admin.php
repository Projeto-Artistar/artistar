<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Admin extends Core {
    public function getUsers($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                * 
            FROM 
                usuarios 
            ORDER BY 
                usuario_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM usuarios");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getStores($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                *,
                (
                    SELECT
                        MAX(venda_data_criacao)
                    FROM
                        vendas
                    WHERE
                        venda_loja_id = loja_id
                ) AS ultima_venda
            FROM 
                lojas 
            LEFT JOIN
                usuarios ON lojas.loja_proprietario = usuarios.usuario_id
            ORDER BY 
                loja_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStoreCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM lojas");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getProducts($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                * 
            FROM 
                produtos 
            LEFT JOIN
                lojas ON produtos.produto_loja = lojas.loja_id
            ORDER BY 
                produto_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM produtos");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getSales($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                *,
                (
                    SELECT
                        COUNT(*)
                    FROM
                        vendas_itens
                    WHERE
                        venda_item_venda = venda_id
                ) AS total_itens
            FROM 
                vendas 
            LEFT JOIN
                lojas ON vendas.venda_loja_id = lojas.loja_id
            ORDER BY 
                venda_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalesCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM vendas");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getEvents($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                * 
            FROM 
                eventos 
            LEFT JOIN
                usuarios ON eventos.evento_proprietario = usuarios.usuario_id
            ORDER BY 
                evento_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM eventos");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function getSubscriptions($limit = 50, $offset = 0) {
        $stmt = $this->SQL->prepare("
            SELECT 
                * 
            FROM 
                inscricoes 
            LEFT JOIN
                lojas ON inscricoes.inscricao_loja = lojas.loja_id
            LEFT JOIN
                eventos ON inscricoes.inscricao_evento = eventos.evento_id
            ORDER BY 
                inscricao_id DESC
            LIMIT 
                :limit 
            OFFSET 
                :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubscriptionCount() {
        $stmt = $this->SQL->prepare("SELECT COUNT(*) as count FROM inscricoes");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}