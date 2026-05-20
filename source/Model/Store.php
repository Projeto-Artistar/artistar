<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Store extends Core {

    public function getStoreData($storeId) {
        if ((int) $storeId < 1) return null;

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

    public function getStoreDataByFriendlyUrl($friendlyUrl) {
        $friendlyUrl = trim((string) $friendlyUrl);
        if (empty($friendlyUrl)) return null;

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
                loja.loja_nome_unico = :friendlyUrl
            LIMIT 1'
        );

        $select->bindParam(':friendlyUrl', $friendlyUrl, PDO::PARAM_STR);
        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function getPublicProducts($storeId, $search = '', $limit = 24, $onlyOrdered = false) {
        $query = '
            SELECT
                p.produto_id id,
                p.produto_nome nome,
                p.produto_thumbnail thumbnail,
                p.produto_valor valor,
                p.produto_valor_desconto valor_desconto,
                p.produto_estoque estoque
            FROM
                produtos p
        ';

        if ($onlyOrdered) {
            $query .= '
                INNER JOIN produtos_ordenacao ordenacao ON ordenacao.produto_id = p.produto_id
            ';
        }

        $query .= '
            WHERE
                p.produto_loja = :storeId
            AND
                p.produto_ativo = 1
        ';

        if (!empty($search)) {
            $query .= '
                AND (
                    p.produto_nome LIKE :search
                    OR p.produto_descricao LIKE :search
                    OR p.produto_palavras_chave LIKE :search
                )
            ';
        }

        if ($onlyOrdered) {
            $query .= '
                ORDER BY ordenacao.produto_ordenacao_ordem ASC, p.produto_id DESC
            ';
        } else {
            $query .= '
                ORDER BY p.produto_id DESC
            ';
        }

        $query .= '
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

    public function getManageProducts($storeId, $search = '', $limit = 120) {
        $query = '
            SELECT
                p.produto_id id,
                p.produto_nome nome,
                p.produto_thumbnail thumbnail,
                p.produto_valor valor,
                p.produto_valor_desconto valor_desconto,
                CASE WHEN ordenacao.produto_id IS NULL THEN 0 ELSE 1 END selecionado,
                COALESCE(ordenacao.produto_ordenacao_ordem, 0) ordem
            FROM
                produtos p
            LEFT JOIN (
                SELECT
                    po.produto_id,
                    MIN(po.produto_ordenacao_ordem) produto_ordenacao_ordem
                FROM
                    produtos_ordenacao po
                GROUP BY
                    po.produto_id
            ) ordenacao ON ordenacao.produto_id = p.produto_id
            WHERE
                p.produto_loja = :storeId
            AND
                p.produto_ativo = 1
        ';

        if (!empty($search)) {
            $query .= '
                AND (
                    p.produto_nome LIKE :search
                    OR p.produto_descricao LIKE :search
                    OR p.produto_palavras_chave LIKE :search
                )
            ';
        }

        $query .= '
            ORDER BY
                CASE WHEN ordenacao.produto_id IS NULL THEN 1 ELSE 0 END ASC,
                ordenacao.produto_ordenacao_ordem ASC,
                p.produto_id DESC
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

    public function toggleProductOrder($storeId, $productId) {
        $storeId = (int) $storeId;
        $productId = (int) $productId;

        if ($storeId < 1 || $productId < 1) {
            return ['success' => false, 'selected' => false, 'message' => 'Dados invalidos.'];
        }

        $productCheck = $this->SQL->prepare('
            SELECT produto_id
            FROM produtos
            WHERE produto_id = :productId
              AND produto_loja = :storeId
            LIMIT 1
        ');
        $productCheck->bindParam(':productId', $productId, PDO::PARAM_INT);
        $productCheck->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $productCheck->execute();

        if (!$productCheck->fetch(PDO::FETCH_ASSOC)) {
            return ['success' => false, 'selected' => false, 'message' => 'Produto nao pertence a loja.'];
        }

        $existing = $this->SQL->prepare('SELECT produto_ordenacao_id FROM produtos_ordenacao WHERE produto_id = :productId LIMIT 1');
        $existing->bindParam(':productId', $productId, PDO::PARAM_INT);
        $existing->execute();
        $exists = $existing->fetch(PDO::FETCH_ASSOC);

        if ($exists) {
            $delete = $this->SQL->prepare('DELETE FROM produtos_ordenacao WHERE produto_id = :productId');
            $delete->bindParam(':productId', $productId, PDO::PARAM_INT);
            $ok = $delete->execute();

            return ['success' => (bool) $ok, 'selected' => false, 'message' => $ok ? 'Produto removido da vitrine.' : 'Erro ao remover produto.'];
        }

        $countSelected = $this->SQL->prepare('
            SELECT COUNT(*) total
            FROM produtos_ordenacao po
            INNER JOIN produtos p ON p.produto_id = po.produto_id
            WHERE p.produto_loja = :storeId
        ');
        $countSelected->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $countSelected->execute();
        $totalSelected = (int) ($countSelected->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

        if ($totalSelected >= 10) {
            return [
                'success' => false,
                'selected' => false,
                'message' => 'Voce pode selecionar no maximo 10 produtos na vitrine.'
            ];
        }

        $nextOrderQuery = $this->SQL->prepare('
            SELECT COALESCE(MAX(po.produto_ordenacao_ordem), 0) max_ordem
            FROM produtos_ordenacao po
            INNER JOIN produtos p ON p.produto_id = po.produto_id
            WHERE p.produto_loja = :storeId
        ');
        $nextOrderQuery->bindParam(':storeId', $storeId, PDO::PARAM_INT);
        $nextOrderQuery->execute();
        $maxOrder = (int) ($nextOrderQuery->fetch(PDO::FETCH_ASSOC)['max_ordem'] ?? 0);
        $nextOrder = $maxOrder + 1;

        $insert = $this->SQL->prepare('
            INSERT INTO produtos_ordenacao (produto_id, produto_ordenacao_ordem)
            VALUES (:productId, :nextOrder)
        ');
        $insert->bindParam(':productId', $productId, PDO::PARAM_INT);
        $insert->bindParam(':nextOrder', $nextOrder, PDO::PARAM_INT);
        $ok = $insert->execute();

        return ['success' => (bool) $ok, 'selected' => true, 'message' => $ok ? 'Produto adicionado a vitrine.' : 'Erro ao adicionar produto.'];
    }
}