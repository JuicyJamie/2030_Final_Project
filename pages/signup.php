<?php
  // error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

    require_once("page-scripts/validation.php");

    validateSignUp();
    theResultsSignUp();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Typer's Queue: Sign Up</title>
        <link rel="stylesheet" href="../styles/forms.css">
    </head>
    <body>
        <div id="wrapper">
            <h1>Typer's Queue</h1>
            <div id="form-wrapper">
                <span>Sign Up</span>
                <form action="signup.php" method="post">
                    
                    <label for="email">Email Address: </label>
                    <input type="email" name="email" id="email" placeholder="Enter your email address..." minlength="6">
                    <?php the_validation_message('email'); ?>
                    <label for="username">Username: </label>
                    <input type="text" name="username" id="username" placeholder="Create your username..." minlength="4" maxlength="16">
                    <?php the_validation_message('username'); ?>

                    <label>Password: </label>
                    <input type="password" name="password1" id="password1" placeholder="Create your password..." minlength="5" maxlength="20">
                    <input type="password" name="password2" id="password2" placeholder="Confirm your password..." minlength="5" maxlength="20">
                    <?php the_validation_message('password'); ?>
                    <a href="../index.html">Go Back</a>
                    <input type="submit" value="Sign Up">
                </form>                
            </div>
        </div>
    </body>
</html>