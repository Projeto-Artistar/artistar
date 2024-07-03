<?php

require_once 'core.php';

class Shops extends Core {

    public function listShops() {
        $query = 'SELECT * FROM art_shop';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}