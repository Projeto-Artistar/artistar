<?php

require_once 'core.php';

class Products extends Core {

    public function listProducts() {
        $query = 'SELECT * FROM art_product';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}