<!--OBSERVER PAGES -->
<!--MANAGER PAGES -->
<?php
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

if($type != 'O'){
    session_destroy();
    header("location: index.php");
 }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Observer</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/navbarobserver.php'; ?>
  <div class="jumbotron">
    <h1 class="display-3">Hello, <?php echo $_SESSION['first_name']; ?>!</h1>
    <p class="lead"> Email: <?php echo $_SESSION['email']; ?></p>
    <hr class="my-4">
    <p>You are an. You can view stats, and view teams, view games</p>
    <p class="lead">
      <a class="btn btn-primary btn-lg" href="viewgames.php" role="button">View Games</a>
    </p>
  </div>

</body>


</html>
