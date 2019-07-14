<?php
/*******************************
 * Logging Singleton
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 7/12/10
 ******************************/

class Logger {
    private static $_logfile = '/var/log/invoice.log';
    private static $_file = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function LogMessage($message) {
        date_default_timezone_set('America/Boise');
        if (self::$_file == null) {
            self::$_file = fopen(self::$_logfile, 'a');
        }

        fwrite(self::$_file, date('m/d/Y - H:i:s') . ' - ' .  $message . ' - IP:[' . $_SERVER['REMOTE_ADDR'] . ']' . "\n");
    }
}
?>
