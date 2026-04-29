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
    public function findById($table,$id)
    {
        $sql="SELECT  * FROM {$table} WHERE id = ? ";
        $stmt=$this->connect->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // INSERT INTO Table(table_id, table_name, description) VALUES (?,?,?)
    public function create($table, array $data=[])
    {
        $columns = implode(',', array_keys($data));
        $values=array_map(function($value){
            if(is_string($value))
            {
                return "'".$value."'";
            }
            else
            {
                return $value;
            }
        },array_values($data));
        $values=implode(',', $values);
        $sql="INSERT INTO {$table}({$columns}) VALUES({$values})";
        return $this->executeNonQuery($sql);
    }
    // Update Table SET table_name
    public function update($table, $id, $data)
    {
        $set = [];
        foreach($data as $key => $value){
            array_push($set, "{$key} = '$value'");
        }
        $data = implode(',',$set);
        $sql = "UPDATE $table SET $data WHERE id = $id";
        return $this->executeNonQuery($sql);
    }
    public function delete($table, $id)
    {
        $sql="DELETE FROM {$table} WHERE id={$id}";
        return $this->executeNonQuery($sql);
    }
    protected function executeQuery($sql,array $params=[])
    {
        $stmt=$this->connect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    protected function executeNonQuery($sql, array $params = [])
    {
        $stmt = $this->connect->prepare($sql);
        return $stmt->execute($params);
    }
}
?>