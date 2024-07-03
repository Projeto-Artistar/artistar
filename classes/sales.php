<?php

require_once 'core.php';

class Sales extends Core {

    public function listSales() {
        $query = '
            SELECT 
                * 
            FROM 
                art_sale sale
            LEFT JOIN
                art_user user ON sale.art_sale_user = user.art_user_id
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function saveSale() {
        $query = '
            INSERT INTO 
                art_sale (
                    art_sale_user, 
                    art_sale_price
                ) 
            VALUES 
                (
                    :art_sale_user,
                    :art_sale_price
                )
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':art_sale_user', $_POST['user']);
        $total = str_replace(',', '.', str_replace('R$', '', $_POST['total']));
        $stmt->bindValue(':art_sale_price', $total);
        $stmt->execute();
    }
}