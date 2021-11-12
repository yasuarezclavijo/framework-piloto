<?php 

class Models {
    protected $connection;
    protected $table_name;
    public function __construct() {
        try {
            # Conexión a MySQL
            $this->connection = new \PDO("mysql:host=localhost;dbname=sakila", "root", "");
        } catch(\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function get_query($fields, $whereConditions = [], $limit = [], $order = []) {
        $str_query = "SELECT ";
        foreach ($fields as $field) {
            $str_query = $str_query . $field . ", ";
        }
        $str_query = substr($str_query, 0, -2);
        $str_query = $str_query . " FROM " . $this->table_name;
        if (count($limit) > 0) {
            $str_query = $str_query . " LIMIT {$limit[0]}, {$limit[1]}";
        }
        return $this->connection->query($str_query, \PDO::FETCH_ASSOC);
    }
}