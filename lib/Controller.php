<?php
/*******************************
 * Generic controller class
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 7/12/10
 ******************************/

require_once 'View.php';

abstract class Controller {
    protected $_view = null;

    public function __construct() {
        
    }
}
?>
