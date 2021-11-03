
<?php
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  include "config/config.php";
  $GetCountries = mysqli_query($ClassDB, "SELECT * FROM `countries`");
  if(mysqli_num_rows($GetCountries) > 0){
    $output = mysqli_fetch_all($GetCountries, MYSQLI_ASSOC);
    echo json_encode($output);
  }else{
    echo json_encode(array('message' => 'Data Not Found', 'status' => false));
  }
?>