<?php

namespace Source\Core;

use PDO;
use PDOException;

class Model {

    protected $data;
    
    protected $fail;

    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value;
    }

    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    public function fail(): ?\PDOException 
    {
        return $this->fail;
    }

    protected function create(string $entity, array $data): ?int
    {
        try {
            
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO {$entity} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data));

            return Connect::getInstance()->lastInsertId();

        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    protected function read(string $select, string $params = null): ?\PDOStatement
    {
        try {
            $stmt = Connect::getInstance()->prepare($select); 
            if ($params) {
                parse_str($params, $paramsArr);
                foreach($paramsArr as $key => $value) {
                    if ($key == 'limit' || $key == 'offset') {
                        $stmt->bindValue(":{$key}", $value, PDO::PARAM_INT);
                    }else {
                        $stmt->bindValue(":{$key}", $value, PDO::PARAM_STR);
                    }
                }
            }

            $stmt->execute();
            return $stmt;

        } catch (PDOException $e) {
            $this->fail = $e;
        }
    }

    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        foreach (static::$safe as $unset) { 
            unset($safe[$unset]);
        }
        return $safe;
    }

    protected function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }

        return $filter;
    }
}