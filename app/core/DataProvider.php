class DataProvider {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $config = require __DIR__ . '/../../config/database.php';

        $this->conn = new PDO(
            "sqlsrv:Server={$config['host']};Database={$config['dbname']}",
            $config['username'],
            $config['password']
        );

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function Instance() {
        if (self::$instance == null) {
            self::$instance = new DataProvider();
        }
        return self::$instance;
    }

    public function executeQuery($query, $params = []) {
        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executeNonQuery($query, $params = []) {
        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->rowCount(); // số dòng bị ảnh hưởng
    }
}