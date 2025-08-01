<?php

namespace Source\Controllers;
use Source\Core\Core;
use Source\Model\Stock;

class stockController extends Core {

    public function __construct($router = ROOT) {
        parent::__construct($router);
        if (!$this->getLogado()) {
            header("Location: /login");
        }
    }

    public function home() {
        $stockModel = new Stock();
        $store = $this->getUser()['loja_id'] ?? 0;
        $search = $_GET['search'] ?? '';
        $filter = $_GET['filter'] ?? [];
        if (!isset($filter['status'])) $filter['status'] = '';
        if (!isset($filter['category'])) $filter['category'] = [];
        if (!isset($filter['price'])) $filter['price'] = '';
        if (!isset($filter['cost'])) $filter['cost'] = '';
        if (!isset($filter['discount'])) $filter['discount'] = '';
        if (!isset($filter['real_price'])) $filter['real_price'] = '';
        if (!isset($filter['stock'])) $filter['stock'] = '';
        if (!isset($filter['min_stock'])) $filter['min_stock'] = '';
        $pagination = $_GET['pagination'] ?? [
            'offset' => 0
        ];
        $pagination['limit'] = 12;


        $whereStock = $stockModel->buildWhereStock($search, $filter);

        $stocks = $stockModel->getStocks($store, $whereStock);

        $pages = [
            'current' => ($pagination['offset'] / $pagination['limit']) + 1,
            'total' => ceil($stocks['totalProducts'] / $pagination['limit'])
        ]; 
        
        $sort = $_GET['sort'] ?? 'name_asc';
        $orderList = $stockModel->getOrderList($sort);
        $order = $stockModel->buildOrderBy($orderList, $sort);

        echo $this->view->render("stock/home", [
            'layout' => [
                'title' =>  'Stock - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'stocks' => $stocks,
            'categories' => $stockModel->getCategories($store),
            'products' => $stockModel->getProducts($store, $pagination, $whereStock, $order),
            'pagination' => $pagination,
            'pages' => $pages,
            'orderList' => $orderList,
            'search' => $search ?? '',
            'filter' => $filter ?? [],
            'sort' => $sort,
            'get' => $_GET,
        ]);
        return;
    }

    public function newProduct($post) {
        $stockModel = new Stock();
        $store = $this->getUser()['loja_id'] ?? 0;
        if (empty($store)) exit($this->renderApiResponse(400, "Loja não encontrada."));
        $insertData = [
            'produto_nome' => $post['name'] ?? '',
            'produto_codigo_interno' => $post['insideId'] ?? '',
            'produto_descricao' => $post['description'] ?? '',
            'produto_valor' => str_replace(',', '.', str_replace('.', '', $post['price'])),
            'produto_valor_desconto' => str_replace(',', '.', str_replace('.', '', $post['discount'] ?? '0')),
            'produto_custo' => str_replace(',', '.', str_replace('.', '', $post['cost'] ?? '0')),
            'produto_estoque' => $post['stock'] ?? 0,
            'produto_estoque_minimo' => $post['min_stock'] ?? 0,
            'produto_loja' => $store,
            'produto_ativo' => isset($post['active']) ? 1 : 0,
            'produto_palavras_chave' => isset($post['keywords']) ? implode('|', $post['keywords']) : '',
        ];
        if (empty($insertData['produto_nome'])) {
            exit($this->renderApiResponse(400, "Nome do produto é obrigatório."));
        }
        $productId = $stockModel->insertProduct($insertData);
        if (!$productId) {
            exit($this->renderApiResponse(500, "Erro ao inserir produto."));
        } else {
            $categories = $post['category'] ?? [];
            $stockModel->insertProductCategories($categories, $store, $productId);
            $post['thumbnail'] = $this->moveFile($_FILES['thumbnail']['tmp_name'] ?? '', 'uploads/products/'.$productId.'/thumbnail.'. pathinfo($_FILES['thumbnail']['name'] ?? '', PATHINFO_EXTENSION));
            $stockModel->updateThumbnail($post['thumbnail'], $productId);
        }
        exit($this->renderApiResponse(200, "Produto inserido com sucesso.", ['productId' => $productId]));

    }

    public function productDetails($get) {
        $productId = $get['productId'] ?? 0;
        $stockModel = new Stock();
        $store = $this->getUser()['loja_id'] ?? 0;
        if (empty($store)) exit($this->renderApiResponse(400, "Loja não encontrada."));
        $product = $stockModel->getProductById($productId, $store);
        if (empty($product['id'])) header("Location: ".url('stock'));
        echo $this->view->render("stock/productDetails", [
            'layout' => [
                'title' =>  $product['nome'].'- Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'product' => $product,
            'categories' => $stockModel->getCategories($store)
        ]);
        return;
    }

    public function alterProduct($post) {
        $productId = $post['productId'] ?? 0;
        $store = $this->getUser()['loja_id'] ?? 0; 
        $stockModel = new Stock();
        $product = $stockModel->getProductById($productId, $store);
        if (empty($store)) exit($this->renderApiResponse(400, "Loja não encontrada."));
        if (empty($product)) exit($this->renderApiResponse(400, "Produto não encontrado."));
        $update = [
            'produto_nome' => $post['name'] ?? '',
            'produto_descricao' => $post['description'] ?? '',
            'produto_valor' => desconverteMoedaReal($post['price']),
            'produto_valor_desconto' => desconverteMoedaReal($post['discount'] ?? '0'),
            'produto_custo' => desconverteMoedaReal($post['cost'] ?? '0'),
            'produto_estoque' => $post['stock'] ?? 0,
            'produto_estoque_minimo' => $post['min_stock'] ?? 0,
            'produto_ativo' => isset($post['active']) ? 1 : 0,
            'produto_palavras_chave' => isset($post['keywords']) ? implode('|', $post['keywords']) : '',
            'produto_codigo_interno' => $post['insideId'] ?? ''
        ];
        try {
            $stockModel->updateProduct($productId, $store, $update);
            if (!isset($post['category'])) $post['category'] = [];
            $stockModel->addNewProductCategories($post['category'], $store, $productId);
            if (!empty($_FILES['thumbnail']['tmp_name'])) {
                $newThumbnail = $this->moveFile($_FILES['thumbnail']['tmp_name'] ?? '', 'uploads/products/'.$productId.'/thumbnail.'. pathinfo($_FILES['thumbnail']['name'] ?? '', PATHINFO_EXTENSION));
                $stockModel->updateThumbnail($newThumbnail, $productId);
            }
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao atualizar produto: " . $e->getMessage()));
        }

        exit($this->renderApiResponse(200, "Produto atualizado com sucesso."));

        return;
    }

    public function duplicateProduct($post) {
        $productId = $post['productId'] ?? 0;
        $store = $this->getUser()['loja_id'] ?? 0; 
        $stockModel = new Stock();
        $product = $stockModel->getProductById($productId, $store);
        if (empty($store)) exit($this->renderApiResponse(400, "Loja não encontrada."));
        if (empty($product)) exit($this->renderApiResponse(400, "Produto não encontrado."));
        
        try {
            $newProductId = $stockModel->duplicateProduct($productId, $store);
            if (!$newProductId) exit($this->renderApiResponse(500, "Erro ao duplicar produto."));
            $stockModel->duplicateProductCategories($productId, $newProductId, $store);
            $newThumbnail = $this->copyFile($product['thumbnail'], 'uploads/products/'.$newProductId.'/thumbnail.'. pathinfo($product['thumbnail'], PATHINFO_EXTENSION));  
            if($newThumbnail) $stockModel->updateThumbnail($newThumbnail, $newProductId);
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao duplicar produto: " . $e->getMessage()));
        }

        exit($this->renderApiResponse(200, "Produto duplicado com sucesso.", ['newProductId' => $newProductId]));
    }

    public function deleteProduct($post) {
        $productId = $post['productId'] ?? 0;
        $store = $this->getUser()['loja_id'] ?? 0; 
        $stockModel = new Stock();
        $product = $stockModel->getProductById($productId, $store);
        if (empty($store)) exit($this->renderApiResponse(400, "Loja não encontrada."));
        if (empty($product)) exit($this->renderApiResponse(400, "Produto não encontrado."));
        
        try {
            $stockModel->deleteProduct($productId, $store);
            $stockModel->deleteProductCategories($productId, $store);
            $this->deleteFile('uploads/products/'.$productId.'/thumbnail.'. pathinfo($product['thumbnail'], PATHINFO_EXTENSION));
        } catch (Exception $e) {
            exit($this->renderApiResponse(500, "Erro ao excluir produto: " . $e->getMessage()));
        }

        exit($this->renderApiResponse(200, "Produto excluído com sucesso."));
    }
}