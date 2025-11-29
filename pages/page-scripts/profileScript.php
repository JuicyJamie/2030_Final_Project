<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once("initialize.php");
    $pastResults = [];

function getUserInformation() {
    global $pdo;

    if (isset($_COOKIE["userID"])) {
        $currentUser = $_COOKIE["userID"];
        $sql = "SELECT username, email, joinDate FROM user WHERE ID = :id";
        $prepped = $pdo->prepare($sql);
        $prepped->bindValue(":id", $currentUser);
        $prepped->execute();

        $row = $prepped->fetch();
        if ($row) {
            echo "<span id='username'>Username: " . $row['username'] . "</span>";
            echo "<span id='email'>Email: " . $row['email'] . "</span>";
            echo "<span id='JoinDate'>Join Date: " . $row['joinDate'] . "</span>";
        }
    }
}

function getPastResults() {
    global $pdo;
    global $pastResults;

    if (isset($_COOKIE["userID"])) {
        $currentUser = $_COOKIE["userID"];
        $sql = "SELECT wpm, testTitle, time, accuracy FROM test WHERE userID = :id ORDER BY ID DESC";
        $prepped = $pdo->prepare($sql);
        $prepped->bindValue(":id", $currentUser);
        $prepped->execute();

        $index = 0;
        while ($row = $prepped->fetch()) {
            $pastResults[$index] = $row;
            $index ++;
        }

        foreach($pastResults as $result) {
            echo "<div class='result'>";
            echo "<span class='testTitle'>Test: " . $result['testTitle'] . "</span>";
            echo "<span class='WPM'>WPM: " . $result['wpm'] . "</span>";
            echo "<span class='time'>Time: " . $result['time'] . "</span>";
            echo "<span class='accuracy'>Accuracy: " . $result['accuracy'] . "%</span>";
            echo "</div>";
        }
    }
}

