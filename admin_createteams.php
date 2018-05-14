<?php
session_start();
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

if($type != 'ED'){
    session_destroy();
    header("location: index.php");
 }

?>

<head>
  <meta charset="utf-8">
  <title>Teams In League</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
  <?php include 'partials/navbaradmin.php'; ?>

  <section id="body">
      <div class="container">

        <form action="admin_processTeam.php" align="center" method="post">
          <div class="form-group">
            <h1>Create Team</h1>

            <div <?php if (isset($name_error)): ?> class="form_error" <?php endif ?> >
              <input type="text" name="teamName" required placeholder="Team Name">
              <?php if (isset($name_error)): ?>
                <span><?php echo $name_error; ?></span>
              <?php endif ?>
            </div>
        </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Create">
              <input type="reset" class="btn btn-default" value="Reset">
          </div>

        </form>
        <h1 align="center">All Teams in League</h1>
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
        ?>

        <table class="table table-bordered table-hover">
          <thead class="thead-dark">
            <tr class="info">
              <th scope="col">TeamId</th>
              <th scope="col">Team</th>

            </tr>
          </thead>
          <?php
            while($stmt->fetch()){
              echo "<tr>\n";
              echo "<th scope=\"row\">".$TeamID."</th>\n";
              echo "<td>".$TeamName."</td>\n";
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
