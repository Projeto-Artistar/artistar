<?php


namespace Source\Core\BackCode;

use PDO;

class Start
{

    public function __construct()
    {
        global $db;
        $this->error = 'Error: ';
        $this->db=$db;
    }

    public function db_select($queryString, $param = array()){

        try {
            $query = $this->db->prepare($queryString);
            $query->execute($param);

            return $query->fetchall(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

    public function db_select_one($queryString, $param = array()){

        try {
            $query = $this->db->prepare($queryString);
            $query->execute($param);

            return $query->fetchall(PDO::FETCH_ASSOC)[0];
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

    public function db_update($table, $param, $cond){

        $set = [];

        foreach($param as $k => $v) {

            if (!empty($k)) {

                if (is_string($v)) {
                    $set[] = "$k = '$v'";
                } else {
                    $set[] = "$k = $v";
                }

            }

        }

        $where = [];

        foreach($cond as $k => $v) {

            if (!empty($k)) {

                if (is_string($v)) {
                    $where[] = "$k = '$v'";
                } else {
                    $where[] = "$k = $v";
                }
                
            }

        }

        try {
            $query = $this->db->prepare('        
                UPDATE
                    :table
                SET
                    :set
                WHERE
                    :where
            ');
            $query->execute([
                ':table' => $table,
                ':set' => implode(' , ', $set),
                ':where' => implode(' AND ', $where)

            ]);

            return true;
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

    public function db_update_in($table, $param, $cond){

        $set = [];

        foreach($param as $k => $v) {

            if (!empty($k)) {

                if (is_string($v)) {
                    $set[] = "$k = '$v'";
                } else {
                    $set[] = "$k = $v";
                }
            }

        }

        $where = [];

        foreach($cond as $k => $v) {

            if (!empty($k)) {

                if (is_array($v)) {

                    $values = array();

                    foreach($v as $v2) {

                        if (is_string($v2)) {
                            $values[] = "'$v2'";
                        } else {
                            $values[] = $v2;
                        }
                    }

                    $value = implode(', ', $values);

                } else {

                    if (is_string($v)) {
                        $value = "'$v'";
                    } else {
                        $value = $v;
                    }

                }
                
                $where[] = "$k IN ($value)";
                
            }

        }

        try {
            $query = $this->db->prepare('        
                UPDATE
                    :table
                SET
                    :set
                WHERE
                    :where
            ');
            $query->execute([
                ':table' => $table,
                ':set' => implode(' , ', $set),
                ':where' => implode(' AND ', $where)

            ]);

            return true;
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

    public function db_insert($table, $param){

        try {
            $query = $this->db->prepare('        
                INSERT INTO :table (
                    :columns
                ) VALUES (
                    :values
                )
            ');
            $query->execute([
                ':table' => $table,
                ':colums' => implode(", ", array_keys($param)),
                ':values' => implode(", ", array_values($param))

            ]);

            return $query->lastInsertId();
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

    public function db_delete($table, $cond){

        $where = [];

        foreach($cond as $k => $v) {

            if (!empty($k)) {

                if (is_string($v)) {
                    $where[] = "$k = '$v'";
                } else {
                    $where[] = "$k = $v";
                }
                
            }

        }

        try {
            $query = $this->db->prepare('        
                DELETE FROM
                    :table
                WHERE
                    :where
            ');
            $query->execute([
                ':table' => $table,
                ':where' => implode(' AND ', $where)

            ]);

            return true;
        } catch (PDOException $e) {
            echo $this->error . $e->getMessage();
        }
    }

}