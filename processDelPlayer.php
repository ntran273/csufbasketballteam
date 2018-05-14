<?php
// create short variable names
$nameid       = (int) $_POST['name_ID'];  // slection

require_once( 'db.php' );
$mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);


  if( mysqli_connect_error() == 0 )  // Connection succeeded
    {
      $query = "DELETE FROM PLAYER WHERE
                  Player.PlayerId = ?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('i', $nameid);
      $stmt->execute();
      require('delete_page.php');
    }

?>
