<?php
//abstract not allowe to instace an object of type Model
abstract class Model{

    protected static string $table;
    protected static string $primary_key = "id";

    public static function find(mysqli $connection, int $id){
        $sql = sprintf("SELECT * from %s WHERE %s = ?",
                       static::$table,
                       static::$primary_key);

        $query = $connection->prepare($sql);
        $query->bind_param("i", $id);
        $query->execute();               

        $data = $query->get_result()->fetch_assoc();

        return $data ? new static($data) : null;
    }

    // public static function findAll(mysqli $connection){
    //     //implement this
    // }

    public static function findAll(mysqli $connection){
    $sql = sprintf("SELECT * FROM %s", 
    static::$table);
    
    $query = $connection->prepare($sql);
    $query->execute();

    $result = $query->get_result();
    $objects = [];

    while($data = $result->fetch_assoc()){
        $objects[] = new static($data);
    }

    return $objects;
}

}





?>
