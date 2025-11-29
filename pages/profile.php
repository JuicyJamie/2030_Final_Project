<?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once("page-scripts/profileScript.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Typer's Queue: Profile</title>
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
        <link rel="stylesheet" href="../styles/profile.css">
    </head>
    <body>
        <div id="wrapper">
            <div id="leftSide">
                <img src="../pictures/pfp.png" alt="profile-icon">
                <div id="userInformation">
                   <?php getUserInformation()?>
                </div>
                <div id="buttonWrapper">
                    <button onclick="goBack()">Go Back</button>
                    <button onclick="logOut()">Log out</button>    
                </div>
            </div>
            <div id="pastResults">
                <h1>Past 10 Results</h1>
                <?php getPastResults()?>
            </div>
        </div>
    </body>
    <script>
        function goBack() {
            window.location.href = "test.html";
        }

        function logOut() {
            document.cookie = "userID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"
            window.location.href = "../index.html";
        }
    </script>
</html>