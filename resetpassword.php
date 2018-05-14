<?php
/* Password reset process, updates database with new user password */
session_start();

// Make sure the form is being submitted with method="post"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Make sure the two passwords match
    if ( $_POST['new_password'] == $_POST['confirm_password'] ) {
        require_once('db.php');
        $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

        // We get $_POST['email'] and $_POST['hash'] from the hidden input field of reset.php form
        $email = trim(preg_replace("/\t|\R/",' ', $_POST['email']));
        $hash = trim(preg_replace("/\t|\R/",' ', md5(rand(0,1000))));

        $sql = "UPDATE ACCOUNT SET password='$new_password', hash='$hash' WHERE email='$email'";

        if ( $mysqli->query($sql) ) {

        $_SESSION['message'] = "Your password has been reset successfully!";
        header("location: success.php");

        }
    }
    else {
        $_SESSION['message'] = "Two passwords you entered don't match, try again!";
        header("location: error.php");
    }

}
?>
