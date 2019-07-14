<?
/*******************************
 * mysql Connection object
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 6/11/09
 ******************************/
require_once 'Connection.php';

final class mysqlConnectionSingleton implements iConnection {
    private static $connection = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function openConnection($host, $db, $user, $pass) {
        if (self::$connection == null) {
            self::$connection = new PDO('mysql:host=' . $host . ';dbname=' . $db, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$connection;
    }

    public static function close() {
        if (self::$connection != null) {
            self::$connection = null;
        }
    }
}
?>
