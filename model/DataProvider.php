<?php


class DataProvider {
    private static $instance = null;
    private $conn;

    // Singleton
    public static function Instance() {
        if (self::$instance == null) {
            self::$instance = new DataProvider();
        }
        return self::$instance;
    }

    private function __construct() {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            // Hằng số lớp PDO không dùng được với defined('PDO::...') — phải bật UTF-8 như sau:
            if (extension_loaded('pdo_sqlsrv')) {
                $options[PDO::SQLSRV_ATTR_ENCODING] = PDO::SQLSRV_ENCODING_UTF8;
            }
            $this->conn = new PDO(
                "sqlsrv:Server=localhost\\SQLEXPRESS;Database=web_app",
                "sa",
                "@Bina0608",
                $options
            );
            if (extension_loaded('pdo_sqlsrv')) {
                try {
                    $this->conn->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
                } catch (Throwable $e) {
                    // Một số bản driver chỉ nhận encoding lúc khởi tạo; bỏ qua.
                }
            }
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    // SELECT nhiều dòng
    public function ExecuteQuery($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // INSERT / UPDATE / DELETE
    public function ExecuteNonQuery($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    // SELECT 1 giá trị
    public function ExecuteScalar($query, $params = []) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
?>