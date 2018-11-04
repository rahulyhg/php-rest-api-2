<?php

$base = pathinfo(__DIR__,PATHINFO_DIRNAME);
include $base . '/config/Database.php';

class Category extends Database {
    private $table = 'categories';
    
    public function __construct() {
        parent::connect();
    }

    public function read() {
        $query = ' SELECT
            id,
            name
        FROM
            categories
        ORDER BY
            created_at DESC
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function create_category($data) {
        $query = ' INSERT INTO '.$this->table.'
            SET
                name = :name
        ';
        $name = htmlspecialchars(strip_tags($data->name));
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['name' => $name]);           
    }

    public function delete_category($id) {
        $query = 'DELETE FROM ' .$this->table. ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'id' => htmlspecialchars(strip_tags($id))
        ]);
    }

    public function update_category($data) {
        $query = ' UPDATE '. $this->table .'
            SET
                name = :name
            WHERE
                id = :id
        ';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'name' => htmlspecialchars(strip_tags($data->name)),
            'id' => htmlspecialchars(strip_tags($data->id))
        ]);
    }
}