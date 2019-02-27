
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
require "excelFile.php";


$excelFile=new ExcelFile('data.xlsx');
$listWifis=$excelFile->getData();

?>


   
<div class="container">
<h2>Information redes wifi</h2>
 <table table class='table table-striped'>
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
   <td><?php echo $row->codigo; ?></td>
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
   <td>
       <button type="button">Eliminar</button>
   </td>
  </tr>
  <?php
   $count ++;
  }
  ?> 
 </table>
</div>
    
</body>

<script>
$(document).ready(function(){
 
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
   data: { field:field_name, value:value, id:edit_id },
   success:function(response){
    console.log(response);
    if(responsestr.length>0)
    alert(response);
    
   },error: function(result) {
         alert(result);
   }
  });
 
 });

});
</script>
</html>
