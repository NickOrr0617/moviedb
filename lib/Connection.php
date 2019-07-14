<?
/*******************************
 * Connection interface sets up
 * what should be common on all
 * connection objects
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 6/11/09
 ******************************/

interface iConnection {
    public static function openConnection($host, $db, $user, $pass);
    public static function close();
}
?>
