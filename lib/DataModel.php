<?php
/*******************************
 * Generic data model class used
 * for modeling db tables as objects
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 6/11/09
 ******************************/

require_once 'ConnectionManager.php';

abstract class DataModel {
    protected $connection = null;
    protected $columns = array();
    protected $sqlColumns = null;
    protected $tablename = null;

    protected function __construct() {
        $this->sqlColumns = implode(',', $this->columns);
    }

    protected function openConnection($host, $db, $user, $pass) {
        if ($this->connection == null) {
            $this->connection = ConnectionManager::getmysqlConnection($host, $db, $user, $pass);
        }
    }

    public function getEnumValues($col) {
        if (!in_array($col, $this->columns)) {
            throw new DBException('Column: ' . $col . ' does not exist in Table: ' . $this->tablename);
        }
        $sql = 'SHOW COLUMNS FROM `' . $this->tablename . '` LIKE \''.$col.'\';';

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $col = $stmt->fetch(PDO::FETCH_ASSOC);
        if('YES' == $col['Null']) {
            $values[''] = '';
        }
        foreach(explode("','", str_replace(array("enum('", "')"), array('', ''), $col['Type'])) as $value) {
            $values[$value] = $value;
        }
		
		return $values;
    }

    public function fetchAll($limit = PHP_INT_MAX) {
        return $this->connection->query('SELECT ' . $this->sqlColumns . ' FROM ' . $this->tablename . ' LIMIT ' . $limit)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchById($id) {
        $sql = 'SELECT ' . $this->sqlColumns . ' FROM ' . $this->tablename . ' WHERE id = :id LIMIT 1';
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($fields, $params, $order = null, $limit = PHP_INT_MAX) {
        $sql = 'SELECT ';
        if (is_array($fields)) {
            $sql .= implode(', ', $fields);
        } else {
            $sql .= $fields;
        }
        $sql .= ' FROM ' . $this->tablename;

        if (($params != null) && (is_array($params))) {
            $sql .= ' WHERE ';
            foreach ($params as $column => $value) {
                $sql .= $column . ' = :' . $column . ' AND ';
            }
            $sql = substr($sql, 0,  strripos($sql, ' AND '));
        }

        if ($order) { $sql .= ' ORDER BY ' . $order; }

        $sql .= ' LIMIT ' . $limit;

        
        //Logger::LogMessage('Query: ' . $sql . "\n" . 'Parameters: ' . var_export($params, true) . "\n");
        $stmt = $this->connection->prepare($sql);
        if (($params != null) && (is_array($params))) {
            foreach ($params as $column => $value) {
                $stmt->bindValue(':' . $column, $value, PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($values, $exclude = array()) {
        $cols = $this->sqlColumns;
        if (is_array($exclude)) {
            $cols = explode(',', $cols);
            foreach ($exclude as $e) {
                if (in_array($e, $cols)) {
                    foreach ($cols as $k => $v) {
                        if ($v == $e) {
                            unset($cols[$k]);
                            break;
                        }
                    }
                }
                //$cols = str_replace($e.',', '', $cols);
            }
            $cols = implode(',', $cols);

        } else if ($exclude != null) {
            $cols = str_replace($exclude.',', '', $cols);
        }
        $sql = 'INSERT INTO ' . $this->tablename . '(' . $cols . ') VALUES (:' . str_replace(',', ',:', $cols) . ')';

        Logger::LogMessage('Query: ' . $sql . "\n" . 'Parameters: ' . var_export($values, true) . "\n");
        $stmt = $this->connection->prepare($sql);
        if (($values != null) && (is_array($values))) {
            foreach ($values as $column => $value) {
                if (in_array($column, $this->columns)) {
                    $stmt->bindValue(':' . $column, $value, PDO::PARAM_STR);
                }
            }
        }

        $stmt->execute();
		return $this->connection->lastInsertId();
    }

    public function update($values) {
        $columns = '';
        foreach ($values as $c => $v) {
            if ($c != 'id') {
                $columns .= $c . ' = :' . $c . ', ';
            }
        }
        $columns = substr($columns, 0, strlen($columns) - 2);
        $sql = 'UPDATE ' . $this->tablename . ' SET ' . $columns . ' WHERE id = :id';

        Logger::LogMessage('Query: ' . $sql . "\n" . 'Parameters: ' . var_export($values, true) . "\n");
        $stmt = $this->connection->prepare($sql);
        if (($values != null) && (is_array($values))) {
            foreach ($values as $column => $value) {
                if (in_array($column, $this->columns)) {
                    $stmt->bindValue(':' . $column, $value, PDO::PARAM_STR);
                }
            }
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = 'DELETE FROM ' . $this->tablename . ' WHERE id = :id';

        Logger::LogMessage('Query: ' . $sql . "\n" . 'Parameters: ' . var_export($id, true) . "\n");
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function query($sql, $datapoints = null, $fetch = true) {
        $stmt = $this->connection->prepare($sql);
        if (($datapoints != null) && (is_array($datapoints))) {
            foreach ($datapoints as $column => $value) {
                $stmt->bindValue(':' . $column, $value, (int)$value===$value?PDO::PARAM_INT:PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        if (true === $fetch) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}

class DBException extends Exception {
}
?>
