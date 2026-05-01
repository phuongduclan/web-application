<?php
class BaseModel extends Database
{
    protected $connect;

    public function __construct()
    {
        $this->connect = $this->connect();
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM {$table}";
        return $this->executeQuery($sql);
    }

    public function findById($table, $id)
    {
        $sql = "SELECT * FROM {$table} WHERE id = ?";
        return $this->executeQuery($sql, array((int) $id))[0] ?? null;
    }

    public function create($table, array $data = array())
    {
        if (empty($data)) {
            return false;
        }
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO {$table}({$columns}) VALUES({$placeholders})";
        return $this->executeNonQuery($sql, array_values($data));
    }

    public function update($table, $id, $data)
    {
        if (empty($data)) {
            return false;
        }
        $sets = array();
        foreach (array_keys($data) as $key) {
            $sets[] = "{$key} = ?";
        }
        $sql = "UPDATE {$table} SET " . implode(',', $sets) . " WHERE id = ?";
        $params = array_values($data);
        $params[] = (int) $id;
        return $this->executeNonQuery($sql, $params);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM {$table} WHERE id = ?";
        return $this->executeNonQuery($sql, array((int) $id));
    }

    protected function executeQuery($sql, array $params = array())
    {
        $stmt = $this->connect->prepare($sql);
        $this->bindParams($stmt, $params);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function executeNonQuery($sql, array $params = array())
    {
        $stmt = $this->connect->prepare($sql);
        $this->bindParams($stmt, $params);
        return $stmt->execute();
    }

    /**
     * Bind every parameter explicitly so string params are sent as UTF-8
     * to NVARCHAR columns. Without this, pdo_sqlsrv uses SQLSRV_ENCODING_CHAR
     * (Windows-1252) by default and Vietnamese characters become "?".
     */
    private function bindParams($stmt, array $params)
    {
        // Hold references because bindParam takes by-reference.
        static $refs;
        $refs = array();
        $i = 1;
        foreach ($params as $key => $value) {
            $refs[$key] = $value;
            if (is_int($value)) {
                $stmt->bindParam($i, $refs[$key], PDO::PARAM_INT);
            } elseif (is_bool($value)) {
                $stmt->bindParam($i, $refs[$key], PDO::PARAM_BOOL);
            } elseif (is_null($value)) {
                $stmt->bindValue($i, null, PDO::PARAM_NULL);
            } else {
                $refs[$key] = (string) $value;
                $stmt->bindParam(
                    $i,
                    $refs[$key],
                    PDO::PARAM_STR,
                    0,
                    PDO::SQLSRV_ENCODING_UTF8
                );
            }
            $i++;
        }
    }
}
?>
