<?php
require 'vendor/autoload.php';
require "netinfo.php";
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelFile
{
    // Declaraci�n de una propiedad
    public $filename = '';

	function __construct( $filename ) {
            $this->filename = $filename;
	}
 
	function getData() {
		
            $inputFileName = $this->filename;
            $spreadsheet = IOFactory::load($inputFileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            array_shift($sheetData); 
            $sheetData;
            $listWifis = array();

                foreach($sheetData as $row) 
                {
                  $data=array_values($row);
                  $wifi = new NetInfo( $data[0],$data[1],$data[2],$data[3] );
                  array_push($listWifis, $wifi);
                }
                
                return $listWifis;
        }
        
        function saveData($listWifis)
        {    
   
                $spreadsheet = IOFactory::load($this->filename);
                           //change it
                           $sheet = $spreadsheet->getActiveSheet();

                           $sheet->setCellValue('A1', 'Codigo');
                           $sheet->setCellValue('B1', 'Nombre SSID');
                           $sheet->setCellValue('C1', 'Password SSID');
                           $sheet->setCellValue('D1', 'Comentario');

                           $con=2;
                           foreach ($listWifis as $item)
                           {
                                $sheet->setCellValue('A' . $con, $item->codigo);
                                $sheet->setCellValue('B' . $con, $item->nombreSSID);
                                $sheet->setCellValue('C' . $con, $item->passwordSSID);
                                $sheet->setCellValue('D' . $con, $item->comentario);

                                //$sheet->setCellValue('A2', $item->codigo);
                                //$sheet->setCellValue('B2', $item->nombreSSID);
                                //$sheet->setCellValue('C2', $item->passwordSSID);
                                //$sheet->setCellValue('D1', $item->comentario);
                                $con=$con+1;
                           }

                           //write it again to Filesystem with the same name (=replace)
                           $writer = new Xlsx($spreadsheet);
                           $writer->save($this->filename);     

       

                  
        }
}
?>