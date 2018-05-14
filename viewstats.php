<?php
if(!isset($_SESSION))
{
  session_start();
}
  require_once('db.php');
  require_once('Address.php');
  require_once('PlayerStatistic.php');
  /*Displayer user information*/
  //Check if user is logged in using the session variable
  if($_SESSION['logged_in'] != 1){
    $_SESSION['message'] = "You must log in to see your profile page!";
    header("location: error.php");
  }
  else{
    $email = $_SESSION['email'];
    $type = $_SESSION['type'];
  }
  // Connect to database
  /* Attempt to connect to MySQL database */
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
  // Check connection
  if($mysqli === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  $query = "SELECT P.PlayerId, P.Name_First, P.Name_Last, S.PlayingTimeMin, S.PlayingTimeSec, S.Points, S.Assists, S.Rebounds, S.GameId
    FROM Statistics S
    JOIN PLAYER P WHERE P.PlayerId = S.PlayerId
    ORDER BY S.GameId;";
    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result(
        $PlayerId,
        $Name_First,
        $Name_Last,
        $PlayingTimeMin,
        $PlayingTimeSec,
        $Points,
        $Assists,
        $Rebounds,
        $gameid
      );
    }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Stats</title>
    <link rel="stylesheet" href="../css/theme.css" type="text/css"> </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php
      if($type == 'O'){
        include 'partials/navbarobserver.php';
      }else if ($type == 'D'){
        include 'partials/navbardirector.php';
      }
       ?>
        <div class="container">
          <h1 align="center">View Player Stats</h1>
          <table class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr class="info">
                <th scope="col">PlayerID</th>
                <th scope="col">Name(Last, First)</th>
                <th scope="col">Playing Time</th>
                <th scope="col">Points</th>
                <th scope="col">Assists</th>
                <th scope="col">Rebounds</th>
                <th scope="col">GameID</th>
              </tr>
            </thead>
            <?php
              $stmt->data_seek(0);
              while($stmt->fetch()){
                $stat = new PlayerStatistic([$Name_First, $Name_Last],[$PlayingTimeMin, $PlayingTimeSec], $Points, $Assists, $Rebounds, $gameid);
                echo "<tr>\n";
                echo "<th scope=\"row\">".$PlayerId."</th>\n";
                echo "<td>".$stat->name()."</td>\n";
                echo "<td>".$stat->playingTime()."</td>\n";
                echo "<td>".$stat->pointsScored()."</td>\n";
                echo "<td>".$stat->assists()."</td>\n";
                echo "<td>".$stat->rebounds()."</td>\n";
                echo "<td>".$stat->gameid()."</td>\n";
                echo "</tr>";
              }
              $stmt->free_result();
              $mysqli->close();
            ?>

          </table>
        </body>
        </div>
    </section>


  </body>
</html>
