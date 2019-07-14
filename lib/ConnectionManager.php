<?
/*******************************
 * Connection manager for all 
 * database connections in the program
 * it keeps singleton connections in
 * a master array.
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 6/11/09
 ******************************/
require_once 'mysqlConnectionSingleton.php';

final class ConnectionManager {
    private static $connections = array();

    private function __construct() {
    }

    private function __clone() {
    }

    public function __destruct() {
        foreach (self::$connections as $connection) {
            $connection->close();
        }
    }

    public function getmysqlConnection($host, $db, $user = null, $pass = null) {
        if (!isset(self::$connections[$host][$db])) {
            self::$connections[$host][$db] = mysqlConnectionSingleton::openConnection($host, $db, $user, $pass);
        }
        return self::$connections[$host][$db];
    }

    public function getsybaseConnection($host, $db, $user = null, $pass = null) {
       throw new Exception('Sybase connection not implemented yet'); 
    }
}
?>
