<?php

    require_once('db.php');

    $selectOption = (string) $_POST['teamname'];

    // $test = 'UCLA';
    $query = "SELECT Player.PlayerId, Player.Name_First, Player.Name_Last, Player.Street, Player.City, Player.State, Player.Country, Player.ZipCode, Team.TeamName
    FROM PLAYER INNER JOIN TEAM ON
    PLAYER.PlayerTeamId = Team.TeamId AND team.TeamName = '$selectOption'
    ORDER BY Player.PlayerId;";

    $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
    // Check connection
    if($mysqli === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    if ($stmt = $mysqli->prepare($query)) {
      $stmt->execute();
      $stmt->store_result();
      $stmt->bind_result(
        $PlayerId,
        $Name_First,
        $Name_Last,
        $Street,
        $City,
        $State,
        $Country,
        $Zipcode,
        $TeamN
      );
    }


    session_start();

    /*Displayer user information*/
    //Check if user is logged in using the session variable
    if($_SESSION['logged_in'] != 1){
      $_SESSION['message'] = "You must log in to see this page!";
      header("location: error.php");
    }
    else{
      $first_name = $_SESSION['first_name'];
      $last_name = $_SESSION['last_name'];
      $email = $_SESSION['email'];
      $type = $_SESSION['type'];

    }

    if($type == 'O'){
        session_destroy();
        header("location: index.php");
     }

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Players</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <?php
    if($type == 'D'){
      include 'partials/navbardirector.php';
    }else if($type == 'ED'){
      include 'partials/navbaradmin.php';
    }

   ?>

  <?php
  require_once('db.php');
  // Connect to database
  /* Attempt to connect to MySQL database */
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
  // Check connection
  if($mysqli === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  //GET TEAM
  $query2 = "SELECT TeamID, TeamName
  FROM TEAM;";
  if ($stmt2 = $mysqli->prepare($query2)) {
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result(
      $ti,
      $teamNAME
    );
  }

  ?>

  <div class="cd">
      <div class="container">
        <form class="p-4 section-light" method="post" id="test" action="processPlayers.php">
            <h1 class="mb-3 text-center">Player Information</h1>
            <div class="form-group row">
            <label for="firstName" class="col-sm-2 col-form-label">Team Name</label>
              <div class="col-sm-10">
              <select class="form-control" data-style="btn-primary" name="team_id" required>
                  <option value="" selected disabled hidden>Choose Team</option>
                <?php
                  $stmt2->data_seek(0);
                  //testing
                  while( $stmt2->fetch() )
                  {
                    echo '<option '.$ti.' value="'.$ti.'">'.$teamNAME.'</option>';
                  }
                  $stmt2->free_result();
                  $mysqli->close();
                ?>
              </select>
            </div>
            </div>
            <div class="form-group row">
              <label for="firstName" class="col-sm-2 col-form-label">First Name</label>
              <div class="col-sm-10">
                  <input class="form-control" name="firstName" placeholder="Enter First Name">
              </div>
            </div>
            <div class="form-group row">
              <label for="lastName" class="col-sm-2 col-form-label">Last Name</label>
              <div class="col-sm-10">
                <input class="form-control" name="lastName" placeholder="Enter Last Name">
              </div>
           </div>
           <div class="form-group row">
             <label for="street" class="col-sm-2 col-form-label">Street</label>
             <div class="col-sm-10">
               <input class="form-control" name="street" placeholder="Enter Street">
             </div>
          </div>
          <div class="form-group row">
            <label for="city" class="col-sm-2 col-form-label">City</label>
            <div class="col-sm-10">
              <input class="form-control" name="city" placeholder="Enter City">
            </div>
         </div>
         <div class="form-group row">
           <label for="state" class="col-sm-2 col-form-label">State</label>
           <div class="col-sm-10">
             <input class="form-control" name="state" placeholder="Enter State">
           </div>
        </div>
         <div class="form-group row">
           <label for="country" class="col-sm-2 col-form-label">Country</label>
           <div class="col-sm-10">
             <input class="form-control" name="country" placeholder="Enter Country">
           </div>
        </div>
        <div class="form-group row">
          <label for="zipCode" class="col-sm-2 col-form-label">Zip Code</label>
          <div class="col-sm-10">
            <input class="form-control" name="zipCode" placeholder="Enter Zip Code">
          </div>
       </div>
       <div class="form-group row">
          <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary">ADD NAME AND ADDRESS</button>
          </div>
        </div>
          </form>
      </div>
      <div class="container">
        <form action="viewplayersbyteam.php" align="center" method="post">
        <h1>View Players</h1>
        <?php
          require_once('db.php');
          // Connect to database
          /* Attempt to connect to MySQL database */
          $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
          // Check connection
          if($mysqli === false){
              die("ERROR: Could not connect. " . mysqli_connect_error());
          }

          $query2 = "SELECT * FROM TEAM";
          if ($stmt2 = $mysqli->prepare($query2)) {
            $stmt2->execute();
            $stmt2->store_result();
            $stmt2->bind_result(
              $TeamID,
              $TeamName
            );
          }


        ?>
      <select name = "teamname">
        <option value="" selected disabled hidden>Choose Team</option>
        <?php
      while($stmt2->fetch()){
        echo '<option '.$TeamName.' value="'.$TeamName.'">'.$TeamName.'</option>';
    }
    ?>

    </select>
      <input type="submit" class="btn btn-primary" value="Search">
      <input type="reset" class="btn btn-default" value="Reset">
      </form>

<table class="table table-bordered table-hover">
  <thead class="thead-dark">
    <tr class="info">
      <th scope="col">PLAYERID</th>
      <th scope="col">FIRST NAME</th>
      <th scope="col">LAST NAME</th>
      <th scope="col">STREET</th>
      <th scope="col">CITY</th>
      <th scope="col">STATE</th>
      <th scope="col">COUNTRY</th>
      <th scope="col">ZIPCODE</th>
      <th scope="col">TEAM</th>


    </tr>
  </thead>
  <?php
    $stmt->data_seek(0);
    while($stmt->fetch()){
      echo "<tr>\n";
      echo "<th scope=\"row\">".$PlayerId."</th>\n";
      echo "<td>".$Name_First."</td>\n";
      echo "<td>".$Name_Last."</td>\n";
      echo "<td>".$Street."</td>\n";
      echo "<td>".$City."</td>\n";
      echo "<td>".$State."</td>\n";
      echo "<td>".$Country."</td>\n";
      echo "<td>".$Zipcode."</td>\n";
      echo "<td>".$TeamN."</td>\n";

      echo "</tr>";
    }
    $stmt->free_result();
    $mysqli->close();
  ?>

</table>
</div>


</body>


</html>
