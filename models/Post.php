<?php

class Post {
    private $conn;
    private $table = "posts";

    public $id,
           $category_id,
           $category_name,
           $title,
           $body,
           $author,
           $created_at;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = ' SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '.$this->table.' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single_post() {
        $query = ' SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '.$this->table.' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = :post_id
            LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            "post_id" => $this->id
        ]);

        $row = $stmt->fetch();
        // Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        $this->created_at = $row['created_at'];
    }
    
    public function create_post() {
        $query = 'INSERT INTO ' .$this->table .'
            SET 
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
        ' ;

        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        $inserted = $stmt->execute([
            'title' => $this->title,
            'body' => $this->body,
            'author' => $this->author,
            'category_id' => $this->category_id
        ]);

        if($inserted) {
            return true;
        }

        // Print error
        printf("Error : %s\n", $stmt->error);
        return false;
    }

    public function update_post() {
        $query = 'UPDATE ' .$this->table .'
            SET 
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id';

        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $updated = $stmt->execute([
            'title' => $this->title,
            'body' => $this->body,
            'author' => $this->author,
            'category_id' => $this->category_id,
            'id' => $this->id
        ]);

        if($updated) {
            return true;
        }

        // Print error
        printf("Error : %s\n", $stmt->error);
        return false;
    }

    public function delete_post() {
        $query = 'DELETE FROM ' .$this->table .'
            WHERE
                id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $deleted = $stmt->execute([
            'id' => $this->id
        ]);

        if($deleted) {
            return true;
        }

        // Print error
        printf("Error : %s\n", $stmt->error);
        return false;

    }
}