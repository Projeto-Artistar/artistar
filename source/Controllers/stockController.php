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
        $search = $_GET['search'] ?? [];
        $pagination = $_GET['pagination'] ?? [
            'offset' => 0
        ];
        $pagination['limit'] = 12;

        $stocks = $stockModel->getStocks($store);

        $pages = [
            'current' => ($pagination['offset'] / $pagination['limit']) + 1,
            'total' => ceil($stocks['totalProducts'] / $pagination['limit'])
        ];

        echo $this->view->render("stock/home", [
            'layout' => [
                'title' =>  'Stock - Artistar', 
                'logado' => $this->getLogado(),
                'header' => true,
                'footer' => true
            ],
            'stocks' => $stocks,
            'categories' => $stockModel->getCategories($store),
            'products' => $stockModel->getProducts($store, $pagination, $search),
            'pagination' => $pagination,
            'pages' => $pages,
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
        if (empty($insertData['produto_nome']) || empty($insertData['produto_valor'])) {
            exit($this->renderApiResponse(400, "Nome e preço do produto são obrigatórios."));
        }
        $productId = $stockModel->insertProduct($insertData);
        if (!$productId) {
            exit($this->renderApiResponse(500, "Erro ao inserir produto."));
        } else {
            $categories = $post['category'] ?? [];
            $remainingCategories = $stockModel->insertExistingCategories($categories, $store, $productId);
            $stockModel->insertNewStoreCategories($remainingCategories, $productId, $store);
            $post['thumbnail'] = $this->moveFile($_FILES['thumbnail']['tmp_name'] ?? '', 'uploads/products/'.$productId.'/thumbnail.'. pathinfo($_FILES['thumbnail']['name'] ?? '', PATHINFO_EXTENSION));
            $stockModel->updateThumbnail($post['thumbnail'], $productId);
        }
        exit($this->renderApiResponse(200, "Produto inserido com sucesso.", ['productId' => $productId]));

    }
}