<?php

class Database
{
    private $mysqli;

    public function __construct($server, $user, $pass, $database) {
        $this->mysqli = new mysqli($server, $user, $pass, $database);
        /* check connection */
        if ($this->mysqli->connect_errno) {
            printf("Was not able to connect to the server: %s\n",
                $this->mysqli->connect_error);
            exit();
        }

        $this->mysqli->set_charset("utf8");
    }

    function __destruct() {
        $this->mysqli->close();
    }

    public function select($table, $what, $additions = ''): array
    {
        $sql = "SELECT $what FROM $table $additions";
        $result = $this->mysqli->query($sql);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row->$what;
        }
        return $data;

    }

    public function delete($table, $where): bool
    {
        if ($this->check($table, $where)) {

            $sql = "DELETE FROM $table WHERE $where";
            if ($this->mysqli->query($sql)) return true;
        }
        return false;
    }

    public function check($table, $where): bool
    {

        $sql = "SELECT 1 FROM $table WHERE $where LIMIT 1";

        $result = $this->mysqli->query($sql);

        return $result && $result->num_rows > 0;
    }
    public function insert($table, $cols, $values): bool
    {

        $sql = "INSERT INTO $table ($cols) VALUES ($values)";

        if ($this->mysqli->query($sql)) return true; else return false;
    }

    function update($table, $set, $where): bool
    {
        $sql = "UPDATE $table SET $set WHERE $where";
        if ($this->mysqli->query($sql)) return true; else return false;
    }
    public function getMysqli(): mysqli
    {
        return $this->mysqli;
    }

    public function escapeString($value): string
    {
        return $this->mysqli->real_escape_string($value);
    }
}





























