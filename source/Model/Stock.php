<?php


namespace Source\Model;

use PDO;
use Source\Core\Core;

class Stock extends Core {

    public function getStocks($store) {
        $stmt = $this->SQL->prepare("
            SELECT 
                COUNT(IF(produto_estoque >= produto_estoque_minimo AND produto_estoque > 0 AND produto_ativo = 1, 1, NULL)) AS goodStock,
                COUNT(IF(produto_estoque < produto_estoque_minimo AND produto_estoque > 0 AND produto_ativo = 1, 1, NULL)) AS lowStock,
                COUNT(IF(produto_estoque = 0 AND produto_ativo = 1, 1, NULL)) AS outOfStock,
                COUNT(IF(produto_ativo = 0, 1, NULL)) AS deadStock,
                COUNT(produto_id) AS totalProducts
            FROM
                produtos
            WHERE
                produto_loja = :store
        ");
        $stmt->bindValue(":store", $store);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return [
                'goodStock' => 0,
                'lowStock' => 0,
                'outOfStock' => 0,
                'deadStock' => 0
            ];
        }
        return $result;
    }

    public function getCategories($store) {
        $stmt = $this->SQL->prepare("
            SELECT 
                categoria_id id,
                categoria_nome nome,
                categoria_cor cor 
            FROM 
                categoria_loja 
            WHERE 
                categoria_ativa = 1
            AND
                categoria_loja = :store
            ORDER BY 
                nome ASC
        ");
        $stmt->bindValue(":store", $store);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProducts($store, $pagination = [], $search = []) {
        $stmt = $this->SQL->prepare("
            SELECT 
                produto_id id,
                produto_nome nome,
                produto_thumbnail thumbnail,
                produto_valor valor,
                produto_valor_desconto valor_desconto,
                produto_estoque estoque,
                produto_estoque_minimo estoque_minimo,
                produto_palavras_chave palavras_chave,
                produto_ativo ativo
            FROM 
                produtos 
            WHERE 
                produto_loja = :store
           ORDER BY
                nome ASC
            LIMIT :offset, :limit
        ");
        $stmt->bindValue(":store", $store);
        $stmt->bindValue(":offset", (int) $pagination['offset'], PDO::PARAM_INT);
        $stmt->bindValue(":limit", (int) $pagination['limit'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertProduct($data) {
        $stmt = $this->SQL->prepare("
            INSERT INTO produtos (
                produto_nome, 
                produto_descricao, 
                produto_valor, 
                produto_valor_desconto, 
                produto_custo, 
                produto_estoque, 
                produto_estoque_minimo, 
                produto_loja, 
                produto_ativo, 
                produto_palavras_chave
            ) VALUES ( 
                :produto_nome, 
                :produto_descricao, 
                :produto_valor, 
                :produto_valor_desconto, 
                :produto_custo, 
                :produto_estoque, 
                :produto_estoque_minimo, 
                :produto_loja, 
                :produto_ativo, 
                :produto_palavras_chave
            )
        ");
        $stmt->execute($data);
        return $this->SQL->lastInsertId();
    }

    public function updateThumbnail($thumbnail, $productId) {
        $stmt = $this->SQL->prepare("
            UPDATE produtos SET
                produto_thumbnail = :produto_thumbnail
            WHERE
                produto_id = :produto_id
        ");
        $stmt->bindValue(":produto_thumbnail", $thumbnail);
        $stmt->bindValue(":produto_id", $productId);
        $stmt->execute();
    }

    public function insertExistingCategories($categories, $store, $productId) {

        if (empty($categories)) return [];

        $trueCategories = array_map('intval', $categories);
        $trueCategories = array_filter($trueCategories);

        $placeholders = [0];
        $params = [':store' => $store];
        foreach ($trueCategories as $i => $cat) {
            $ph = ":cat{$i}";
            $placeholders[] = $ph;
            $params[$ph] = $cat;
        }

        $sql = "
            SELECT 
                categoria_id 
            FROM 
                categoria_loja
            WHERE 
                categoria_loja = :store
            AND 
                categoria_id IN (" . implode(',', $placeholders) . ")
        ";

        $existingCategories = $this->SQL->prepare($sql);
        $existingCategories->execute($params);
        $existingCategories = $existingCategories->fetchAll(PDO::FETCH_COLUMN);

        $remainingCategories = array_diff($categories, $existingCategories);
        
        if (!empty($existingCategories))  {
            $stmt = $this->SQL->prepare("
                INSERT INTO categoria_produtos (categoria_produto_categoria, categoria_produto_produto)
                VALUES (:category, :productId)
            ");
            foreach ($existingCategories as $category) {
                $stmt->execute([
                    ':category' => $category,
                    ':productId' => $productId,
                ]);
            }
        }
    
        return $remainingCategories;
        
    }

    public function insertNewStoreCategories($categories, $productId, $store) {
        if (empty($categories)) return [];
        $trueCategories = [];
        $stmt = $this->SQL->prepare("
            INSERT INTO categoria_loja (categoria_loja, categoria_nome, categoria_ativa)
            VALUES (:store, :category, 1)
        ");
        foreach ($categories as $category) {
            $stmt->execute([
                ':store' => $store,
                ':category' => $category
            ]);
            $trueCategories[] = $this->SQL->lastInsertId();
        }
        if (!empty($trueCategories)) $this->insertExistingCategories($trueCategories, $store, $productId);
        return $trueCategories;
    }
}