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

public static function update(mysqli $connection, int $id, array $data) {
    $sql = "UPDATE " . static::$table . " SET name = ?, year = ?, color = ? WHERE " . static::$primary_key . " = ?";

    $query = $connection->prepare($sql);
    $query->bind_param("sssi", $data["name"], $data["year"], $data["color"], $id);

    return $query->execute();
}

public static function delete(mysqli $connection, int $id) {
    $sql = "DELETE FROM " . static::$table . " WHERE " . static::$primary_key . " = ?";

    $query = $connection->prepare($sql);
    $query->bind_param("i", $id);

    return $query->execute();
}

public static function create(mysqli $connection, array $data) {
    $sql = "INSERT INTO " . static::$table . " (name, year, color) VALUES (?, ?, ?)";

    $query = $connection->prepare($sql);
    $query->bind_param("sss", $data["name"], $data["year"], $data["color"]);

    if($query->execute()){
        // https://www.php.net/manual/en/mysqli.insert-id.php
        // Returns the value generated for an AUTO_INCREMENT column by the last query
        return $connection->insert_id; 
    } else {
        return null;
    }
}



}






?>
