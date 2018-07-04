<?php


class ntMySQLi {
    private $link;

    public function __construct($hostname, $username, $password, $database, $port = '3306') {
        $this->link = new \mysqli($hostname, $username, $password, $database, $port);
        if ($this->link->connect_error) {
            if (function_exists('neco_logger')) {
                neco_logger("\nMYSQL Error: Could not make a database link (" . $this->link->connect_error  . ")\nError No: " . $this->link->connect_errno . "\n");
            } else {
                trigger_error('Error: Could not make a database link (' . $this->link->connect_errno . ') ' . $this->link->connect_error);
            }
            
            exit();
        }
        $this->link->set_charset("utf8");
        $this->link->query("SET SQL_MODE = ''");
    }

    public function getVersion() {
        preg_match('/[0-9]\.[0-9]+\.[0-9]+/', $this->link->server_info, $version);
        return $version[0];
    }

    public function query($sql) {
        $query = $this->link->query($sql);
        if (!$this->link->errno) {
            if ($query instanceof \mysqli_result) {
                $data = array();
                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }
                $result = new \stdClass();
                $result->num_rows = $query->num_rows;
                $result->row = isset($data[0]) ? $data[0] : array();
                $result->rows = $data;
                $query->obj = $this->arrayToObj($data, new stdClass());
                $query->close();
                return $result;
            } else {
                return true;
            }
        } else {
            if (function_exists('neco_logger')) {
                neco_logger("\nMYSQL Error: " . $this->link->error  . "\nError No: " . $this->link->errno . "\nSQL Query: " . $sql . "\n");
            } else {
                trigger_error('Error: ' . $this->link->error  . '<br />Error No: ' . $this->link->errno . '<br />' . $sql);
            }
        }
    }

    public function escape($value) {
        return $this->link->real_escape_string($value);
    }

    public function countAffected() {
        return $this->link->affected_rows;
    }

    public function getLastId() {
        return $this->link->insert_id;
    }

    public function __destruct() {
        $this->link->close();
    }

    public function arrayToObj($array, &$obj) {
        if (!is_object($obj))
            $obj = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $obj->$key = new stdClass();
                $this->arrayToObj($value, $obj->$key);
            } else {
                $obj->$key = $value;
            }
        }
        return $obj;
    }
}