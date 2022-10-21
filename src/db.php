<?php
// --------11/9--------

namespace Eraasoft\Db;

class db
{
    public $connection;
    public $sql;
    public function __construct($server, $user, $pass, $db)
    {
        $this->connection = mysqli_connect($server, $user, $pass, $db);
    }
    public function select($table, $columns)
    {
        $this->sql = "SELECT $columns FROM  `$table`";
        return $this;
    }
    public function delete($table)
    {
        $this->sql = "DELETE FROM `$table`";
        return $this;
    }
    public function insert($table, $data)
    {
        $keys = array_keys($data);
        $columns = implode(',', $keys);

        $values = '';
        foreach ($data as $value) {
            $values .= " '$value',";
        }
        $values = rtrim($values, ",");
        $this->sql = "INSERT INTO `$table`($columns) VALUES ($values)";

        return $this;
    }
    public function update($table, $data)
    {
        $updateColumnAndValue = "";
        foreach ($data as $key => $value) {
            $updateColumnAndValue .= " `$key` = '$value',";
        }
        $updateColumnAndValue = rtrim($updateColumnAndValue, ",");
        $this->sql = "UPDATE `$table` SET  $updateColumnAndValue";
        return $this;
    }
    public function where($column, $operator, $value)
    {
        $this->sql .= " WHERE `$column` $operator  '$value'";
        return $this;
    }
    public function andWhere($column, $operator, $value)
    {
        $this->sql .= " AND `$column` $operator  '$value'";
        return $this;
    }
    public function orWhere($column, $operator, $value)
    {
        $this->sql .= " OR `$column` $operator  '$value'";
        return $this;
    }
    public function all()
    {
        $query = mysqli_query($this->connection, $this->sql);
        return mysqli_fetch_all($query, MYSQLI_ASSOC);
    }
    public function first()
    {
        $query = mysqli_query($this->connection, $this->sql);
        return mysqli_fetch_assoc($query);
    }
    public function execute()
    {
        mysqli_query($this->connection, $this->sql);
        return mysqli_affected_rows($this->connection);
    }
}