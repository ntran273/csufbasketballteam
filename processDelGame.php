<?php
// create short variable names
$gameid     = (int) $_POST['game_ID'];  // slection

require_once( 'db.php' );
$mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);


  if( mysqli_connect_error() == 0 )  // Connection succeeded
    {
      $query = "DELETE FROM GAME WHERE
                  Game.GameID = ?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('i', $gameid);
      $stmt->execute();
      require('delete_page.php');
    }

?>
