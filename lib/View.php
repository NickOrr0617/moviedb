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
        echo '<!DOCTYPE html>' . "\n";
        echo '<head>' . "\n";

        echo '<meta property="og:title" content="' . $this->_title . '"/>' . "\n";
        
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
            //echo '<link href="http://mottie.github.io/tablesorter/css/theme.default.css" rel="stylesheet">';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.blue.min.css">';
            echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/jquery.tablesorter.pager.min.css">';
        }

        echo '</head>' . "\n";
        echo '<body>' . "\n";

        if ($this->_jquery) {
            echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>' . "\n";
            echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>' . "\n";
            echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>';
            echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.widgets.js"></script>';
            echo '<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/extras/jquery.tablesorter.pager.min.js"></script>';
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
