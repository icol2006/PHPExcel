<?php
require "excelFile.php";

$field = $_POST['field'];
$value = $_POST['value'];
$editid = $_POST['id'];

         try {
             $excelFile=new ExcelFile('data.xlsx');
             $listWifis=$excelFile->getData();
      //echo "ID " .$editid . " Field " . $field . " Value " . $value;
   
            foreach ($listWifis as $item)
            {    
                if($item->codigo==$editid)
                {
                    $item->$field=$value;
                }

            }
            $excelFile->saveData($listWifis);
            
         } catch (Exception $e){
                             echo "El archivo de excel esta abierto. No se pueden salvar los datos";
         }


?>

