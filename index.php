<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<?php
// Start the session
session_start();
require "excelFile.php";
?>
<!DOCTYPE html>
<html>
<body>

<?php
    if(isset($_POST['Agregar'])){ //check if form was submitted
        $codigo= isset($_POST['cod'])?$_POST['cod']:"";
        $ssid = isset($_POST['ssid'])?$_POST['ssid']:"";
        $pass = isset($_POST['pass'])?$_POST['pass']:"";
        $com = isset($_POST['com'])?$_POST['com']:"";

        $net=new NetInfo($codigo, $ssid, $pass, $com);
        if(isset($_SESSION["file"]))
        {
        $excelFile=new ExcelFile($_SESSION["file"]);
        $listWifis=$excelFile->getData();
        array_push($listWifis,$net);
        $excelFile->saveData($listWifis);
    }
    


}

     /*  if(isset($_POST['Exportar'])){ //check if form was submitted
           $excelFile=new ExcelFile($_SESSION["file"]);
           $excelFile->DownlaodData();
       }*/


?>


<?php
//Subir archivo
error_reporting(E_ERROR | E_PARSE);
    $currentDir = getcwd();
    $uploadDirectory = "/uploads/";
    $message="";

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['xlsx']; // Get all the file extensions

    if(isset($_FILES['myfile']['name']))
    {
    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 30000000) {
            $errors[] = "This file is more than 30MB. Sorry, it has to be less than or equal to 2MB";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                $message= "The file " . basename($fileName) . " has been uploaded";
                $_SESSION["file"] = $uploadPath;
            } else {
                $message=  "An error occurred somewhere. Try again or contact the admin";
            }
        } else {
            foreach ($errors as $error) {
                $message= $error . "These are the errors" . "\n";
            }
        }
        
        echo '<script language="javascript">';
        echo 'alert(' . $message . " " .')';  //not showing an alert box.
        echo '</script>';
      
    }
    }
?>
    
<?php
//Datos del archivo

 $excelFile;
if(isset($_SESSION["file"]))
{
    $excelFile=new ExcelFile($_SESSION["file"]);
    $listWifis=$excelFile->getData();
}
?>
    


   
    <div class="container col-md-12">
<hr>
<h2>Informacion redes wifi</h2>
<hr>

<table table class='table table-striped' >
    <tr style="background-color:#2c2525">
         <td > 
  <div style="float: right">    
    <form action="index.php" method="post" enctype="multipart/form-data">
        Importar excel
        <input class="btn-md btn-primary" style="display:inline;margin-right: 20px" type="file" name="myfile" id="fileToUpload">
        <input class="btn-md btn-primary" style="display:inline"  type="submit" name="submit" value="Impostar" >
    </form>    
</div>
             <form class="form-inline" method="post" action="index.php">
                      <button name="Exportar" style="float:left;margin-left: 20px "  type="submit" class="btn-md btn-primary">Exportar Excel</button>

             </form>
         </td>
     </tr>
 </table>
<form class="form-inline" method="post" action="index.php">
    <table class='table table-striped'>
      <td>    
        <div class="form-group">
          <label for="usr">Codigo:</label>
          <input type="text" class="form-control" name="cod">
        </div>
      </td>
      <td>
        <div class="form-group">
          <label for="usr">Nombre SSID:</label>
          <input type="text" class="form-control" name="ssid">
        </div>
      </td>
      <td>
        <div class="form-group">
          <label for="usr">Password SSI:</label>
          <input type="text" class="form-control" name="pass">
        </div>          
      </td>
      <td>
        <div class="form-group">
          <label for="usr">Comentario:</label>
          <input type="text" class="form-control" name="com">
        </div>          
      </td>     
      <td>           
          <button name="Agregar" type="submit" class="btn-md btn-primary">Agregar</button>

      </td>
    </table>
</form>
           
           
<div>
    <table class='table table-striped'>
      <tr>
       <th>Codigo</th>
       <th>Nombre SSID</th>
       <th>Password SSID</th>
       <th>Comentario</th>
       <th></th>
      </tr>
      <?php 
       $count = 1;
    foreach($listWifis as $row) {
      ?>
      <tr>
       <td class="codigo"><?php echo $row->codigo; ?></td>
       <td> 
         <div contentEditable='true' class='edit' id='nombreSSID_<?php echo $row->codigo; ?>'> 
           <?php echo $row->nombreSSID; ?>
         </div> 
       </td>
       <td> 
         <div contentEditable='true' class='edit' id='passwordSSID_<?php echo $row->codigo; ?>'> 
           <?php echo $row->passwordSSID; ?>
         </div> 
       </td>
        <td> 
         <div contentEditable='true' class='edit' id='comentario_<?php echo $row->codigo; ?>'> 
           <?php echo $row->comentario; ?>
         </div> 
       </td>
       <td style="float:right">
           <button class="btn-success btnEliminar"  type="button">Eliminar</button>
       </td>
      </tr>
      <?php
       $count ++;
      }
      ?> 
     </table>
</div>

</div>
    
</body>

<script>
$(document).ready(function(){
      var $action="update";
 $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
 // Add Class
 $('.edit').click(function(){
  $(this).addClass('editMode');
 });

 // Save data
 $(".edit").focusout(function(){
  $(this).removeClass("editMode");
  var id = this.id;
  var split_id = id.split("_");
  var field_name = split_id[0];
  var edit_id = split_id[1];
  var value = $(this).text();

  $.ajax({
   url: 'update.php',
   type: 'post',
   data: { field:field_name, value:value, id:edit_id, typeAction:$action },
   success:function(response){
    console.log(response);
    if(response.trim().length>0)
    alert(response);
    
   },error: function(result) {
         alert(result);
   }
  });
 
 });

});

$(".btnEliminar").click(function() {
    var $action="delete";
    var $tr= $(this).closest("tr");
 var $codigo = $tr   // Finds the closest row <tr> 
                 .find(".codigo")  // Gets a descendent with class="nr"
                 .text();         // Retrieves the text within <td>
               //alert($codigo);
               
    $.ajax({
    url: 'update.php',
    type: 'post',
    data: { id:$codigo, typeAction:$action },
    success:function(response){
    console.log(response);

    if(response.trim().length==0)
    {
           $($tr).remove();
    }else{
            alert(response);
    }
       
    
   },error: function(result) {
         alert("e  "+result);
         
   }
  });
  
});


</script>
</html>
