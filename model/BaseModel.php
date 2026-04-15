<?php
class BaseModel extends Database 
{
    protected $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }
    // SELECT * FROM Table
    public function getAll($table)
    {
        $sql="SELECT * FROM {$table}";
        return $this->executeQuery($sql);
    }
    // SELECT * FROM Table WHERE table_id
    public function findById($id)
    {

    }
    // INSERT INTO Table(table_id, table_name, description) VALUES (?,?,?)
    public function store()
    {

    }
    // Update Table SET table_name
    public function update()
    {

    }
    private function executeQuery($sql,array $params=[])
    {
        $stmt=$this->connect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    private function executeNonQuery($sql, array $params = [])
    {
        $stmt = $this->connect->prepare($sql);
        return $stmt->execute($params);
    }
}
?>