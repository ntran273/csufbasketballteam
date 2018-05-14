<?php
session_start();
$ID       = (int) $_POST['user_id'];
$type       = (string) $_POST['type'];

if( ! empty($ID ))
{
  require_once('db.php');
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
  // Check connection
  if($mysqli === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  $sql ="UPDATE ACCOUNT
         SET ACCOUNT.TYPE = ?
         WHERE
         ACCOUNT.USER_ID  = '$ID'
          ";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $type);
    $stmt->execute();
    header('location: admin_promote.php');

}
?>
