<?php
class Database
{
    private $connect;

    public function connect()
    {
        try {
            $this->connect = new PDO(
                "sqlsrv:Server=localhost\\SQLEXPRESS;Database=web_database;Encrypt=true;TrustServerCertificate=true",
                "sa",
                "@Bina0608"
            );

            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->connect;

        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}
?>