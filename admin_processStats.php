<?php
// create short variable names
$name       = (int) $_POST['name_ID'];  // slection
$time       = trim( preg_replace("/\t|\R/",' ',$_POST['time']) );
$points     = (int) $_POST['points'];
$assists    = (int) $_POST['assists'];
$rebounds   = (int) $_POST['rebounds'];
$gameIdz     = (int) $_POST['game_ID']; //selection
if( empty($name)     ) $name      = null;
// see below for $time processing
if( empty($points)   ) $points    = null;
if( empty($assists)  ) $assists   = null;
if( empty($rebounds) ) $rebounds  = null;
if( empty($gameIdz) ) $gameIdz  = null;
$time = explode(':', $time); // convert string to array of minutes and seconds
if( count($time) >= 2 )
{
$minutes = (int)$time[0];
$seconds = (int)$time[1];
}
else if( count($time) == 1 )
{
$minutes = (int)$time[0];
$seconds = null;
}
else
{
$minutes = null;
$seconds = null;
}
require_once( 'db.php' );
$mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
//Check if the stats for the player and the game is already placed or not
$result = $mysqli->query("SELECT * FROM Statistics, Game
  WHERE Statistics.PlayerId ='$name' AND Statistics.GameId = '$gameIdz'") or die($mysqli->error());
if($result->num_rows>0){
  header('Location: admin_createStats.php');
}
  else{
    if( ! empty($name) )  // Verify required fields are present
    {
    if( mysqli_connect_error() == 0 )  // Connection succeeded
    {
      $query = "INSERT INTO Statistics SET
                  Statistics.PlayerId = ?,
                  Statistics.PlayingTimeMin  = ?,
                  Statistics.PlayingTimeSec  = ?,
                  Statistics.Points          = ?,
                  Statistics.Assists         = ?,
                  Statistics.Rebounds        = ?,
                  Statistics.GameId = ?";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('ddddddd', $name, $minutes, $seconds, $points, $assists, $rebounds, $gameIdz);
      $stmt->execute();
      require('admin_createStats.php');
    }
  }
  }
?>
