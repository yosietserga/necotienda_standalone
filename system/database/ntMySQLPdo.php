<?php

class ntMySQLPdo {
    private $pdo = null;
    private $statement = null;
    public function __construct($hostname, $username, $password, $database, $port = '3306') {
        try {
            $this->pdo = new \PDO("mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . $database, $username, $password, array(\PDO::ATTR_PERSISTENT => true));
        } catch(\PDOException $e) {
            echo $e->getMessage();
            throw new \Exception('Unknown database \'' . $database . '\'');
            exit();
        }
        $this->pdo->exec("SET NAMES 'utf8'");
        $this->pdo->exec("SET CHARACTER SET utf8");
        $this->pdo->exec("SET CHARACTER_SET_CONNECTION=utf8");
        $this->pdo->exec("SET SQL_MODE = ''");
    }
    public function prepare($sql) {
        $this->statement = $this->pdo->prepare($sql);
    }

    public function getVersion() {
        preg_match('/[0-9]\.[0-9]+\.[0-9]+/', $this->pdo->query('select version()')->fetchColumn(), $version);
        return $version[0];
    }

        public function bindParam($parameter, $variable, $data_type = \PDO::PARAM_STR, $length = 0) {
            if ($length) {
                $this->statement->bindParam($parameter, $variable, $data_type, $length);
            } else {
                $this->statement->bindParam($parameter, $variable, $data_type);
            }
        }

        public function execute() {
            try {
                if ($this->statement && $this->statement->execute()) {
                    $data = array();
                    while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    $result = new \stdClass();
                    $result->row = (isset($data[0])) ? $data[0] : array();
                    $result->rows = $data;
                    $result->obj = $this->arrayToObj($data, new stdClass());
                    $result->num_rows = $this->statement->rowCount();
                }
            } catch(\PDOException $e) {
                trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode());
            }
        }

        public function query($sql, $params = array()) {
            $this->statement = $this->pdo->prepare($sql);
            $result = false;
            try {
                if ($this->statement && $this->statement->execute($params)) {
                    $data = array();
                    while ($row = $this->statement->fetch(\PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    $result = new \stdClass();
                    $result->row = (isset($data[0]) ? $data[0] : array());
                    $result->rows = $data;
                    $result->obj = $this->arrayToObj($data, new stdClass());
                    $result->num_rows = $this->statement->rowCount();
                }
            } catch (\PDOException $e) {
                trigger_error('Error: ' . $e->getMessage() . ' Error Code : ' . $e->getCode() . ' <br />' . $sql);
                exit();
            }
            if ($result) {
                return $result;
            } else {
                $result = new \stdClass();
                $result->row = array();
                $result->rows = array();
                $result->num_rows = 0;
                $result->obj = $this->arrayToObj(array(), new stdClass());
                return $result;
            }
        }

        public function escape($value) {
            return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $value);
        }

        public function countAffected() {
            if ($this->statement) {
                return $this->statement->rowCount();
            } else {
                return 0;
            }
        }

        public function getLastId() {
            return $this->pdo->lastInsertId();
        }

        public function __destruct() {
            $this->pdo = null;
        }

        public function arrayToObj($array, &$obj) {
            if (!is_object($obj)) $obj = new stdClass();
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
    /*
    */
}