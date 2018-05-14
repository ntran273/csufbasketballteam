<?php
if(!isset($_SESSION))
{
       session_start();
}
/*Displayer user information*/
//Check if user is logged in using the session variable
if($_SESSION['logged_in'] != 1){
  $_SESSION['message'] = "You must log in to see your profile page!";
  header("location: error.php");
}
else{
  $first_name = $_SESSION['first_name'];
  $last_name = $_SESSION['last_name'];
  $email = $_SESSION['email'];
  $type = $_SESSION['type'];

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Schedule & Games</title>
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


    <section id="body">
        <div class="container">
          <h1 align="center">Upcoming Games</h1>
          <?php
            require_once('db.php');
            // Connect to database
            /* Attempt to connect to MySQL database */
            $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
            // Check connection
            if($mysqli === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            $query = "SELECT g.GameID, g.StartDate, g.TimeSchedule, h.TeamName, a.TeamName
            FROM GAME g
            JOIN TEAM h ON h.teamID = g.ATeamID
            JOIN TEAM a ON a.teamID = g.BTeamID;";
            if ($stmt = $mysqli->prepare($query)) {
              $stmt->execute();
              $stmt->store_result();
              $stmt->bind_result(
                $GameID,
                $StartDate,
                $TimeSchedule,
                $TeamNameA,
                $TeamNameB
              );
            }

          ?>

          <table class="table table-bordered table-hover">
            <thead class="thead-dark">
              <tr class="info">
                <th scope="col">GAME</th>
                <th scope="col">START DATE</th>
                <th scope="col">TIME</th>
                <th scope="col">Home Team</th>
                <th scope="col">Away Team</th>

              </tr>
            </thead>
            <?php
              $stmt->data_seek(0);
              while($stmt->fetch()){
                echo "<tr>\n";
                echo "<th scope=\"row\">".$GameID."</th>\n";
                echo "<td>".$StartDate."</td>\n";
                echo "<td>".$TimeSchedule."</td>\n";
                echo "<td>".$TeamNameA."</td>\n";
                echo "<td>".$TeamNameB."</td>\n";
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
