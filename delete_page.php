<?php
if(!isset($_SESSION))
{
  session_start();
}

require_once('db.php');
require_once('Address.php');
require_once('PlayerStatistic.php');

if($_SESSION['logged_in'] != 1){
  $_SESSION['message'] = "You must log in to see this page!";
  header("location: error.php");
}
else{
  $email = $_SESSION['email'];
  $type = $_SESSION['type'];
}
if($type != 'ED'){
    session_destroy();
    header("location: index.php");
 }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Stats</title>
    <link rel="stylesheet" href="css/theme.css" type="text/css"> </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php include 'partials/navbaradmin.php'; ?>

<section id="body">
<div class ="container">
  <h1 align="center">Delete Account </h1>
  <form action="processDelAccount.php" align="center" method="post">
    <div class="form-group">
      <select class="form-control" data-style="btn-primary" name="user_id" required>
      <option value="" selected disabled hidden>Choose Account</option>
      <?php
        require_once('db.php');
        // Connect to database
        /* Attempt to connect to MySQL database */
        $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
        // Check connection
        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $query4 = "SELECT USER_ID, Email, first_name, last_name, type
        FROM ACCOUNT;";

        if ($stmt4 = $mysqli->prepare($query4)) {
          $stmt4->execute();
          $stmt4->store_result();
          $stmt4->bind_result(
            $UserId,
            $Email,
            $firstName,
            $lastName,
            $type
          );

        }
        $stmt4->data_seek(0);
        while( $stmt4->fetch() )
        {
          echo '<option '.$UserId.' value="'.$UserId.'">'.$Email.'</option>';
        }
      ?>

    </select>
    <br>
     <button type="submit" class="btn btn-primary">Delete Acount</button>

  </form>

  <br>
  <br>


  <h1 align="center">Delete Player </h1>
  <form action="processDelPlayer.php" method="post">
    <div class="form-group row">
      <label class="col-sm-2 col-form-label"> Name(Last, First)</label>
      <div class="col-sm-10">
      <select class="form-control" data-style="btn-primary" name="name_ID" required>
      <option value="" selected disabled hidden>Choose Player Name</option>

        <?php
          require_once('db.php');
          // Connect to database
          /* Attempt to connect to MySQL database */
          $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

          $query2 = "SELECT PlayerId, Name_First, Name_Last, TeamName
          FROM PLAYER, TEAM WHERE TEAM.TeamID = PLAYER.PlayerTeamId
          ORDER BY Team.TeamName, Player.Name_Last, Player.Name_First;";
          if($mysqli === false){
              die("ERROR: Could not connect. " . mysqli_connect_error());
          }
          if ($stmt2 = $mysqli->prepare($query2)) {
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result(
              $PlayerId,
              $Name_First,
              $Name_Last,
              $TeamName
            );
          }
          $stmt2->data_seek(0);
          while( $stmt2->fetch() )
          {
            $player = new Address([$Name_First, $Name_Last]);
            echo "<option value=\"$PlayerId\">".$player->name()." (Team: ".$TeamName.")"."</option>\n";
          }
        ?>
      </select>
      <br>
      <button type="submit" class="btn btn-primary">Delete Players</button>

       </div>
    </div>
  </div>
</form>

<br>
<form action="processDelTeam.php" align="center" method="post">
  <div class="form-group">
    <h1>Delete Team</h1>

    <select class="form-control" data-style="btn-primary" name="team_ID" required>
    <option value="" selected disabled hidden>Choose Team Name</option>
    <?php
      require_once('db.php');
      // Connect to database
      /* Attempt to connect to MySQL database */
      $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
      // Check connection
      if($mysqli === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      $query = "SELECT TeamID, TeamName
      FROM TEAM
      ORDER BY TeamID;";

      if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result(
          $TeamID,
          $TeamName
        );

      }
      $stmt->data_seek(0);
      while( $stmt->fetch() )
      {
        echo "<option value=\"$TeamID\">".$TeamName."</option>\n";
      }
    ?>

  </select>
  <br>
   <button type="submit" class="btn btn-primary">Delete Team</button>

</form>

<br>
<br>
<form action="processDelGame.php" align="center" method="post">
  <div class="form-group">
    <h1>Delete Game</h1>

    <select class="form-control" name="game_ID" required>
      <option value="" selected disabled hidden>Choose game here</option>
      <?php
        $query3 = "SELECT  GAME.GameId, H.TeamName, G.TeamName
        FROM GAME
        LEFT JOIN TEAM H ON Game.ATeamID = H.TeamID
        LEFT JOIN TEAM G ON Game.BTeamID = G.TeamID
        ORDER BY Game.GameID;";
        // Check connection
        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        if ($stmt3 = $mysqli->prepare($query3)) {
          $stmt3->execute();
          $stmt3->store_result();
          $stmt3->bind_result(
            $Game,
            $TeamNameA,
            $TeamNameB
          );
        }
        $stmt3->data_seek(0);
        while( $stmt3->fetch() )
        {
          echo "<option value=\"$Game\">"."GameID: ".$Game." Team ".$TeamNameA. " vs Team ".$TeamNameB."</option>\n";
        }
      ?>
    </select>
  <br>
   <button type="submit" class="btn btn-primary">Delete Game</button>

</form>

</div>
</section>
</html>
