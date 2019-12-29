<?php
namespace KGaming\Core;

class Model implements ModelInterface
{
    private static $conn = null;
    protected $table;
    protected $pkey;
    protected $query = '';
    protected $props = [];

    public function __construct($table, $pkey = 'id')
    {
        $db = new Dbo();
        self::$conn = $db->getConnection();
        $this->table = $table;
        $this->pkey = $pkey;
    }

    public function __destruct()
    {
        self::$conn = null;
    }

    public function find()
    {
        $this->query = "SELECT * FROM `{$this->table}`";
        return $this;
    }

    public function where($where)
    {
        $this->query .= " WHERE {$where}";
        return $this;
    }

    public function limit($limit)
    {
        $this->query .= " LIMIT {$limit}";
        return $this;
    }

    public function offset($offset)
    {
        $this->query .= " OFFSET {$offset}";
        return $this;
    }

    public function fetch()
    {
        $stmt = self::$conn->prepare($this->query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return count($results) ? $results : false;
    }

    public function get($id)
    {
        $this->query = "SELECT * FROM {$this->table} WHERE `{$this->pkey}`='{$id}'";
        return $this;
    }

    public function set($k, $v)
    {
        $this->props[$k] = $v;
        return $this;
    }

    public function remove($id)
    {
        $this->query = "DELETE FROM {$this->table} WHERE `{$this->pkey}`={$id}";
        return $this;
    }

    public function update($id)
    {
        $set_index = 0;
        $sets = '';
        foreach($this->props as $field=>$value)
        {
            if($set_index > 0)
            {
                $sets .= ',';
            }
            $sets .= "`{$field}`='{$value}'";
            $set_index++;
        }
        $this->query = "UPDATE {$this->table} SET {$sets}";
        $this->query .= " WHERE `{$this->pkey}`='$id'";
        return $this->exec();
    }

    public function exec()
    {
        $stmt = self::$conn->prepare($this->query);
        $stmt->execute();
        return $this;
    }

    public function save()
    {
        $keys = array_keys($this->props);
        $fields = '';
        $vals = '';
        $key_index = 0;
        foreach($keys as $key)
        {
            if ($key_index >0)
            {
                $fields .= ',';
                $vals .= ',';
            }
            $fields .= $key;
            $vals .= ":{$key}";
            $key_index++;
        }
        $this->query = "INSERT INTO {$this->table} ({$fields}) VALUES ({$vals})";
        return $this->exec();
    }
}
