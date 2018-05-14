<?php

  require_once('db.php');
  $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

  $email = trim(preg_replace("/\t|\R/",' ', $_POST['email']));
  $password = trim(preg_replace("/\t|\R/",' ', $_POST['password']));

  $result = $mysqli->query("SELECT * FROM ACCOUNT WHERE email='$email'" );

  if ($result->num_rows == 0) {
    $_SESSION['message'] = 'User with this email does not exist!';
    header("location: error.php");

  }else{
    $user = $result->fetch_assoc();

    //verify password hash
    if(password_verify($password, $user['password'])){
      $_SESSION['email'] = $user['email'];
      $_SESSION['first_name'] = $user['first_name'];
      $_SESSION['last_name'] = $user['last_name'];
      $_SESSION['type'] = $user['type'];


      $_SESSION['logged_in'] = true;

      if($_SESSION['type'] == 'O'){
        header("location: observer_page.php");
      }else if ($_SESSION['type'] == 'D'){
        header("location: director_page.php");
      }else if ($_SESSION['type'] == 'ED'){
        header("location: admin_page.php");
      }

    }
    else{
      $_SESSION['message'] = "You have entered wrong password, try again!";
      header("location: error.php");
    }

  }
?>
