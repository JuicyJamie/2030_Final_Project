<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';

function db_connect() {

  try {
    $connectionString = "mysql:host=". DBHOST . ";dbname=" . DBNAME;
    
    $pdo = new PDO($connectionString, DBUSER, DBPASS);
    return $pdo;
  }
  catch (PDOException $e)
  {
    die($e->getMessage());
  }
}

function handle_form_submission() {
  global $pdo;

  if($_SERVER["REQUEST_METHOD"] == "POST")
  {
    // TODO
    $sql = "INSERT INTO comments (date, mood, email, commentText) VALUES (:date, :mood, :email, :commentText)";
    $prepped = $pdo->prepare($sql);
    $prepped->bindValue(':date', date("y-m-d"));
    $prepped->bindValue(':mood', $_POST["mood"]);
    $prepped->bindValue(':email', $_POST["email"]);
    $prepped->bindValue(':commentText', $_POST["comment"]);
    $prepped->execute();
  }
}

// Get all comments from database and store in $comments
function get_comments() {
  global $pdo;
  global $comments;

  //TODO
  $sql = "SELECT * FROM comments ORDER BY ID DESC;";
  $results = $pdo->query($sql);
  $index = 0;
  while ($row = $results->fetch()) {
    $comments[$index] = $row;
    $index ++;
  }
}

// Get unique email addresses and store in $commenters
function get_commenters() {
  global $pdo;
  global $commenters;

  //TODO
  $sql = "SELECT DISTINCT email FROM comments;";
  $results = $pdo->query($sql);
  $index = 0;
  while ($row = $results->fetch()) {
    $commenters[$index] = $row;
    $index ++;
  }
}