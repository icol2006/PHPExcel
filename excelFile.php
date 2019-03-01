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
        {                    $spreadsheet = IOFactory::load($this->filename);
                           //change it
                           $sheet = $spreadsheet->getActiveSheet();

                           $sheet=$sheet->removeRow(2, count($listWifis)+1);
                                   
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
        
        function DownlaodData()
        {                    
                    // Create new Spreadsheet object
          $spreadsheet = new Spreadsheet();

          // Set document properties
          $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
              ->setLastModifiedBy('Maarten Balliauw')
              ->setTitle('Office 2007 XLSX Test Document')
              ->setSubject('Office 2007 XLSX Test Document')
              ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
              ->setKeywords('office 2007 openxml php')
              ->setCategory('Test result file');

          // Add some data
          $spreadsheet->setActiveSheetIndex(0)
              ->setCellValue('A1', 'Hello')
              ->setCellValue('B2', 'world!')
              ->setCellValue('C1', 'Hello')
              ->setCellValue('D2', 'world!');

          // Miscellaneous glyphs, UTF-8
          $spreadsheet->setActiveSheetIndex(0)
              ->setCellValue('A4', 'Miscellaneous glyphs')
              ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

          // Rename worksheet
          $spreadsheet->getActiveSheet()->setTitle('Simple');

          // Set active sheet index to the first sheet, so Excel opens this as the first sheet
          $spreadsheet->setActiveSheetIndex(0);

          // Redirect output to a client’s web browser (Xlsx)
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="simple.xlsx"');
          header('Cache-Control: max-age=0');
          // If you're serving to IE 9, then the following may be needed
          header('Cache-Control: max-age=1');

          // If you're serving to IE over SSL, then the following may be needed
          header('Expires: Mon, 26 Jul 2080 05:00:00 GMT'); // Date in the past
          header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
          header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
          header('Pragma: public'); // HTTP/1.0

          $writer = IOFactory::createWriter($spreadsheet, 'xlsx');
          $writer->save('php://output');
               

 
        }
}
?>