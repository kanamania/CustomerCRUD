<?php
class DB
{
    public $conn = null;

    public function __construct($config)
    {
        $this->conn = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
        if (!$this->conn) die('Database connection could not be established');
    }

    public function get($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = $id";
        return $this->query($sql);
    }

    public function getAll($table, $cols = null, $filter = null, $order = null)
    {
        $columns = "*";
        if ($cols) {
            $columns = [];
            foreach ($cols as $col) {
                $columns[] = $col;
            }
            $columns = implode(', ', $columns);
        }
        $sql = "SELECT $columns FROM $table WHERE 1 = 1 ";
        if ($filter) {
            $filtered = [];
            foreach ($data as $column => $val) {
                $filtered[] = $column . ' = "' . $val . '"';
            }
            $filtered = implode(', ', $filtered);
            $sql .= $filtered;
        }

        return $this->query($sql);

    }

    public function insert($table, $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = '"' . implode('", "', array_values($data)) . '"';
        $sql = 'insert into ' . $table . ' (' . $keys . ') values (' . $values . ')';
//        pre($sql, 1);
        return $this->execute($sql);

    }

    public function update($table, $id, $data)
    {
        $updateClause = [];
        foreach ($data as $iid => $val) {
            $updateClause[] = $iid . ' = "' . $val . '"';
        }
        $updateClause = implode(', ', $updateClause);
        $sql = 'update ' . $table . ' set ' . $updateClause . ' where id = "' . $id . '"';
        return $this->execute($sql);

    }

    public function delete($table, $id, $soft = true)
    {
        $sql = $soft ?
            "UPDATE $table  SET is_deleted = 1 WHERE id = $id" :
            "DELETE FROM $table WHERE id = $id ";
        return $this->execute($sql);
    }

    public function restore($table, $id)
    {
        $sql = "UPDATE $table  SET is_deleted = 0 WHERE id = $id";
        return $this->execute($sql);
    }

    public function query($sql)
    {
        $results = $this->conn->query($sql);
        return $results ? $results->fetch_all(MYSQLI_ASSOC) : false;
    }

    public function execute($sql)
    {
        return $this->conn->query($sql);
    }
    public function count($table)
    {
        $sql = "SELECT * FROM $table";
        $results = $this->conn->query($sql);
        return $results->num_rows;
    }

}
