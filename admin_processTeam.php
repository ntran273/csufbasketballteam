<?php

$teamName = trim(preg_replace("/\t|\R/",' ',$_POST['teamName']));
$error = '';

if(!empty($teamName)){
  require_once('db.php');
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
  if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  //Check team is already exists or not
  $result = $mysqli->query("SELECT * FROM TEAM
    WHERE teamName ='$teamName'") or die($mysqli->error());
  if($result->num_rows>0){
    header('Location: admin_createteams.php');

  }else{
    $query = "INSERT INTO TEAM SET TeamName = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s',$teamName);
    $stmt->execute();
    header('Location: admin_createteams.php');
  }
}



?>
