<?php
require "excelFile.php";
session_start();

         try {
$action = $_POST['typeAction'];
$field = isset($_POST['field'])?$_POST['field']:"";
$value = isset($_POST['value'])?$_POST['value']:"";
$editid = isset($_POST['id'])?$_POST['id']:"";


             $excelFile=new ExcelFile($_SESSION["file"]);
             $listWifis=$excelFile->getData();
            // echo $_SESSION["file"];
 
            foreach ($listWifis as $item)
            {    
                if($item->codigo==$editid)
                {
                    if($action=="update")
                    {
                        $item->$field=$value;
                    } else {
                      //$listWifis= unsetValue($listWifis, $item);
                        // unset($listWifis[$item]); //removes the array at given index
                      $listWifis =  unsetValue($listWifis, $item); 
                 
                    }
                  break;
                }
            }
            $excelFile->saveData($listWifis);
            
         } catch (Exception $e){
                             echo $e . "El archivo de excel esta abierto. No se pueden salvar los datos";
         }
         
        function unsetValue(array $array, $value, $strict = TRUE)
        {
            if(($key = array_search($value, $array, $strict)) !== FALSE) {
                unset($array[$key]);
            }
            return $array;
        }


?>

