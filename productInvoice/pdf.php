<?php
//require_once("/var/www/dompdf-master/dompdf_config.inc.php");
require_once 'dompdf-master/src/Autoloader.php';
use Dompdf\Dompdf;

class Pdf extends Dompdf{
 public function __construct() {
        parent::__construct();
    }
}

?>