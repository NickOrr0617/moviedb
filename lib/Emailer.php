<?php
/*******************************
 * Emailing Helper
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 11/16/12
 ******************************/

class Emailer {
    private function __construct() {
    }

    private function __clone() {
    }

    public static function SendEmail($subject, $message) {
        $headers  = "MIME-Version: 1.0\nContent-Type: text/html; charset=iso-8859-1\n";
        $headers .= "From: nick@aeinvoice.com\r\n";
        $headers .= "Reply-To: nick@aeinvoice.com\r\n";

        //mail('nick@orrsoftware.com', $subject, nl2br($message), $headers, '-fnick@orrsoftware.com');
        mail('nick@aeinvoice.com', $subject, nl2br($message), $headers);
    }
}
?>
