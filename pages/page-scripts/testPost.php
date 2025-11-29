<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("initialize.php");

if (isset($_POST['userID'])) {
    $userID = $_POST['userID'];
}
if (isset($_POST['wpm'])) {
    $wpm = $_POST['wpm'];
}
if (isset($_POST['testTitle'])) {
    $testTitle = $_POST['testTitle'];
}
if (isset($_POST['time'])) {
    $time = $_POST['time'];
}
if (isset($_POST['accuracy'])) {
    $accuracy = $_POST['accuracy'];
}

$sql = "INSERT INTO test (userID, wpm, testTitle, time, accuracy) VALUES (:userID, :wpm, :testTitle, :time, :accuracy)";
$prepped = $pdo->prepare($sql);
$prepped->bindValue(":userID", $userID);
$prepped->bindValue(":wpm", $wpm);
$prepped->bindValue(":testTitle", $testTitle);
$prepped->bindValue(":time", $time);
$prepped->bindValue(":accuracy", $accuracy);
$prepped->execute();
