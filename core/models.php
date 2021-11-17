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

    /**
     * Metodo encargado de generar query dinamico hacia la base de datos.
     * @param $fields
     *    Arreglo encargado de traer los campos que requiere devolver la consulta.
     * @param $whereConditions
     *    Areglo multidimensional en donde todos los arreglos de la segunda dimensión deberian verse asi:
     *    ['field' => 'example_field', 'value' => 'value_to_compare', 'operator' => '>=', 'logical_operator']
     */
    public function get_query($fields, $whereConditions = [], $limit = [], $order = []) {
        $str_query = "SELECT ";
        foreach ($fields as $field) {
            $str_query = $str_query . $field . ", ";
        }
        $str_query = substr($str_query, 0, -2);
        $str_query = $str_query . " FROM " . $this->table_name;
        /**
         * Funcionalidad propia para where.
         */
        if (count($whereConditions) > 0) {
            $conditions = " WHERE ";
            foreach ($whereConditions as $condition) {
                $conditions .= "{$condition['field']} {$condition['operator']} '{$condition['value']}'";
                if (isset($condition['logical_operator'])) {
                    $conditions .= " {$conditions['logical_operator']}";
                }
            }
            $str_query = $str_query . $conditions;
        }
        if (count($limit) > 0) {
            $str_query = $str_query . " LIMIT {$limit[0]}, {$limit[1]}";
        }
        return $this->connection->query($str_query, \PDO::FETCH_ASSOC);
    }

    /**
     * @param $fields
     *   Arreglo con la información que se pretende almacenar en la tabla, llave correspondera al nombre del campo y el value al valor que se quiere ingresar.
     */
    public function insert_data($fields) {
        $fields_table = "";
        $values_table = "";
        foreach ($fields as $field => $value) {
            $fields_table = $fields_table . $field . ",";
            $values_table = $values_table . "'{$value}',";
        }
        $fields_table = substr($fields_table, 0, -1);
        $values_table = substr($values_table, 0, -1);
        $str_insert = "INSERT INTO {$this->table_name}($fields_table) VALUES ($values_table);";
        return $this->connection->query($str_insert);
    }

    public function update_data($fields, $condition) {
        $new_fields = "";
        foreach ($fields as $field => $value) {
            $new_fields .= "{$field} = '{$value}',";
        }
        $new_fields = substr($new_fields, 0, -1);
        $str_update = "UPDATE {$this->table_name} SET {$new_fields} WHERE {$condition}";
        return $this->connection->query($str_update);
    }

    public function delete_data($condition) {
        $str_delete = "DELETE FROM {$this->table_name} WHERE {$condition}";
        return $this->connection->query($str_delete);
    }
}