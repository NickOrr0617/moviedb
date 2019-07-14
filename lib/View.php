<?php
/*******************************
 * Generic view class that allows
 * the setting of varibles to be
 * rendered on view html page 
 *
 * Author: Nick Orr
 * Created: 6/23/09
 ******************************/

class View {
    protected $vars = array();
    protected $__file;
    private $_script = array();
    private $_jquery = false;
    private $_analytics = true;
    private $_css = array();
    private $_meta = array();
    private $_title;
    private $_showTitle = true;

    public function __set($key, $value) {
        $this->vars[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->vars[$key])) {
            return $this->vars[$key];
        } else {
            return null;
        }
    }

    public function __isset($key) {
        return isset($this->vars[$key]);
    }

    public function __unset($key) {
        unset($this->vars[$key]);
    }

    public function render($file, $buffer = false) {
        if ($buffer) {
            ob_start();
        }
        $this->header();
        $this->__file = $file;
        unset($file);
        include $this->__file;
        $this->footer();
        if ($buffer) {
            return ob_get_clean();
        }
    }

    public function DisableAnalytics() {
        $this->_analytics = false;
    }

    public function Addjquery() {
        $this->_jquery = true;
    }

    public function AddScript($script) {
        $this->_script[] = $script;
    }

    public function AddCss($css) {
        $this->_css[] = $css;
    }

    public function AddMeta($meta) {
        $this->_meta[] = $meta;
    }

    public function SetTitle($title) {
        $this->_title = $title;
    }

    public function ShowTitle($show) {
        $this->_showTitle = $show;
    }

    private function header() {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n";
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#">' . "\n";
        echo '<head>' . "\n";

        echo '<meta property="og:title" content="' . $this->_title . '"/>' . "\n";
        echo '<meta property="og:type" content="company"/>' . "\n";
        echo '<meta property="og:url" content="http://www.aeinvoice.com' . $_SERVER['REQUEST_URI'] . '"/>' . "\n";
        echo '<meta property="og:image" content="http://www.orrsoftware.com/images/aeinvoice.png"/>' . "\n";
        echo '<meta property="og:site_name" content="AEInvoice.com"/>' . "\n";

        echo '<meta name="robots" content="index, follow" />' . "\n";

        foreach ($this->_meta as $meta) {
            echo $meta . "\n";
        }

        echo "\n";

        echo '<title>' . $this->_title . '</title>' . "\n";
        
        if (count($this->_css) > 0) {
            foreach ($this->_css as $css) {
                if (!strstr($css, '<link')) {
                    echo '<link rel="stylesheet" type="text/css" href="' . $css . '" media="screen"/>' . "\n";
                } else {
                    echo $css . "\n";
                }
            }
        }

        if ($this->_jquery) {
            echo '<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/ui-lightness/jquery-ui.css" media="screen"/>';
        }

        if ($this->_analytics) {
            echo '
            <script type="text/javascript">

              var _gaq = _gaq || [];
              _gaq.push([\'_setAccount\', \'UA-26463756-1\']);
              _gaq.push([\'_trackPageview\']);

              (function() {
                var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
                ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
                var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
              })();

            </script>' . "\n";
        }

        echo '</head>' . "\n";
        echo '<body>' . "\n";

        if ($this->_jquery) {
            echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>' . "\n";
            echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>' . "\n";
        }

        if (count($this->_script) > 0) {
            foreach ($this->_script as $script) {
                if (!strstr($script, '<script')) {
                    echo '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
                } else {
                    echo $script . "\n";
                }
            }
        }

        echo '<div class="content">' . "\n";
        if ($this->_showTitle) {
            echo '<a href="http://www.aeinvoice.com" title="AEInvoice Home"><img class="logo" src="http://www.orrsoftware.com/images/aeinvoice.png" alt="AEInvoice Home" /></a>';
            echo '<h1 class="title center">' . $this->_title . '</h1>'. "\n";
        }
    }

    private function footer() {
        echo '</div>'. "\n";
        echo '</body>'. "\n";
        echo '</html>'. "\n";
    }
}
?>
