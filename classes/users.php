<?php

require_once 'core.php';

class Users  extends Core {

    public function listUsers() {
        $query = 'SELECT * FROM art_user';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}