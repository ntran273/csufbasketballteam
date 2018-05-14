<?php
/* Main page with two forms: sign up and log in */
session_start();
?>


<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <?php include 'css/css.html'; ?>
</head>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['login'])) { //user logging in

        require 'login.php';
    }

    elseif (isset($_POST['register'])) { //user registering

        require 'register.php';

    }
}
?>
<body>
  <div class="top-banner">

      <li class="company-name" align="center">
        <h1>NPK Management </h1>
        <h2>Basketball Team Management Website</h2>
      </li>


  </div>

  <div class="form">

      <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
      </ul>

      <div class="tab-content">

         <div id="login">
          <h1>Welcome Back!</h1>

          <form action="index.php" method="post" autocomplete="off">

            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email" required autocomplete="off" name="email"/>
          </div>

          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off" name="password"/>
          </div>

          <p class="forgot"><a href="ForgotPassword.php">Forgot Password?</a></p>

          <button class="button button-block" name="login" />Log In</button>

          </form>

        </div>

        <div id="signup">
          <h1>Sign Up</h1>

          <form action="index.php" method="post" autocomplete="off">

          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>

            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='lastname' />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='email' />
          </div>

          <div class="field-wrap">
            <label>
              Create A Password <span class="req">*</span>
            </label>
            <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number and one uppercase
            and lowercase letter, and at least 8 or more characters" required autocomplete="off" name='password'/>
          </div>

          <button type="submit" class="button button-block" name="register" />Register</button>

          </form>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->

<footer>
  <h2> ® NPK Management </h2>
  <h4> Phone: 1800-CSUF</h4>
</footer>
    <!-- <div class="footer">
      <h2> ® NPK Management </h2>
      <h3> We are team at CSUF </h3>
      <h4> CSUF DEPARTMENT</h4>
      <h4> Phone: 1800-CSUF</h4>
    </div> -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>
