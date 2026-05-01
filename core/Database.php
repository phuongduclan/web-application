<?php
class Database
{
    private $connect;

    public function connect()
    {
        try {
            $this->connect = new PDO(
                "sqlsrv:Server=localhost\\SQLEXPRESS;Database=web_database;Encrypt=true;TrustServerCertificate=true",
                array(
                    PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8,
                )
            );

            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connect->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);

            return $this->connect;

        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
}
?>
