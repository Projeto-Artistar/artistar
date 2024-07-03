<?php

require_once 'core.php';

class Events extends Core {

    public function listEvents() {
        $query = 'SELECT * FROM art_event';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}