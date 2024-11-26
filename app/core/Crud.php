<?php

namespace Core;

use PDO;
use PDOException;

class Crud
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }

    public function read($table, $conditions = [])
    {
        $sql = "SELECT * FROM $table";

        if (!empty($conditions)) {
            $conditionString = [];
            foreach ($conditions as $key => $value) {
                $conditionString[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(" AND ", $conditionString);
        }

        $stmt = $this->db->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $conditions)
    {
        $setString = [];
        foreach ($data as $key => $value) {
            $setString[] = "$key = :$key";
        }

        $conditionString = [];
        foreach ($conditions as $key => $value) {
            $conditionString[] = "$key = :cond_$key";
        }

        $sql = "UPDATE $table SET " . implode(", ", $setString) . " WHERE " . implode(" AND ", $conditionString);
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":cond_$key", $value);
        }

        return $stmt->execute();
    }

    public function delete($table, $conditions)
    {
        $conditionString = [];
        foreach ($conditions as $key => $value) {
            $conditionString[] = "$key = :$key";
        }

        $sql = "DELETE FROM $table WHERE " . implode(" AND ", $conditionString);
        $stmt = $this->db->prepare($sql);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute();
    }
}
