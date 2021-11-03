<?php
  DEFINE('HOST', 'localhost');
  DEFINE('USER', 'admin_db_wallet');
  DEFINE('PWD', 'dprecOlpda85kEGH');
  DEFINE('DBNAME', 'admin_db_wallet');
  $ClassDB = mysqli_connect(HOST, USER, PWD, DBNAME);
  if(!$ClassDB){
    echo "<script>alert('Database Not Connected')</script>";
  }
?>