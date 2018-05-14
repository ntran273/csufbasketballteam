<?php
//SET session variable to be used on profile.php
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

//Escape all $_POST variables to protect against SQL injections
$first_name = trim(preg_replace("/\t|\R/",' ', $_POST['firstname']));
$last_name = trim(preg_replace("/\t|\R/",' ', $_POST['lastname']));
$email = trim(preg_replace("/\t|\R/",' ', $_POST['email']));
$password = trim(preg_replace("/\t|\R/",' ', password_hash($_POST['password'], PASSWORD_BCRYPT)));
$hash = trim(preg_replace("/\t|\R/",' ', md5(rand(0,1000))));

require_once('db.php');
$mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);


$result = $mysqli->query("SELECT * FROM ACCOUNT
  WHERE email ='$email'") or die($mysqli->error());

if ($result->num_rows>0) {
  $_SESSION['message'] = 'User with this email already exists!';
  header("location: error.php");

}else{
  $query = "INSERT INTO ACCOUNT(first_name, last_name, email, password, hash) "
  ."VALUES ('$first_name','$last_name','$email','$password', '$hash')";
  $mysqli->query($query);
}

echo "success";

?>
