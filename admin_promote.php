<?php
/*Displayer user information*/
session_start();

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

if($type != 'ED'){
  $_SESSION['message'] = "You are not allowed to see this page";
  session_destroy();
  header("location: index.php");
}

require_once('db.php');
// Connect to database
/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$query = "SELECT USER_ID, Email, first_name, last_name, type
FROM ACCOUNT;";
if ($stmt = $mysqli->prepare($query)) {
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result(
    $UserId,
    $Email,
    $firstName,
    $lastName,
    $type
  );
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Admin Promote</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


  <!-- <link rel="stylesheet" href="css/admin.css"> -->
</head>

<body>
   <?php include 'partials/navbaradmin.php' ?>

    <!-- ========================================================================== -->
    <!-- ============================PROMOTE ACCOUNT =================================== -->
    <!-- ==================================================================================== -->
      <h1 align="center">PROMOTE USER</h1>
      <div class="container">
        <form action="admin_processPromote.php" align="center" method="post">
          <div>
            <select name="user_id" required>
              <option value="" selected disabled hidden>Choose user's account</option>
            <?php
              $stmt->data_seek(0);
              while( $stmt->fetch() )
              {
                echo '<option '.$UserId.' value="'.$UserId.'">'.$Email.'</option>';
              }

            ?>

            </select>
            <select name="type">
              <option value="" selected disabled hidden>New Position</option>
              <option value="O">Observer</option>
              <option value="D">Director</option>
              <option value="ED">Executive Director</option>
            </select>
            <input type="submit" class="btn btn-primary" value="Promote">

            <input type="reset" class="btn btn-default" value="Reset">
          </div>
        </form>

        <div class="container">
        <table class="table  table-dark align="center" ">
          <thead>
            <tr>
              <th scope="col">Type</th>
              <th scope="col">Position</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">0</th>
              <td>Observer</td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>Director</td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Executive League</td>
            </tr>

          </tbody>
        </table>
      </div>
        <br>
        <h1 align="center">User List</h1>

        <table class="table table-bordered table-hover">
          <thead class="thead-dark">
            <tr class="info">
              <th scope="col">User Id</th>
              <th scope="col">Email</th>
              <th scope="col">First Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Type</th>

            </tr>
          </thead>
            <?php
              $stmt->data_seek(0);
              while( $stmt->fetch() )
              {
                echo "<tr>\n";
                echo "<th scope=\"row\">".$UserId."</th>\n";
                echo "<td>".$Email."</td>\n";
                echo "<td>".$firstName."</td>\n";
                echo "<td>".$lastName."</td>\n";
                echo "<td>".$type."</td>\n";

                echo "</tr>";

              }
              $stmt->free_result();
              $mysqli->close();

            ?>
        </table>
      </div>

  </div>
  <?php include 'viewgames.php' ?>
</body>


</html>
