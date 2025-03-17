<?php
class DB {
    private $connection;
    private static $db;

    public static function getInstance($option = null) {
        if (self::$db === null) {
            self::$db = new Db($option);
        }
        return self::$db;
    }

    public function __construct($option = null) {
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $name = 'db_name';
        $dsn = "mysql:host=$host;dbname=$name;charset=utf8";

        try {
            $this->connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function safeQuery(&$sql, $data) {
        $stmt = $this->connection->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt;
    }

    public function first($sql, $data = [], $field = null) {
        $records = $this->query($sql, $data);
        if (count($records) === 0) {
            return null;
        }
        return ($field !== null) ? $records[0][$field] : $records[0];
    }

    public function modify($sql, $data = []) {
        $stmt = $this->safeQuery($sql, $data);
        return $stmt->rowCount();
    }

    public function insert($sql, $data = []) {
        $stmt = $this->safeQuery($sql, $data);
        return $this->connection->lastInsertId();
    }

    public function query($sql, $data = []) {
        $stmt = $this->safeQuery($sql, $data);
        return $stmt->fetchAll();
    }

    public function connection() {
        return $this->connection;
    }

    public function close() {
        $this->connection = null;
    }
}
