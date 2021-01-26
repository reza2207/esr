<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('PHPExcel/Classes/PHPExcel.php');
require_once 'PHPExcel/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

class Excel extends PHPExcel{

   	public function __construct(){

        parent::__construct();
        PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
   	}
}

	

?>
