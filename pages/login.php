<?php
  // error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("page-scripts/validation.php");

  validateLogin();
  theResultsLogin();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Typer's Queue: Log In</title>
        <link rel="stylesheet" href="../styles/forms.css">
    </head>
    <body>
        <div id="wrapper">
            <h1>Typer's Queue</h1>
            <div id="form-wrapper">
                <span>Log In</span>
                <form action="login.php" method="post">
                    <!-- add arialabels -->
                    <label for="username">Email Address: </label>
                    <input type="text" name="username" id="username" placeholder="Enter your username..." minlength="4" maxlength="16">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" placeholder="Enter your password..." minlength="5" maxlength="20">
                    <?php the_validation_message('login'); ?>
                    <a href="../index.html">Go Back</a>
                    <input type="submit" value="Log In" >
                </form>                
            </div>
        </div>
    </body>
</html>