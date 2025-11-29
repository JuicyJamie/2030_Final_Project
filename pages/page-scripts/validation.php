<?php
$valid = false;
$val_messages = Array();

require_once("initialize.php");

function theResultsSignUp()
{
  global $valid;
  global $pdo;

  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if ($valid) {
      sendToDatabase();

      $sql = "SELECT ID FROM user WHERE username = :username AND password = :password";
      $prepped = $pdo->prepare($sql);
      $prepped->bindValue(":username", $_POST['username']);
      $prepped->bindValue(":password", hash("sha256", $_POST['password1']));
      $prepped->execute();
      $row = $prepped->fetch();
      $userID = $row['ID'];
      if (isset($_COOKIE["userID"])) {
        unset($_COOKIE["userID"]);
      }
      setcookie("userID", $userID, time()+60*60*24, "/"); //expire after 1 day
      header("Location: test.html");
    }
  }
}

function theResultsLogin() {
  global $valid;
  global $pdo;
  
    if($_SERVER["REQUEST_METHOD"]=="POST")
  {
    if ($valid) {

      $sql = "SELECT ID FROM user WHERE username = :username AND password = :password";
      $prepped = $pdo->prepare($sql);
      $prepped->bindValue(":username", $_POST['username']);
      $prepped->bindValue(":password", hash("sha256", $_POST['password']));
      $prepped->execute();
      $row = $prepped->fetch();
      $userID = $row['ID'];
      setcookie("userID", $userID);
      header("Location: test.html");
    }
  }
}

function validateSignUp()
{
    global $valid;
    global $val_messages;
    global $pdo;
    $validCount = 0;

    if($_SERVER['REQUEST_METHOD']== 'POST')
    {
      // Use the following patterns to validate email and date or come up with your own.
      // email: '#^(.+)@([^\.].*)\.([a-z]{2,})$#'
      // date: '#^\d{4}/((0[1-9])|(1[0-2]))/((0[1-9])|([12][0-9])|(3[01]))$#'
      if (isset($_POST['email'])) {
        if (!preg_match('#^(.+)@([^\.].*)\.([a-z]{2,})$#', $_POST['email'])) {
          $val_messages['email'] = 'Email is not in correct format.';
          $_POST['email'] = "";
        }
        else {
          $val_messages['email'] = "";
          $validCount ++;
        }
      }

      if (isset($_POST['username'])) {
        $sql = "SELECT COUNT(*) FROM user WHERE username = :username";
        $prepped = $pdo->prepare($sql);
        $prepped->bindValue(":username", $_POST['username']);
        $prepped->execute();

        if ($prepped->fetchColumn() > 0) { //fetchColumn gets a single column from next row or returns false (0) if no rows exist
          $val_messages['username'] = "Username is already taken.";
          $_POST['username'] = "";
        }
        else {
          $val_messages['username'] = "";
          $validCount ++;
        }
      }

      if (isset($_POST['password1']) && isset($_POST['password2'])) {
        if (strcmp($_POST['password1'], $_POST['password2']) != 0) {
            $val_messages['password'] = 'Passwords dont match.';
            $_POST['password1'] = "";
            $_POST['password2'] = "";
        }
        else {
            $val_messages['password'] = "";
            $validCount ++;
        }
      }
      if ($validCount == 3) {
        $valid = true;
      }
      else {
        $valid = false;
      }

    }
}

function validateLogin() {
  global $valid;
  global $val_messages;
  global $pdo;


  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = hash("sha256", $_POST['password']);

    $sql = "SELECT password FROM user WHERE username = :username";
    $prepped = $pdo->prepare($sql);
    $prepped->bindValue(":username", $username);
    $prepped->execute();
    $row = $prepped->fetch();

    if($row) {
      if (strcmp($password, $row['password']) != 0) {
        $val_messages['login'] = "Incorrect password for account " . $username;
        $valid = false;
      }
      else {
        $val_messages['login'] = "";
        $valid = true;
      }
    }
    else {
      $val_messages['login'] = "No account was found with the username " . $username;
      $valid = false;
    }
  }
}

function the_validation_message($type) {

  global $val_messages;

  if($_SERVER['REQUEST_METHOD']== 'POST')
  {
    echo "<p class='failure-message'>";
    echo $val_messages[$type];
    echo "</p>";
  }
}

function sendToDatabase() {
  global $pdo;

  $sql = "INSERT INTO user (username, email, password, joinDate) VALUES (:username, :email, :password, :joinDate)";
  $prepped = $pdo->prepare($sql);
  $prepped->bindValue(":username", $_POST['username']);
  $prepped->bindValue(":email", $_POST['email']);
  $prepped->bindValue(":password", hash("sha256", $_POST['password1']));
  $prepped->bindValue(":joinDate", date("y-m-d"));
  $prepped->execute();
}
