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
      $_SESSION['message'] = "You must log in to see your page!";
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
    // Connect to database
    /* Attempt to connect to MySQL database */
    $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
    // Check connection
    if($mysqli === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
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
          <h1 align="center">Add Player Stats</h1>
          <form action="admin_processStats.php" method="post">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label"> Name(Last, First)</label>
              <div class="col-sm-10">
              <select class="form-control" data-style="btn-primary" name="name_ID" required>
              <option value="" selected disabled hidden>Choose Player Name</option>

                <?php
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
            </div>
            </div>

          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Team Name</label>
            <div class="col-sm-10">
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
            </div>
          </div>

            <div class="form-group row">
              <label for="time" class="col-sm-2 col-form-label">Playing Time (Min:Sec)</label>
              <div class="col-sm-10">
                <input class="form-control" name="time" size="5" maxlength="5" placeholder="--:--">
              </div>
           </div>

           <div class="form-group row">
             <label for="points" class="col-sm-2 col-form-label">Points Scored</label>
             <div class="col-sm-10">
               <input class="form-control" name="points" size="3" maxlength="3" placeholder="0">
             </div>
          </div>

          <div class="form-group row">
            <label for="assists" class="col-sm-2 col-form-label">Assists</label>
            <div class="col-sm-10">
              <input class="form-control" name="assists" size="2" maxlength="2" placeholder="00">
            </div>
         </div>

         <div class="form-group row">
           <label for="rebounds" class="col-sm-2 col-form-label">Rebounds</label>
           <div class="col-sm-10">
             <input class="form-control" name="rebounds" size="2" maxlength="2" placeholder="00">
           </div>
        </div>

        <div class="form-group row">
           <div class="col-sm-10 offset-sm-2">
             <button type="submit" class="btn btn-primary">ADD PLAYER STATS</button>
           </div>
         </div>
        </form>
        </div>

          <?php
           include 'viewgames.php';
           include 'viewstats.php';
          ?>

        </body>

        </div>
    </section>


  </body>
</html>
