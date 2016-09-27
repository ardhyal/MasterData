<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/third_party/PHPExcel.php";
class Excel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('mcrud', 'crud');
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    function read() {
        $inputFileType = "Excel5";
        $inputFileName = "./assets/excel/example1.xls";

        /**  Create a new Reader of the type defined in $inputFileType  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel = $objReader->load($inputFileName);

        $dataArr = array();
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $worksheetTitle = $worksheet->getTitle();
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

            for ($row = 1; $row <= $highestRow; ++$row) {
                for ($col = 0; $col < $highestColumnIndex; ++$col) {
                    $cell = $worksheet->getCellByColumnAndRow($col, $row);
                    $val = $cell->getValue();
                    $dataArr[$row][$col] = $val;
                }
            }
        }
        for ($i=2; $i<count($dataArr)+1; $i++){
            $dataform = array (
                'data1' => $dataArr[$i][0],
                'data2' => $dataArr[$i][1],
                'data3' => $dataArr[$i][2],
                'data4' => $dataArr[$i][3],
            );
            $this->crud->create($dataform);
        }
        redirect(site_url('excel'), 'refresh');
    }
}
