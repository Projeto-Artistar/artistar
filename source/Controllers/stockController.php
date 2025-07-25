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
}