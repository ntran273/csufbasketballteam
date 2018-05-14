<?php
session_start();
$ID       = (int) $_POST['user_id'];

if( ! empty($ID ))
{
  require_once('db.php');
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
  // Check connection
  if($mysqli === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  $query ="DELETE FROM ACCOUNT
         WHERE ACCOUNT.USER_ID  = '$ID';";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('d', $ID);
    $stmt->execute();
    header('location: delete_page.php');

}
?>
